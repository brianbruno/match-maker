<?php

namespace App\Rules;

use App\Http\Controllers\LeagueController;
use Illuminate\Contracts\Validation\Rule;

class ValidUsername implements Rule
{
    private $value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->value = $value;
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
        $league = new LeagueController();
        return $league->getUserInfo($this->value) != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'League user not found.';
    }
}
