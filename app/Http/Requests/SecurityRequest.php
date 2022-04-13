<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\EmptyInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SecurityRequest extends FormRequest
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
     * Правила валидации формы сохранения пароля и e-mail
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($request->user),
                ],
            'password' => [
                'nullable',
                'same:passwordRepeat',
                Password::min(8),
            ],
            'passwordRepeat' => [
                'nullable'
            ]
        ];
    }

    /**
     * Сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Вы не заполнили поле e-mail!',
            'email.email' => 'Вы ввели некорректный e-mail!',
            'email.unique' => 'Указанный e-mail уже занят другим пользователем!',
            'password.same' => 'Пароли не совпадают!',
            'password.min' => 'Пароль слишком короткий. Минимальная длинна пароля 8 символов!',
            'passwordRepeat.same' => 'Пароли не совпадают!',
        ];
    }
}
