<?php

namespace App\Http\Controllers;

use App\Modules\Orders\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $_service;
    public function __construct(OrderService $service)
    {
        $this->_service = $service;
    }

    public function getOrders(Request $request) {
        $userId = $request->query('userId');

        if($userId) {
            $orders = $this->_service->orderByUserId($userId);
        } else {
            $orders = $this->_service->all();
        }

        if(empty($orders)) {
            return response()->json([
                'error' => 'No orders found'
            ], 404);
        }

        return response()->json([
            'data' => $orders
        ], 200);
    }

    public function getOrder($id) {
        $order = $this->_service->orderById($id);

        if($order === null) {
            return response()->json([
                'error' => "No orders found"
            ], 404);
        }

        return response()->json([
            'data' => $order
        ]);
    }
}
