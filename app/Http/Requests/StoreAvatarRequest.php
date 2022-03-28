<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvatarRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
     * Правила валидации для формы загрузки аватарки
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => [
                'required',
                'file',
                'max:5326',
                'image'
            ]
        ];
    }
}
