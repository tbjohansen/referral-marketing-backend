<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\HttpResponse;
use App\Http\Repositories\RoleRepository;
use App\Http\Validations\GlobalValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * GET all roles
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllRoles(){
        try {
            
            // => Get roles
            $roles = RoleRepository::getAllRoles();
            if (!$roles) {
                return HttpResponse::error('No role found', null, 404);
            }

            return HttpResponse::success(count($roles). " Roles retrived succssfully", $roles);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * ADD roles
     * @param \Illuminate\Http\Request $request
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createRole(Request $request){
        // try {
            
        //     // => Create role
        //     $payload = [
        //         "role_name" => $request->role_name,
        //     ];

        //     $role = RoleRepository::createRole($payload);

        //     if (!$role) {
        //         return HttpResponse::error("Fail to add role. Please try again!");
        //     }

        //     return HttpResponse::success("Role added successfully", $role);

        // } catch (\Throwable $th) {
        //     return HttpResponse::severError($th);
        // }

        // => Create role
        $payload = [
            "role_name" => $request->role_name,
        ];

        $role = RoleRepository::createRole($payload);

        if (!$role) {
            return HttpResponse::error("Fail to add role. Please try again!");
        }

        return HttpResponse::success("Role added successfully", $role);
    }

    /**
     * UPDATE role
     * @param \Illuminate\Http\Request $request
     * @param string $role_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateRole(Request $request, string $role_id){
        try {
            
            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('role_id', $role_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Get role
            $role = RoleRepository::getForMetaData($role_id);
            if (!$role) {
                return HttpResponse::error("Role details not found", null, 404);
            }
            
            // => Update role
            $payload = [
                "role_name" => $request->role_name,
            ];
            $role = RoleRepository::updateRole($role_id, $payload);

            if (!$role) {
                return HttpResponse::error("Fail to update role. Please try again!");
            }

            return HttpResponse::success("Role updated successfully", $role);
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * DELETE role
     * @param string $role_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteRole(string $role_id){
        try {

            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('role_id', $role_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Get role
            $product = RoleRepository::getForMetaData($role_id);
            if (!$product) {
                return HttpResponse::error("Role details not found", null, 404);
            }

            // => Delete role
            $deleteProduct = RoleRepository::deleteRole($role_id);
            if (!$deleteProduct) {
                return HttpResponse::error("Fail to delete role. Please try again!");
            }

            return HttpResponse::success("Role deleted successfully");

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
}
