<?php

namespace App\JsonApi\V1\Courses;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class CourseRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'course_name' => ['required', 'string'],
            'course_description' => ['required', 'string'],
            'school_year' => ['nullable', JsonApiRule::dateTime()],
        ];
    }
}
