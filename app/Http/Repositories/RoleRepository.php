<?php

namespace App\Http\Repositories;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleRepository
{

    /**
     * Selection list
     * @return array<string>
     */
    static function selection()
    {
        return [
            'roles.id as id',
            'roles.role_name',
        ];
    }

    /**
     * Create new role
     * @param array $payload
     * @return mixed
     */
    static function createRole(array $payload)
    {
        $role = Role::create($payload);

        if ($role) {
            return $role;
        }

        return false;
    }

    /**
     * Get all roles
     * @return \Illuminate\Support\Collection|bool
     */
    static function getAllRoles()
    {
        $roles = DB::table('roles')
            ->select(
                self::selection()
            )->get();

        if (!count($roles)) {
            return false;
        }

        return $roles;
    }

    static function getByQuery(string $key, $value)
    {
        $roles = DB::table('roles')
            ->where($key, $value)
            ->select(
                self::selection()
            )->get();

        if (count($roles) === 0) {
            return false;
        }

        return $roles;
    }

    /**
     * Get role by Id
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getById(string $id)
    {
        $role = DB::table('roles')
            ->where('roles.id', $id)
            ->select(
                self::selection()
            )->first();

        if (!$role) {
            return false;
        }

        return $role;
    }
    
    /**
     * Get role by Id for registration
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getForMetaData(string $id)
    {
        $role = DB::table('roles')
            ->where('roles.id', $id)
            ->select(
                "role_name",
            )->first();

        if (!$role) {
            return false;
        }

        return $role;
    }

    /**
     * Get single role by query
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    static function getSingleByQuery(string $key, $value)
    {
        $role = Role::where($key, $value)
            ->select(
                self::selection()
            )->first();

        if (!$role) {
            return false;
        }

        return $role;
    }

    /**
     * Update single role
     * @param string $id
     * @param array $payload
     * @return \Illuminate\Support\Collection|bool
     */
    static function updateRole(string $id, array $payload)
    {
        $role = Role::where('id', $id)
            ->update($payload);

        if (!$role) {
            return false;
        }

        $role = self::getById($id);

        return $role;
    }

    /**
     * Delete role
     * @param string $id
     * @return bool
     */
    static function deleteRole(string $id)
    {
        $role = Role::where('id', $id)
            ->delete();

        if (!$role) {
            return false;
        }

        return true;
    }
}
