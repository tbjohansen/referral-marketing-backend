<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\HttpResponse;
use App\Http\Helpers\StorageHelper;
use App\Http\Repositories\ProductRepository;
use App\Http\Validations\GlobalValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * GET all products
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllProducts(){
        try {
            
            // => Get products
            $products = ProductRepository::getAllProducts();
            if (!$products) {
                return HttpResponse::error('No product found', null, 404);
            }

            return HttpResponse::success(count($products). " Products retrived succssfully", $products);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * ADD product
     * @param \Illuminate\Http\Request $request
     * @param string 
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createProduct(Request $request){
        try {
            
            // => Create product
            $payload = [
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
            ];
            $product = ProductRepository::createProduct($payload);
            if (!$product) {
                return HttpResponse::error("Fail to add product. Please try again!");
            }

            return HttpResponse::success("Product added successfully", $product);

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * UPDATE product
     * @param \Illuminate\Http\Request $request
     * @param string $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateProduct(Request $request, string $product_id){
        try {
            
            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('product_id', $product_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Get product
            $product = ProductRepository::getForMetaData($product_id);
            if (!$product) {
                return HttpResponse::error("Product details not found", null, 404);
            }
            
            // => Update product
            $payload = [
                "name" => $request->name,
                "price" => $request->price,
                "description" => $request->description,
            ];
            $product = ProductRepository::updateProduct($product_id, $payload);
            if (!$product) {
                return HttpResponse::error("Fail to update product. Please try again!");
            }

            return HttpResponse::success("Product updated successfully", $product);
        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }

    /**
     * DELETE product
     * @param string $product_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteProduct(string $product_id){
        try {

            // Validate uuID
            $validationErrors = GlobalValidation::validateUUID('product_id', $product_id);
            if ($validationErrors) {
                return HttpResponse::error($validationErrors);
            }

            // => Get product
            $product = ProductRepository::getForMetaData($product_id);
            if (!$product) {
                return HttpResponse::error("Product details not found", null, 404);
            }

            // => Delete product
            $deleteProduct = ProductRepository::deleteProduct($product_id);
            if (!$deleteProduct) {
                return HttpResponse::error("Fail to delete product. Please try again!");
            }

            return HttpResponse::success("Product deleted successfully");

        } catch (\Throwable $th) {
            return HttpResponse::severError($th);
        }
    }
}
