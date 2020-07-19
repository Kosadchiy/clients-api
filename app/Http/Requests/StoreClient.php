<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phones' => 'nullable|array',
            'phones.*.phone' => 'string|unique:client_phones',
            'emails' => 'nullable|array',
            'emails.*.email' => 'email|unique:client_emails',
        ];
    }
}
