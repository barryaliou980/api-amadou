<?php

namespace App\JsonApi\V1\Students;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class StudentRequest extends ResourceRequest
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
            // 'publishedAt' => ['nullable', JsonApiRule::dateTime()],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'age' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
