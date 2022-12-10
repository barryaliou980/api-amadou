<?php

namespace App\JsonApi\V1;

use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{
    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
        Auth::user();
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            // @TODO
            Students\StudentSchema::class,
            Transactions\TransactionSchema::class,
            Schedules\ScheduleSchema::class,
            Instructors\InstructorSchema::class,
            Courses\CourseSchema::class,
            Subjects\SubjectSchema::class,
        ];
    }
}
