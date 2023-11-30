<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'phone_number' => 'required|regex:/^09[0-9]{9}$/',
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
            'ship_price' => 'required',
            'resturantCategories' => 'required|array',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'account_number' => 'required|numeric',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'نام رستوران را وارد کنید',
            'phone_number.required' => 'شماره تلفن را وارد کنید',
            'phone_number.regex' => 'شماره تلفن معتبر نیست',
            'ship_price.required' => 'هزینه ارسال رو وارد کنید.',

            'start_time.required' => 'زمان شروع کار الزامی است.',
            'start_time.before' => 'زمان شروع کار باید قبل از زمان پایان باشد.',
            'end_time.required' => 'زمان پایان کار الزامی است.',
            'end_time.after' => 'زمان پایان کار باید پس از زمان شروع باشد.',
            'start_time.after_or_equal' => 'زمان شروع کار باید بعد یا مساوی 09:00 باشد.',
            'end_time.before_or_equal' => 'زمان پایان کار باید قبل یا مساوی 23:59 باشد.',

            'resturantCategories.required' => 'دسته بندی رستوران را انتخاب کنید',

            'profile_image.image' => 'تصویر باید یک فایل تصویر باشد.',
            'profile_image.mimes' => 'تصویر باید از نوع jpeg، png، jpg، gif یا svg باشد.',
            'profile_image.max' => 'حجم تصویر نباید از ۲ مگابایت بیشتر باشد.',

            'account_number.required' => 'شماره حساب را وارد کنید.',
            'account_number.numeric' => 'شماره حساب باید عدد باشد.',
        ];
    }
}
