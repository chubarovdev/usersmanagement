<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class NewUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                Password::min(8)
            ],
            'status' => [
                'integer',
                'min:1',
                'max:3'
            ],
            'avatar' => [
                'nullable',
                'file',
                'max:5326',
                'image'
            ],
            'vk_link' => [
                'url',
                'nullable'
            ],
            'telegram_link' => [
                'url',
                'nullable'
            ],
            'instagram_link' => [
                'url',
                'nullable'
            ]
        ];
    }
}
