<?php

namespace App\Http\Validations;

use Illuminate\Support\Facades\Validator;

class GlobalValidation
{

    /**
     * Validate uuid format
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    static function validateUUID(string $key, string $value, string $name)
    {
        $validator = Validator::make(
            [$key => $value],
            [
                $key => ['uuid', 'required']
            ],
            [
                'uuid' => 'The :attribute is not valid'
            ],
            [
                $key => $name
            ]
        );
        if ($validator->fails()) {
            return $validator->messages()->all()[0];
        }
        return false;
    }
}
