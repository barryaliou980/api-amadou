<?php


use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use Spatie\Activitylog\Models\Activity;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class, 'signin']);
Route::post('register', [LoginController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('instructors', InstructorController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('courses', CourseController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('schedules', ScheduleController::class);
    Route::get('courses/{course}/subjects', [SubjectController::class, 'getSubjetByCourse']);
    Route::get('students/{student}/transactions', [TransactionController::class, 'getTransactionByStudent']);
    Route::get('students/{student}/schedules', [ScheduleController::class, 'getScheduleByStudent']);
    Route::get('instructors/{instructor}/schedules', [ScheduleController::class, 'getScheduleByInstructor']);
    Route::get('subjects/{subject}/schedules', [ScheduleController::class, 'getScheduleBySubject']);




    JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
        $server->resource('students', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasMany('transactions')->readOnly();
                $relations->hasMany('schedules')->readOnly();
            });
        $server->resource('transactions', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasOne('student');
            });
        $server->resource('schedules', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasOne('student');
                $relations->hasOne('instructor');
                $relations->hasOne('subject');
            });

        $server->resource('instructors', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasMany('schedules')->readOnly();
            });

        $server->resource('courses', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasMany('subjects')->readOnly();
            });
        $server->resource('subjects', JsonApiController::class)
            ->relationships(function ($relations) {
                $relations->hasOne('course')->readOnly();
                $relations->hasMany('schedules')->readOnly();
            });
    });
});



Route::get('activity-logs', function () {
    $activities = Activity::orderBy('id', 'desc')->get();

    return response()->json($activities);
});

//  JSON API ROUTES

// JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
//     $server->resource('students', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasMany('transactions')->readOnly();
//             $relations->hasMany('schedules')->readOnly();
//         });
//     $server->resource('transactions', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasOne('student');
//         });
//     $server->resource('schedules', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasOne('student');
//             $relations->hasOne('instructor');
//             $relations->hasOne('subject');
//         });

//     $server->resource('instructors', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasMany('schedules')->readOnly();
//         });

//     $server->resource('courses', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasMany('subjects')->readOnly();
//         });
//     $server->resource('subjects', JsonApiController::class)
//         ->relationships(function ($relations) {
//             $relations->hasOne('course')->readOnly();
//             $relations->hasMany('schedules')->readOnly();
//         });
// });
