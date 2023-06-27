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

    public function getCarts() {
        $data = $this->_service->all();

        if(empty($data)) {
            return response()->json([
                'error' => 'No carts found'
            ], 404);
        }

        return response()->json([
            'data' => $data
        ], 200);
    }
}
