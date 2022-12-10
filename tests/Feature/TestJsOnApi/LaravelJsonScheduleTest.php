<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonScheduleTest extends TestCase
{
    use MakesJsonApiRequests;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private Course $course;
    private Instructor $instructor;
    private Student $student;
    private Subject $subject;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $this->withoutAuthorization();
        $this->course = Course::factory()->create();
        $this->instructor = Instructor::factory()->create();
        $this->student = Student::factory()->create();
        $this->subject = Subject::factory()->create(['course_id' => $this->course->id]);
    }

    public function withoutAuthorization()
    {
        Gate::before(function () {
            return true;
        });

        return $this;
    }

    public function testJsonUserReadsAllSchedule()
    {
        $schedules = Schedule::factory(2)->create(['subject_id' => $this->subject->id, 'instructor_id' => $this->instructor->id, 'student_id' => $this->student->id]);

        $response = $this->jsonApi()
            ->expects("schedules")
            ->get('api/v1/schedules');

        $response->assertStatus(200);

        $response->assertFetchedMany($schedules);
    }

    public function testJsonUserCreatesASchedule()
    {
        $data = [
            "type" => "schedules",
            "attributes" => [
                'day' => '2018-01-01T12:00Z',
                'time_start' => '2018-01-01T12:00Z',
                'time_end' => '2018-01-01T12:00Z',

            ],
            "relationships" => [
                "instructor" => [
                    "data" => [
                        "type" => "instructors",
                        "id" => "" . $this->instructor->id . "",
                    ],
                ],
                "student" => [
                    "data" => [
                        "type" => "students",
                        "id" => "" . $this->student->id . "",
                    ],
                ],
                "subject" => [
                    "data" => [
                        "type" => "subjects",
                        "id" => "" . $this->subject->id . "",
                    ],
                ],
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->post('api/v1/schedules');

        $response->assertStatus(201);
    }

    public function testJsonUserCanGetASchedule()
    {
        $schedule = Schedule::factory()->create([
            'subject_id' => $this->subject->id,
            'instructor_id' => $this->instructor->id, 'student_id' => $this->student->id,
        ]);
        $response = $this
            ->jsonApi()
            ->expects('schedules')
            ->get('api/v1/schedules/' . $schedule->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanUpdateSchedule()
    {
        $schedule = Schedule::factory()->create([
            'subject_id' => $this->subject->id,
            'instructor_id' => $this->instructor->id, 'student_id' => $this->student->id,
        ]);

        $data = [
            "type" => "schedules",
            'id' => (string) $schedule->id,
            "attributes" => [
                'day' => '1977-04-22T01:00:00-05:00',
                'time_start' => '12h',
                'time_end' => '14h',

            ],
            "relationships" => [
                "instructor" => [
                    "data" => [
                        "type" => "instructors",
                        "id" => "" . $this->instructor->id . "",
                    ],
                ],
                "student" => [
                    "data" => [
                        "type" => "students",
                        "id" => "" . $this->student->id . "",
                    ],
                ],
                "subject" => [
                    "data" => [
                        "type" => "subjects",
                        "id" => "" . $this->subject->id . "",
                    ],
                ],
            ],
        ];

        $response = $this

            ->jsonApi()
            ->expects('schedules')
            ->withData($data)
            ->patch('/api/v1/schedules/' . $schedule->id);

        $response->assertFetchedOne($schedule);
    }

    public function testJsonUserCanDeleteSchedule()
    {
        $schedules = Schedule::factory()->create(['subject_id' => $this->subject->id, 'instructor_id' => $this->instructor->id, 'student_id' => $this->student->id]);

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/schedules/' . $schedules->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('schedules', [
            'id' => $schedules->id,
        ]);
    }
}
