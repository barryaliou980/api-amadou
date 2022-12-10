<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonInstructorTest extends TestCase
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

    public function testJsonUserReadsAllInstructor()
    {
        $instructors = Instructor::factory(2)->create();

        $response = $this->jsonApi()
            ->expects("instructors")
            ->get('api/v1/instructors');

        $response->assertStatus(200);

        $response->assertFetchedMany($instructors);
    }

    public function testJsonUserCreatesAInstructor()
    {
        Instructor::factory()->create();

        $data = [
            "type" => "instructors",
            "attributes" => [
                "email" => "student9@gmail.com",
                "password" => "student22",
                "first_name" => "amadou",
                "last_name" => "barry",
                "age" => 21,
                "gender" => "M",
            ],
        ];

        $response = $this
            ->jsonApi()
            ->withData($data)
            ->post('api/v1/instructors');

        $response->assertStatus(201);

        $this->assertDatabaseHas('instructors', [
            "email" => "student9@gmail.com",
            "password" => "student22",
            "first_name" => "amadou",
            "last_name" => "barry",
            "age" => 21,
            "gender" => "M",
        ]);
    }

    public function testJsonUserCanGetAInstructor()
    {
        $instructors = Instructor::factory()->create();
        $response = $this
            ->jsonApi()
            ->expects('instructors')
            ->get('api/v1/instructors/' . $instructors->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanGeUpdateInstructor()
    {
        $instructors = Instructor::factory()->create();


        $data = [
            "type" => "instructors",
            'id' => (string) $instructors->id,
            "attributes" => [
                "email" => "student10@gmail.com",
                "password" => "student22",
                "first_name" => "amadou",
                "last_name" => "barry",
                "age" => 21,
                "gender" => "M",
            ],
        ];

        $response = $this

            ->jsonApi()
            ->expects('instructors')
            ->withData($data)
            ->patch('/api/v1/instructors/' . $instructors->id);

        $response->assertFetchedOne($instructors);
    }

    public function testJsonUserCanDeleteInstructor()
    {
        $instructors = Instructor::factory()->create();

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/instructors/' . $instructors->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('instructors', [
            'id' => $instructors->id,
        ]);
    }
}
