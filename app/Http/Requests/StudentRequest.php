<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
           'email' => [
            'required',
            Rule::unique('students', 'email')->ignore($this->student),
            ],
            "password" => ["required","alpha_num",Rule::when($this->student, 'sometimes')],
            "first_name" => "required|string",
            "last_name" => "required|string",
            "age" => "required",
            "gender" => "required|string",
        ];
    }
}
