<?php
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| REGISTER Routes
|--------------------------------------------------------------------------
*/
Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'register');
});


/*
|--------------------------------------------------------------------------
| AUTH Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    // => PUBLIC
    Route::post('/login', 'login');

    // => PRIVATE
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
    });
});


/*
|--------------------------------------------------------------------------
| USERS Routes
|--------------------------------------------------------------------------
*/
Route::controller(UserController::class)->prefix('users')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', 'getUsers');
    });
});


/*
|--------------------------------------------------------------------------
| PRODUCTS Routes
|--------------------------------------------------------------------------
*/
Route::controller(ProductController::class)->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/products', 'getAllProducts');
        Route::post('/admin/products', 'createProduct');
        Route::put('/admin/products/{product_id}', 'updateProduct');
    });
});

/*
|--------------------------------------------------------------------------
| ORDERS Routes
|--------------------------------------------------------------------------
*/
Route::controller(OrderController::class)>prefix('user')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/orders', 'getUserOrders');
        Route::post('/orders', 'createOrder');
    });
});