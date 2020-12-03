<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxDecimalPointsValidation implements Rule
{

    private $maximumNumberOfDecimalPlaces;

    /**
     * @param int $maximumNumberOfDecimalPlaces
     */
    public function __construct($maximumNumberOfDecimalPlaces = 0)
    {
        $this->maximumNumberOfDecimalPlaces = $maximumNumberOfDecimalPlaces;
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
        if (count(explode('.',$value)) > 1){
            return preg_match("/(\.[0-9]{1,{$this->maximumNumberOfDecimalPlaces}})$/", $value);
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Max number of numbers after dot is '.$this->maximumNumberOfDecimalPlaces;
    }
}
