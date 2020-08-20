<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InstagramUsername implements Rule
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
        // https://blog.jstassen.com/2016/03/code-regex-for-instagram-username-and-hashtags/
        // Two matches @ mentions with no space between @thebox193@discodude
        // Matches with one . in them @disco.dude but not two .. @disco..dude
        // Beginning period not matched @.discodude
        // Ending period not matched @discodude.
        // Match underscores _ @_disco__dude_
        // Max characters of 30 @1234567890123456789012345678901234567890
        return preg_match('/^([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute doesn't appear to be a valid username";
    }
}
