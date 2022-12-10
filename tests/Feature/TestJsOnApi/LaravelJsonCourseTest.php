<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonCourseTest extends TestCase
{
    use MakesJsonApiRequests;

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

    public function testJsonUserReadsAllCourse()
    {
        $courses = Course::factory(2)->create();

        $response = $this->jsonApi()
            ->expects("courses")
            ->get('api/v1/courses');

        $response->assertStatus(200);

        $response->assertFetchedMany($courses);
    }

    public function testJsonUserCreatesACourse()
    {
        $data = [
            "type" => "courses",
            "attributes" => [
                "course_name" => "Physic",
                "course_description" => "genial",
                "school_year" => "2022-01-01T12:00:00.000000Z",
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->post('api/v1/courses');

        $response->assertStatus(201);

        $this->assertDatabaseHas('courses', [
            "course_name" => "Physic",
            "course_description" => "genial",
        ]);
    }

    public function testJsonUserCanGetACourse()
    {
        $course = Course::factory()->create();
        $response = $this
            ->jsonApi()
            ->expects('courses')
            ->get('api/v1/courses/' . $course->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanGeUpdateCourses()
    {
        $course = Course::factory()->create();


        $data = [
            "type" => "courses",
            'id' => (string) $course->id,
            "attributes" => [
                "course_name" => "bah",
                "course_description" => " genial",
                "school_year" => "2018-01-01T12:00Z",
            ],
        ];

        $response = $this

            ->jsonApi()
            ->expects('courses')
            ->withData($data)
            ->patch('/api/v1/courses/' . $course->id);

        $response->assertFetchedOne($course);
    }

    public function testJsonUserCanDeleteCourse()
    {
        $courses = Course::factory()->create();

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/courses/' . $courses->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('courses', [
            'id' => $courses->id,
        ]);
    }
}
