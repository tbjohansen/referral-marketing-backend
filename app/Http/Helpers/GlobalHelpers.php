<?php

namespace App\Http\Helpers;

class GlobalHelpers
{

    /**
     * Generate slug id
     * @param mixed $prepend
     * @param mixed $append
     * @return string
     */
    static function getSlugID($prepend) {
        $generatedNum = mt_rand(1000, 9999);
        $slugID = $prepend.'-' . $generatedNum;
        return strtoupper($slugID);
    }

    /**
     * Generate registration id
     * @param mixed $prepend
     * @param mixed $append
     * @return string
     */
    static function getRegistrationNumber($prefix) {
        $generatedNum = mt_rand(1000, 9999);
        $regID = $prefix.'-' . $generatedNum;
        return strtoupper($regID);
    }

}
