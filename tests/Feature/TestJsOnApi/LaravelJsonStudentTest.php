<?php

namespace Tests\Feature\TestJsOnApi;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use LaravelJsonApi\Testing\MakesJsonApiRequests;
use Tests\TestCase;

class LaravelJsonStudentTest extends TestCase
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

    public function testJsonUserReadsAllStudent()
    {
        $students = Student::factory(2)->create();

        $response = $this->jsonApi()
            ->expects("students")
            ->get('api/v1/students');

        $response->assertStatus(200);

        $response->assertFetchedMany($students);
    }

    public function testJsonUserCreatesAStudent()
    {
        Student::factory()->create();

        $data = [
            "type" => "students",
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
            ->post('api/v1/students');

        $response->assertStatus(201);
    }

    public function testJsonUserCanGetAStudent()
    {
        $students = Student::factory()->create();
        $response = $this
            ->jsonApi()
            ->expects('students')
            ->get('api/v1/students/' . $students->id);

        $response->assertStatus(200);
    }

    public function testJsonUserCanGeUpdateStudent()
    {
        $students = Student::factory()->create();


        $data = [
            "type" => "students",
            'id' => (string) $students->id,
            "attributes" => [
                "email" => "student15@gmail.com",
                "password" => "student22",
                "first_name" => "amadou",
                "last_name" => "barry",
                "age" => 21,
                "gender" => "f",
            ],
        ];

        $response = $this

            ->jsonApi()
            ->expects('students')
            ->withData($data)
            ->patch('/api/v1/students/' . $students->id);

        $response->assertFetchedOne($students);
    }

    public function testJsonUserCanDeleteStudent()
    {
        $students = Student::factory()->create();

        $response = $this
            ->jsonApi()
            ->delete('/api/v1/students/' . $students->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('students', [
            'id' => $students->id,
        ]);
    }
}
