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
            return response()->json([
                'error' => 'No carts found'
            ], 404);
        }

        return response()->json([
            'data' => $carts
        ], 200);
    }

    public function getCart($cartId) {
        $cart = $this->_service->cartById($cartId);

        if($cart === null) {
            return response()->json([
                'error' => 'No carts found'
            ], 404);
        }

        return response()->json([
            'data' => $cart
        ], 200);
    }

    public function addCart(Request $request) {
        $data = $request->all();
        $cart = $this->_service->addCart($data);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => 'Cart saved successfully',
            'data' => $cart
        ], 201);
    }

    public function updateCart(Request $request, $cartId) {
        $data = $request->all();
        $cart = $this->_service->updateCart($data, $cartId);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => 'Cart updated successfully',
            'data' => $cart
        ], 200);
    }
}
