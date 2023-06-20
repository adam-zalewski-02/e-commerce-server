<?php

namespace App\Http\Controllers;

use App\Modules\Products\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $_service;
    public function __construct(ProductService $service)
    {
        $this->_service = $service;
    }

    public function getProducts(Request $request) {
        $pages = $request->get("pages", 10);

        if($pages == 0) {
            return response()->json(['error' => 'No products found.'], 404);
        }

        return response()->json([
            'data' => $this->_service->all($pages)
        ], 200);
    }

    public function getProduct($productId) {
        $product = $this->_service->productById($productId);

        if($product === null) {
            return response()->json([
                'error' => "Product with id '$productId' not found"
            ], 404);
        }

        return response()->json(['data' => $product], 200);
    }

    public function addProduct(Request $request) {
        $data = $request->all();
        $product = $this->_service->addProduct($data);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => "Product saved successfully",
            'data' => $product
        ],201);
    }

    public function updateProduct(Request $request, $productId) {
        $data = $request->all();
        $product = $this->_service->updateProduct($data, $productId);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => "Product updated successfully",
            'data' => $product
        ], 200);
    }
}
