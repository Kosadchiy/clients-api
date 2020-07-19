<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientPhone extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $phoneId = $this->route('email');
        return [
            'phone' => [
                'required',
                'string',
                Rule::unique('client_phones')->ignore($phoneId)
            ]
        ];
    }
}
