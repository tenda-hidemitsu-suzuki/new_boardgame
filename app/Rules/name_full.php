<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class name_full implements Rule
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
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(preg_match('/^[^ -~｡-ﾟ\x00-\x1f\t]+$/u',$value))
        {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '全角で入力してください.';
    }
}
