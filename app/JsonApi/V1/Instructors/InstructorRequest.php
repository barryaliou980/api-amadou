<?php

namespace App\JsonApi\V1\Instructors;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class InstructorRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'age' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
