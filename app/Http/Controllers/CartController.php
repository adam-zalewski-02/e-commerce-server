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
}
