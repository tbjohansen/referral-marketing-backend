<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Helpers\HttpResponse;
use App\Http\Validations\GlobalValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * get all users
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getUsers(){
        try {
            
            // => Get products
            $users = UserRepository::getAllUsers();
            if (!$users) {
                return HttpResponse::error('No user found', null, 404);
            }

            return HttpResponse::success(count($users). " Users retrived succssfully", $users);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * Get single user by ID
     * @param string $user_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSingleUser(string $user_id)
    {
        try {
            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('user_id', $user_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            $user = UserRepository::getById($user_id);

            if (!$user) {
                return HttpResponse::error('User not found', null, 404);
            }

            return HttpResponse::success('User retrieved successfully', $user);
        } catch (\Throwable $th) {
            return HttpResponse::serverError($th);
        }
    }
}