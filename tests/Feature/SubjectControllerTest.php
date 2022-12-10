<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubjectControllerTest extends TestCase
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
        $subject = Subject::factory()->create(['course_id' => $course->id]);
        $response = $this->getJson(route('subjects.index'));
        $response->assertSuccessful();
    }

    public function testUserCanCreateSubject()
    {
        $course = Course::factory()->create();
        $subject = [
            'name' => 'diallo',
            'course_id' => $course->id,
        ];
        $response = $this->postJson(route('subjects.store'), $subject);
        $response->assertSuccessful();
    }

    public function testUserCanGetASubject()
    {
        $course = Course::factory()->create();
        $subjects = Subject::factory()->create(['course_id' => $course->id]);
        $response = $this->getJson(route('subjects.show', ['subject' => $subjects]));
        $response->assertSuccessful();
    }

    public function testUserCanUpdateSubject()
    {
        $course = Course::factory()->create();
        $subjects = Subject::factory()->create(['course_id' => $course->id]);
        $playload = [
            'name' => 'update_name',
            'course_id' => $course->id,
        ];
        $response = $this->putJson(route('subjects.update', ['subject' => $subjects]), $playload);
        $response->assertSuccessful();
    }

    public function testUserCanDeleteSubject()
    {
        $course = Course::factory()->create();
        $subjects = Subject::factory()->create(['course_id' => $course->id]);
        $response = $this->deleteJson(route('subjects.destroy', ['subject' => $subjects]));
        $response->assertSuccessful();
    }
}
