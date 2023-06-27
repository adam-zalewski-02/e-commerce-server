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
            $this->sendNotFoundResponse("No carts found");
        }

        $this->sendOkResponse($carts);
    }

    public function getCart($cartId) {
        $cart = $this->_service->cartById($cartId);

        if($cart === null) {
            $this->sendNotFoundResponse("No carts found");
        }

        $this->sendOkResponse($cart);
    }

    public function addCart(Request $request) {
        $data = $request->all();
        $cart = $this->_service->addCart($data);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendCreatedResponse("Cart saved successfully", $cart);
    }

    public function updateCart(Request $request, $cartId) {
        $data = $request->all();
        $cart = $this->_service->updateCart($data, $cartId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse($cart);
    }

    public function deleteCart($cartId) {
        $this->_service->deleteCart($cartId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendDeletedResponse("Cart deleted successfully");
    }
}
