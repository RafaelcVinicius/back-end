<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'name'     => 'name',
            'email'    => 'email',
            'password' => 'password'
        ];
    }
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => ['required', 'min:5'],
            'email'    => ['required', 'email'],
            'password' => ['required']
        ];
    }
}
