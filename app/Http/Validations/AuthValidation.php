<?php

namespace App\Http\Validations;

use Illuminate\Support\Facades\Validator;

class AuthValidation
{

    /**
     * REGISTER validation
     * @param mixed $request
     * @return mixed
     */
    static function registerValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'password' => 'string|required',
        ]);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
   
    /**
     * UPDATE Profile validation
     * @param mixed $request
     * @return mixed
     */
    static function updateProfileValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'string|required',
        ]);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
    
    /**
     * LOGIN validation
     * @param mixed $request
     * @return mixed
     */
    static function loginValidation($request)
    {
        $message = [
            'email.exists' => 'Provided credatial is not valid',
        ];
        $validation = Validator::make($request->all(), [
            'email' => 'string|required|exists:users,email',
            'password' => 'string|required',
        ], $message);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
    
    /**
     * UPDATE Profile validation
     * @param mixed $request
     * @return mixed
     */
    static function profileUpdateValidation($request, $user_id)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|required|unique:users,email,'.$user_id,
        ]);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
    
    
    /**
     * UPDATE Profile validation
     * @param mixed $request
     * @return mixed
     */
    static function changePasswordValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
    
    /**
     * NewPassword validation
     * @param mixed $request
     * @return mixed
     */
    static function newPasswordValidation($request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'string|required',
            'new_password' => 'string|required',
        ]);

        if ($validation->fails()) {
            return $validation->messages()->all()[0];
        }
        return false;
    }
}