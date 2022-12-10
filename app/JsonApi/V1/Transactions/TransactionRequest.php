<?php

namespace App\JsonApi\V1\Transactions;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class TransactionRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'transaction_name' => ['required', 'string'],
            'date' => ['nullable', JsonApiRule::dateTime()],
            'student' => JsonApiRule::toOne(),
        ];
    }
}
