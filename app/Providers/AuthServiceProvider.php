<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Transaction;
use App\Policies\CoursePolicy;
use App\Policies\InstructorPolicy;
use App\Policies\SchedulePolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Instructor::class => InstructorPolicy::class,
        Student::class => StudentPolicy::class,
        Course::class => CoursePolicy::class,
        Subject::class => SubjectPolicy::class,
        Schedule::class => SchedulePolicy::class,
        Transaction::class => TransactionPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
