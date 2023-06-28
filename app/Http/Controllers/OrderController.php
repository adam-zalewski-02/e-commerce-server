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
            $this->sendNotFoundResponse("No orders found");
        }

        $this->sendOkResponse(null, $orders);
    }

    public function getOrder($id) {
        $order = $this->_service->orderById($id);

        if($order === null) {
            $this->sendNotFoundResponse("No orders found");
        }

        $this->sendOkResponse(null, $order);
    }

    public function addOrder(Request $request) {
        $data = $request->all();
        $order = $this->_service->addOrder($data);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendCreatedResponse("Order saved successfully", $order);
    }

    public function updateOrder(Request $request, $orderId) {
        $data = $request->all();
        $order = $this->_service->updateOrder($data, $orderId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse("Order updated successfully", $order);
    }

    public function deleteOrder($orderId) {
        $order = $this->_service->deleteOrder($orderId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse("Order deleted successfully");
    }
}
