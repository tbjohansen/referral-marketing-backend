<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class UtilsHelper
{
    /**
     * Generate id
     * @param mixed $prefix
     * @return string
     */
    static function generateID($prefix)
    {
        $random = mt_rand(100000, 999999);

        return $prefix . $random;
    }

    /**
     * Compare two string values if they are equal
     * @param mixed $value_1
     * @param mixed $value_2
     * @return bool
     */
    static function compareString(string $value_1, string $value_2)
    {
        $result =  Str::lower($value_1) == Str::lower($value_2);

        return $result;
    }

}
