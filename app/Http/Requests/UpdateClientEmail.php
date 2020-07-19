<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientEmail extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $emailId = $this->route('email');
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('client_emails')->ignore($emailId)
            ]
        ];
    }
}
