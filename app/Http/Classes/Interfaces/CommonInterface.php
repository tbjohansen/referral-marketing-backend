<?php

namespace App\Http\Classes\Interfaces;

interface CommonInterface
{
    /**
     * create new database resource
     * @param array $payload
     * @return mixed
     */
    static function create(array $payload): mixed;

    /**
     * get all database resources
     * @return mixed
     */
    static function getAll(): mixed;

    /**
     * get database resource by id
     * @param string $id
     * @return mixed
     */
    static function getById(string $id): mixed;

    /**
     * get database resource by query
     * @param array $query
     * @return mixed
     */
    static function getByQuery(array $query): mixed;

    /**
     * get single databse resource by query
     * @param array $query
     * @return mixed
     */
    static function getSingleByQuery(array $query): mixed;

    /**
     * update databse resource by id
     * @param string $id
     * @param array $payload
     * @return mixed
     */
    static function updateById(string $id, array $payload): mixed;

    /**
     * delete database resource by id
     * @param string $id
     * @return bool
     */
    static function deleteById(string $id): bool;
}