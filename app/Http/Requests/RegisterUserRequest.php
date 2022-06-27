<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'bail|required|alpha|string|min:2',
            'email'=>'bail|required|unique:users|string',
            'type'=>'bail|required|string',
            'github'=>'bail|required|url|string',
            'city'=>'bail|required|string',
            'phone'=>'bail|required|digits:11',
            'birthday'=>'bail|required|date|string',
        ];
    }
}
