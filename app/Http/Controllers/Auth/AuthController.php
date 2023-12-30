<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\GlobalHelpers;
use App\Http\Helpers\HttpResponse;
use App\Http\Repositories\UserRepository;
use App\Http\Validations\AuthValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * LOGIN user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request){
        try {
            // => Validate request 
            $validationErrors = AuthValidation::loginValidation($request);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }
    
            // => Check if user exist
            $query = ['email' => $request->email];
            $user = UserRepository::getSingleByQuery($query);
            if (!$user) {
                return HttpResponse::error('Provided email is not valid', null);
            }
    
            // => match user password
            $matchPassword = Hash::check($request->password, $user->password);
            if (!$matchPassword) {
                return HttpResponse::error('Provided credatial is not valid');
            }

            // => create token
            $token = $user->createToken('RMP-'.$user->email)->plainTextToken;

            // => Update last login
            UserRepository::updateByQuery($query, ['last_login' => Carbon::now()]);
    
            // => response
            $data = [
                'user' => $user,
                'token' => $token
            ];
            return HttpResponse::success('User login successfully', $data);
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
    
    /**
     * CHANGE password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function changePassword(Request $request){
        try {
            // => user ID
            $user_id = Auth::id();

            // => Validate req details
            $validationErrors = AuthValidation::changePasswordValidation($request);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Get user profile
            $user = UserRepository::getForMetaData($user_id);

            // => Verify current password
            $current_password = $request->current_password;
            $new_password = $request->new_password;
            $verify_password = Hash::check($current_password, $user->password);
            if (!$verify_password) {
                return HttpResponse::error("Current password is not correct. Please enter valid password");
            }

            // => Change password
            $new_password = Hash::make($new_password);
            $user = UserRepository::update($user_id, ['password' => $new_password]);

            return HttpResponse::success("Password changed successfully", $user);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
    
    /**
     * NEW password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function newPassword(Request $request){
        try {
            // => Request validation 
            $validationErrors = AuthValidation::newPasswordValidation($request); 
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Phone number
            $phoneNumber = GlobalHelpers::phoneNumberFormat($request->email, false);

            // => Check if user exist
            $user = UserRepository::getSingleByQuery(['email' => $email]);
            if (!$user) {
                return HttpResponse::error("User not found.", null, 404);
            }

            // => Change password
            $payload = [
                'password' => Hash::make($request->new_password)
            ];
            $query = ['phone_number' => $phoneNumber];
            // => Change password
            $user = UserRepository::updateByQuery($query, $payload);

            return HttpResponse::success("Password changed successfully", $user);
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * LOGOUT user
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(Request $request){
        try {
            // => delete current user access token
            $logout = $request->user()->currentAccessToken()->delete();
            if (!$logout) {
                return HttpResponse::error('Fail to logout. Please try again.');
            }
            return HttpResponse::success('User logout successfully', null);
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
}
