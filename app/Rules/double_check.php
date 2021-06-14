<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class double_check implements Rule
{
    public $passwd;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($passwd)
    {
        $this->passwd = $passwd;
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
        if($value == $this->passwd){
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
        return 'パスワードが一致していません。';
    }
}
