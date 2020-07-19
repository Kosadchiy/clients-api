<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchClient extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search_type' => 'required|in:all,name,phone,email',
            'query_string' => 'required|string|max:256'
        ];
    }
}
