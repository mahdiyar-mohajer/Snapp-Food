<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
//            'password_confirmation' => 'required|confirmed',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسمتو ننوشتی',
            'email.required' => 'ایمیلتو بزن',
            'email.email' => 'ایمیل درست بزن',
            'password.required' => 'پسووردتو بزن',
            'password.confirmed' => 'پسووردتو اشتباه زدی',
//            'password_confirmation.confirmed' => 'پسووردتو اشتباه زدی',
//            'password_confirmation.required' => 'پسووردتو بزن',
        ];
    }
}
