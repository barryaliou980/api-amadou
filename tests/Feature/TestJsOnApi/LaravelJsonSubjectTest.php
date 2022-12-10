<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonSubjectTest extends TestCase
{
    use MakesJsonApiRequests;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        $this->withoutAuthorization();
        $this->course = Course::factory()->create();
    }

    public function withoutAuthorization()
    {
        Gate::before(function () {
            return true;
        });

        return $this;
    }

    public function testJsonUserReadsAllSubject()
    {
        $subject = Subject::factory(2)->create(['course_id' => $this->course->id]);

        $response = $this->jsonApi()
            ->expects("subjects")
            ->get('api/v1/subjects');

        $response->assertStatus(200);
        $response->assertFetchedMany($subject);
    }

    public function testJsonUserCreatesASubject()
    {
        $data = [
            "type" => "subjects",
            "attributes" => [
                "name" => "Sujet 1",
            ],
            "relationships" => [
                "course" => [
                    "data" => [
                        "type" => "courses",
                        "id" => (string)$this->course->id,
                    ],
                ],
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->post('api/v1/subjects');

        $response->assertStatus(201);
    }

    public function testJsonUserCanGetASubject()
    {
        $subjects = Subject::factory()->create(['course_id' => $this->course->id]);
        $response = $this
            ->jsonApi()
            ->expects('subjects')
            ->get('api/v1/subjects/' . $subjects->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanGeUpdateSubject()
    {
        $subjects = Subject::factory()->create(['course_id' => $this->course->id]);


        $data = [
            "type" => "subjects",
            'id' => (string) $subjects->id,
            "attributes" => [
                "name" => "diallo",
            ],
            "relationships" => [
                "course" => [
                    "data" => [
                        "type" => "courses",
                        "id" => (string) $this->course->id,
                    ],
                ],
            ],
        ];

        $response = $this

            ->jsonApi()
            ->expects('subjects')
            ->withData($data)
            ->patch('/api/v1/subjects/' . $subjects->id);

        $response->assertFetchedOne($subjects);
    }

    public function testJsonUserCanDeleteSubject()
    {
        $subjects = Subject::factory()->create(['course_id' => $this->course->id]);

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/subjects/' . $subjects->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('subjects', [
            'id' => $subjects->id,
        ]);
    }
}
