<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmptyInput implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Правило валидации при отправлении пустого поля (отправка пробела)
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return trim($value) == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Поле является пустым!';
    }
}
