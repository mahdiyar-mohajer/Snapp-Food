<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'start_time' => [
                'bail',
                'required',
                'before:end_time',
                'date_format:H:i',
                'after_or_equal:09:00',
                'before_or_equal:23:59',
            ],
            'end_time' => [
                'bail',
                'required',
                'after:start_time',
                'date_format:H:i',
                'after_or_equal:09:00',
                'before_or_equal:23:59',
            ],
            'discount' => 'bail|required|numeric',
        ];
    }
    public function messages(): array
    {
        return [

            'discount.required' => 'درصد تخفیف اجباری است.',
            'discount.numeric' => 'درصد تخفیف باید عدد باشد.',
            'start_time.required' => 'زمان شروع الزامی است.',
            'start_time.before' => 'زمان شروع باید قبل از زمان پایان باشد.',
            'end_time.required' => 'زمان پایان الزامی است.',
            'end_time.after' => 'زمان پایان باید پس از زمان شروع باشد.',
            'start_time.after_or_equal' => 'زمان شروع باید بعد یا مساوی 09:00 باشد.',
            'end_time.before_or_equal' => 'زمان پایان باید قبل یا مساوی 23:59 باشد.'
        ];
    }
}


