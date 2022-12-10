<?php

namespace Tests\Feature;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class InstructorControllerTest extends TestCase
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

    public function testUserCanGetAllInstructor()
    {
        $instructor = Instructor::factory()->create();
        $response = $this->json('GET', 'api/instructors');
        $response->assertSuccessful();
    }

    public function testUserCanCreateInstructor()
    {
        $instructor = [
            'email' => 'amadou@gmail.com',
            'password' => 'ama2000',
            'first_name' => 'alseny',
            'last_name' => 'kaba',
            'age' => 28,
            'gender' => 'm',
        ];
        $response = $this->json('POST', 'api/instructors', $instructor);
        $response->assertSuccessful();
    }

    public function testUserCanGetAInstructor()
    {
        $instructor = Instructor::factory()->create();
        $response = $this->json('GET', 'api/instructors', ['instructor' => $instructor]);
        $response->assertSuccessful();
    }

    public function testUserCanUpdateInstructor()
    {
        $instructor = Instructor::factory()->create();
        $playload = [
            'email' => 'amadou28@gmail.com',
            'password' => 'ama2000',
            'first_name' => 'amadou',
            'last_name' => 'kaba',
            'age' => 28,
            'gender' => 'm',
        ];
        $this->withoutExceptionHandling();
        $response = $this->putJson(route('instructors.update', ['instructor' => $instructor]), $playload);
        $response->assertSuccessful();
    }

    public function testUserCanDeleteInstructor()
    {
        $instructor = Instructor::factory()->create();
        $response = $this->deleteJson(route('instructors.destroy', ['instructor' => $instructor]));
        $response->assertSuccessful();
    }
}
