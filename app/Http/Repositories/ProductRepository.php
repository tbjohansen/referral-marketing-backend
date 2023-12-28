<?php

namespace App\Http\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{

    /**
     * Selection list
     * @return array<string>
     */
    static function selection()
    {
        return [
            'products.id as id',
            'products.name',
            'products.description',
            'products.price',
        ];
    }

    /**
     * Create new product
     * @param array $payload
     * @return mixed
     */
    static function createProduct(array $payload)
    {
        $product = Product::create($payload);

        if ($product) {
            return $product;
        }

        return false;
    }

    /**
     * Get all users
     * @return \Illuminate\Support\Collection|bool
     */
    static function getAllProducts()
    {
        $products = DB::table('products')
            ->select(
                self::selection()
            )->get();

        if (!count($products)) {
            return false;
        }

        return $products;
    }

    static function getProductsByQuery(string $key, $value)
    {
        $products = DB::table('products')
            ->where($key, $value)
            ->select(
                self::selection()
            )->get();

        if (count($products) === 0) {
            return false;
        }

        return $products;
    }

    /**
     * Get product by Id
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getById(string $id)
    {
        $product = DB::table('products')
            ->where('products.id', $id)
            ->select(
                self::selection()
            )->first();

        if (!$product) {
            return false;
        }

        return $product;
    }
    
    /**
     * Get product by Id for orders
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getForMetaData(string $id)
    {
        $product = DB::table('products')
            ->where('products.id', $id)
            ->select(
                "name",
                "description",
                "price",
            )->first();

        if (!$product) {
            return false;
        }

        return $product;
    }

    /**
     * Get single product by query
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    static function getSingleByQuery(string $key, $value)
    {
        $product = Product::where($key, $value)
            ->select(
                self::selection()
            )->first();

        if (!$product) {
            return false;
        }

        return $product;
    }

    /**
     * Update single product
     * @param string $id
     * @param array $payload
     * @return \Illuminate\Support\Collection|bool
     */
    static function updateProduct(string $id, array $payload)
    {
        $product = Product::where('id', $id)
            ->update($payload);

        if (!$product) {
            return false;
        }

        $product = self::getById($id);

        return $product;
    }

    /**
     * Delete product
     * @param string $id
     * @return bool
     */
    static function deleteProduct(string $id)
    {
        $product = Product::where('id', $id)
            ->delete();

        if (!$product) {
            return false;
        }

        return true;
    }
}
