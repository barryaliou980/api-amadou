<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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

    public function testUserCanGetAllStudent()
    {
        $student = Student::factory(2)->create();
        $response = $this->json('GET', 'api/students');
        $response->assertSuccessful();
    }

    public function testUserCanCreateStudent()
    {
        $student = [
            'email' => 'amadou@gmail.com',
            'password' => 'ama2000',
            'first_name' => 'alseny',
            'last_name' => 'kaba',
            'age' => 28,
            'gender' => 'm',
        ];

        $response = $this->json('POST', 'api/students', $student);
        $response->assertSuccessful();
    }

    public function testUserCanGetAStudent()
    {
        $student = Student::factory()->create();
        $response = $this->json('GET', 'api/students/', ['student' => $student]);
        $response->assertSuccessful();
    }

    public function testUserCanUpdateStudent()
    {
        $student = Student::factory()->create();
        $playload = [
            'email' => 'kalinko@gmail.com',
            'password' => 'kalinko15',
            'first_name' => 'bintou',
            'last_name' => 'sylla',
            'age' => 28,
            'gender' => 'f',
        ];
        $response = $this->putJson(route('students.update', ['student' => $student]), $playload);
        $response->assertSuccessful();
    }

    public function testUserCanDeleteStudent()
    {
        $student = Student::factory()->create();
        $this->withoutExceptionHandling();
        $response = $this->deleteJson(route('students.destroy', ['student' => $student]));
        $response->assertSuccessful();
    }
}
