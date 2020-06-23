<?php


namespace App\Helpers;


class StringHelper
{
    /**
     * Shouts a string or quote according some rules
     *
     * @param string $str
     * @return string
     */
    public static function shout(string $str)
    {
        /*
          Based on the given example, 3 rules apply when shouting a string :
          1. The string is capitalized
          2. Dots at the end of the string become exclamation marks
          3. No need to concat an extra exclamation mark is the string already has one
        */

        $shout = strtoupper($str);

        if ($shout[-1] === '.') {
            $shout[-1] = '!';
        }

        return $shout;
    }
}