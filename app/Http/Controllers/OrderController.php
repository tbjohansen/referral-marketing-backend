<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\HttpResponse;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Validations\GlobalValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * GET all orders
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllOrders(){
        try {
            
            // => Get products
            $orders = OrderRepository::getAllOrders();
            if (!$orders) {
                return HttpResponse::error('No orders found', null, 404);
            }

            return HttpResponse::success(count($orders). " Orders retrived succssfully", $orders);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * GET user Orders
     * @param string
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getUserOrders(){
        try {
            // => User id
            $user_id = Auth::user()->id;

            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('user_id', $user_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }
            
            // => Get user
            $user = UserRepository::getById($user_id);
            if (!$user) {
                return HttpResponse::error("User details not found", null, 404);
            }

            // => Get orders
            $orders = OrderRepository::getByQuery(['user_id' => $user_id]);
            if (!$orders) {
                return HttpResponse::error('User has no orders', null, 404);
            }

            return HttpResponse::success(count($orders). " Orders retrived succssfully", $orders);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * ADD order
     * @param \Illuminate\Http\Request $request
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createOrder(Request $request){
        try {

            // => User id
            $user_id = Auth::user()->id;
            
            // => Create order
            $payload = [
                "user_id" => $user_id,
                "payment_status" => $request->payment_status,
                "total_amount" => $request->total_amount,
            ];
            $product = OrderRepository::createOrder($payload);
            if (!$order) {
                return HttpResponse::error("Fail to add order. Please try again!");
            }

            return HttpResponse::success("Order is added successfully", $order);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
}
