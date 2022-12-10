<?php

namespace App\JsonApi\V1\Schedules;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class ScheduleRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // @TODO
            'student' => JsonApiRule::toOne(),
            'instructor' => JsonApiRule::toOne(),


            'subject' => JsonApiRule::toOne(),

            'day' => JsonApiRule::dateTime(),
            'time_start' => ['required', 'string'],
            'time_end' => ['required', 'string'],
        ];
    }
}
