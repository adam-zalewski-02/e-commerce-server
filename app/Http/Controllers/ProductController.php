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
           $this->sendNotFoundResponse("No products found");
        }

        $products = $this->_service->all($pages);

        $this->sendOkResponse(null, $products);
    }

    public function getProduct($productId) {
        $product = $this->_service->productById($productId);

        if($product === null) {
            $this->sendNotFoundResponse("No products found");
        }

        $this->sendOkResponse(null, $product);
    }

    public function addProduct(Request $request) {
        $data = $request->all();
        $product = $this->_service->addProduct($data);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendCreatedResponse("Product saved successfully", $product);
    }

    public function updateProduct(Request $request, $productId) {
        $data = $request->all();
        $product = $this->_service->updateProduct($data, $productId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse("Product updated successfully", $product);
    }

    public function deleteProduct($productId) {
        $this->_service->deleteProduct($productId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse("Product deleted successfully");
    }
}
