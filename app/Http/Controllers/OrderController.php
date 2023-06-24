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

    public function addOrder(Request $request) {
        $data = $request->all();
        $order = $this->_service->addOrder($data);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => "Order saved successfully",
            'data' => $order
        ], 201);
    }

    public function updateOrder(Request $request, $orderId) {
        $data = $request->all();
        $order = $this->_service->updateOrder($data, $orderId);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => "Order updated successfully",
            'data' => $order
        ], 200);
    }

    public function deleteOrder($orderId) {
        $order = $this->_service->deleteOrder($orderId);

        if($this->_service->hasErrors()) {
            return response()->json([
                'errors' => $this->_service->getErrors()
            ], 400);
        }

        return response()->json([
            'message' => "Order deleted successfully"
        ], 200);
    }
}
