<?php

namespace App\Http\Controllers;

use App\Modules\Carts\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $_service;

    public function __construct(CartService $service)
    {
        $this->_service = $service;
    }

    public function getCarts(Request $request) {
        $userId = $request->query('userId');

        if($userId) {
            $carts = $this->_service->cartByUserId($userId);
        } else {
            $carts = $this->_service->all();
        }

        if(empty($carts)) {
            return $this->sendNotFoundResponse("No carts found");
        }

        return $this->sendOkResponse(data: $carts);
    }

    public function getCart($cartId) {
        $cart = $this->_service->cartById($cartId);

        if($cart === null) {
            return $this->sendNotFoundResponse("No carts found");
        }

        return $this->sendOkResponse(data: $cart);
    }

    public function addCart(Request $request) {
        $data = $request->all();
        $cart = $this->_service->addCart($data);
        
        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }

        return $this->sendCreatedResponse("Cart saved successfully", $cart);
    }

    public function updateCart(Request $request, $cartId) {
        $data = $request->all();
        $cart = $this->_service->updateCart($data, $cartId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }

        return $this->sendOkResponse('Cart updated successfully', $cart);
    }

    public function deleteCart($cartId) {
        $this->_service->deleteCart($cartId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }

        return $this->sendOkResponse("Cart deleted successfully");
    }

    public function addProductToCart(Request $request, $cartId) {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $result = $this->_service->addProductToCart($cartId, $productId, $quantity);

        if(!$result) {
            return $this->sendBadRequestResponse('Failed to add product to cart');
        }

        return $this->sendOkResponse('Product added to cart successfully');
    }
}
