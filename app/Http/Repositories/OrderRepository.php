<?php

namespace App\Http\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    /**
     * Selection list
     * @return array<string>
     */
    static function selection()
    {
        return [
            'orders.id as id',
            'orders.user_id',
            'orders.total_amount',
            'orders.payment_status',
        ];
    }

    /**
     * Create new order
     * @param array $payload
     * @return mixed
     */
    static function createOrder(array $payload)
    {
        $order = Order::create($payload);

        if ($order) {
            return $order;
        }

        return false;
    }

    /**
     * Get all orders
     * @return \Illuminate\Support\Collection|bool
     */
    static function getAllOrders()
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                self::selection()
            )->get();

        if (!count($orders)) {
            return false;
        }

        return $orders;
    }

    static function getByQuery(string $key, $value)
    {
        $orders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->where($key, $value)
            ->select(
                self::selection()
            )->get();

        if (count($orders) === 0) {
            return false;
        }

        return $orders;
    }

    /**
     * Get order by Id
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getById(string $id)
    {
        $order = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $id)
            ->select(
                self::selection()
            )->first();

        if (!$order) {
            return false;
        }

        return $order;
    }
    
    /**
     * Get order by Id for transactions
     * @param string $id
     * @return \Illuminate\Support\Collection|bool
     */
    static function getForMetaData(string $id)
    {
        $order = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id', $id)
            ->select(
                "name",
                "payment_status",
                "email",
            )->first();

        if (!$order) {
            return false;
        }

        return $orders;
    }

    /**
     * Get single order by query
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Support\Collection|bool
     */
    static function getSingleByQuery(string $key, $value)
    {
        $order = Order::where($key, $value)
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->select(
                self::selection()
            )->first();

        if (!$order) {
            return false;
        }

        return $order;
    }

    /**
     * Update single order
     * @param string $id
     * @param array $payload
     * @return \Illuminate\Support\Collection|bool
     */
    static function updateOrder(string $id, array $payload)
    {
        $order = Order::where('id', $id)
            ->update($payload);

        if (!$order) {
            return false;
        }

        $order = self::getById($id);

        return $order;
    }

    /**
     * Delete order
     * @param string $id
     * @return bool
     */
    static function deleteOrder(string $id)
    {
        $order = Order::where('id', $id)
            ->delete();

        if (!$order) {
            return false;
        }

        return true;
    }
}
