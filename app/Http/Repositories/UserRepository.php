<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    /**
     * Selection list
     * @return array<string>
     */
    static function selection()
    {
        return [
            'users.id as id',
            'users.role_id',
            'roles.role_name',
            'users.name',
            'users.email',
            'users.password',
        ];
    }

    /**
     * Create new user
     * @param array $payload
     * @return mixed
     */
    static function createUser(array $payload)
    {
        $user = User::create($payload);

        if ($user) {
            return $user;
        }

        return false;
    }

    /**
     * Get all users
     * @return \Illuminate\Support\Collection|bool
     */
    static function getAllUsers()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select(
                self::selection()
            )->get();

        if (!count($users)) {
            return false;
        }

        return $users;
    }

    static function getByQuery(string $key, $value)
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where($key, $value)
            ->select(
                self::selection()
            )->get();

        if (count($users) === 0) {
            return false;
        }

        return $users;
    }

    /**
     * Get user by Id
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getById(string $id)
    {
        $user = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $id)
            ->select(
                self::selection()
            )->first();

        if (!$user) {
            return false;
        }

        return $user;
    }
    
    /**
     * Get user by Id for personal expense
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getForMetaData(string $id)
    {
        $user = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $id)
            ->select(
                "role_name",
                "name",
                "email",
            )->first();

        if (!$user) {
            return false;
        }

        return $user;
    }

    /**
     * Get single user by query
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    static function getSingleByQuery(string $key, $value)
    {
        $user = User::where($key, $value)
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select(
                self::selection()
            )->first();

        if (!$user) {
            return false;
        }

        return $user;
    }

    /**
     * Update single user
     * @param string $id
     * @param array $payload
     * @return \Illuminate\Support\Collection|bool
     */
    static function updateUser(string $id, array $payload)
    {
        $user = User::where('id', $id)
            ->update($payload);

        if (!$user) {
            return false;
        }

        $user = self::getById($id);

        return $user;
    }

    /**
     * Delete user
     * @param string $id
     * @return bool
     */
    static function deleteUser(string $id)
    {
        $user = User::where('id', $id)
            ->delete();

        if (!$user) {
            return false;
        }

        return true;
    }
}
