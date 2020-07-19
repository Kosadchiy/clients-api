<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClient extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'surname' => 'sometimes|string|max:255',
            'phones' => 'nullable|array',
            'phones.*.phone' => 'string|unique:client_phones',
            'emails' => 'nullable|array',
            'emails.*.email' => 'email|unique:client_emails',
        ];
    }
}
