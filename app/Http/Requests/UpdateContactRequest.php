<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'name' => 'required|string',
            'phone_number' => 'required|digits:9|regex:/^[679]\d{8}$/',
            'email' => 'required | email',
            'age' => 'required | integer | min:1 | max:100'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'phone_number.required' => 'A phone number is required',
            'phone_number.digits:9' => 'A phone number must have 9 digits',
            'email.required' => 'A email is required',
            'email.email' => 'The email is not valid',
            'age.required' => 'The  age is required',
            'age.integer' => 'The age must be a number',
        ];;
    }
}
