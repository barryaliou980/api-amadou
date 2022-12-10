<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ScheduleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $this->withoutAuthorization();
    }

    public function withoutAuthorization()
    {
        Gate::before(function () {
            return true;
        });

        return $this;
    }

    public function testUserCanGetAllSubject()
    {
        $course = Course::factory()->create();
        $instructor = Instructor::factory()->create();
        $student = Student::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        Schedule::factory()->create(['subject_id' => $subject->id, 'instructor_id' => $instructor->id, 'student_id' => $student->id]);

        $response = $this->getJson(route('subjects.index'));

        $response->assertSuccessful();
    }

    public function testUserCanCreateSubject()
    {
        $course = Course::factory()->create();
        $instructor = Instructor::factory()->create();
        $student = Student::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        $schedule = [

            'day' => '2022-09-01',
            'time_start' => '9999-12-31 23:59:59',
            'time_end' => '9999-12-31 00:10:50',
            'subject_id' => $subject->id,
            'instructor_id' => $instructor->id,
            'student_id' => $student->id,

        ];
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('schedules.store'), $schedule);

        $response->assertSuccessful();
    }

    public function testUserCanGetASubject()
    {
        $course = Course::factory()->create();
        $instructor = Instructor::factory()->create();
        $student = Student::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        $schedules = Schedule::factory()->create(['subject_id' => $subject->id, 'instructor_id' => $instructor->id, 'student_id' => $student->id]);

        $response = $this->getJson(route('schedules.show', ['schedule' => $schedules]));

        $response->assertSuccessful();
    }

    public function testUserCanUpdateSubject()
    {
        $course = Course::factory()->create();
        $instructor = Instructor::factory()->create();
        $student = Student::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        $schedules = Schedule::factory()->create(['subject_id' => $subject->id, 'instructor_id' => $instructor->id, 'student_id' => $student->id]);

        $playload = [

            'day' => '2022-09-03',
            'time_start' => '9999-12-31 23:59:59',
            'time_end' => '9999-12-31 00:00:00',
            'subject_id' => $subject->id,
            'instructor_id' => $instructor->id,
            'student_id' => $student->id,

        ];
        $this->withoutExceptionHandling();
        $response = $this->putJson(route('schedules.update', ['schedule' => $schedules]), $playload);

        $response->assertSuccessful();
    }

    public function testUserCanDeleteSubject()
    {
        $course = Course::factory()->create();
        $instructor = Instructor::factory()->create();
        $student = Student::factory()->create();
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        $schedules = Schedule::factory()->create(['subject_id' => $subject->id, 'instructor_id' => $instructor->id, 'student_id' => $student->id]);

        $response = $this->deleteJson(route('schedules.destroy', ['schedule' => $schedules]));

        $response->assertSuccessful();
    }
}
