<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseControllerTest extends TestCase
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
    }

    public function testUserCanGetAllCourse()
    {
        $course = Course::factory(5)->create();
        $response = $this->getJson(route('courses.index'));
        $response
            ->assertSuccessful();
    }

    public function testUserCanCreateCourse()
    {
        $course = [
            'course_name' => 'pyhysique',
            'course_description' => 'important de faire la physisque',
            'school_year' => '2022/03/04',
        ];
        $response = $this->json('POST', 'api/courses', $course);
        $response
            ->assertSuccessful();
        $this->assertDatabaseHas('courses', $course);
    }

    public function testUserCanGetACourse()
    {
        $course = Course::factory()->create();
        $response = $this->json('GET', 'api/courses', ['course' => $course]);
        $response
            ->assertSuccessful()
            ->assertJson(
                [$course->toArray()]
            );
    }

    public function testUserCanUpdateCourse()
    {
        $course = Course::factory()->create();
        $playload = [
            'course_name' => 'chimie',
            'course_description' => 'passable de me dire que ',
            'school_year' => '2022/03/04',
        ];
        $response = $this->putJson(route('courses.update', ['course' => $course]), $playload);
        $response->assertSuccessful();
    }

    public function testUserCanDeleteCourse()
    {
        $course = Course::factory()->create();
        $response = $this->deleteJson(route('courses.destroy', ['course' => $course]));
        $response->assertSuccessful();
    }
}
