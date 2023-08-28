<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AddUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() 
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'sex' => 'required',
            'blood_type' => 'required',
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Name is required',
            'name.min' => 'Name should be more than 5 letters',


            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already in use.',

            'password.required' => 'Password is required',
            'password.min' => 'Password should consist of 6 characters or more',

            'sex.required' => 'Sex is required',

            'blood_type.required' => "Blood Type is required",
        ];
    }
}