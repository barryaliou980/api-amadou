<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Models\Instructor;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Schedule::class);

        return response()->json(Schedule::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $this->authorize('create', Schedule::class);
        $schedule = Schedule::create($request->validated());

        return response()->json(['schedule' => $schedule], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        $this->authorize('viewAny', Schedule::class);

        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->authorize('update', Schedule::class);
        $schedule->update($request->validated());

        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', Schedule::class);
        $schedule->delete();

        return response()->json('schedule delete successfuly');
    }

    public function getScheduleByStudent(Student $student)
    {
        $this->authorize('viewAny', Schedule::class);

        return response()->json($student->schedules);
    }

    public function getScheduleByInstructor(Instructor $instructor)
    {
        $this->authorize('viewAny', Schedule::class);

        return response()->json($instructor->schedules);
    }

    public function getScheduleBySubject(Subject $subject)
    {
        $this->authorize('viewAny', Schedule::class);

        return response()->json($subject->schedules);
    }
}
