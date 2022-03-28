<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
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
     * Правила валидации формы изменения статуса
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                'integer',
                'min:1',
                'max:3'
            ]
        ];
    }
}
