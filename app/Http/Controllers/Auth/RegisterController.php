<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\GlobalHelpers;
use App\Http\Helpers\HttpResponse;
use App\Http\Repositories\UserRepository;
use App\Http\Validations\AuthValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * REGISTER user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request){
        try {
            // => Validate request 
            $validationErrors = AuthValidation::registerValidation($request);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }
    
            // => Register user
            $payload = $request->merge([
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($request->password),
            ])->only(
                'name',
                'email',
                'password',
                'role_id',
                'email_verified_at',
            );
    
            $user = UserRepository::createUser($payload);
            if (!$user) {
                return HttpResponse::error("Fail to register user. Please try again!");
            }
    
            return HttpResponse::success("Congratulation! Your successfully registered.", $user, 201);
            
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
}
