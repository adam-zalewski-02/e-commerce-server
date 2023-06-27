<?php
namespace App\Modules\Carts\Services;

use App\Models\Cart;
use App\Modules\Core\Services\Service;

class CartService extends Service {
    
    protected $_rules = [
        'user_id' => 'required|exists:users,id'
    ];

    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function all() {
        $data = $this->_model->get();

        return $data;
    }

    public function cartById($id) {
        $data = $this->_model
        ->where('id', $id)
        ->first();

        return $data;
    }

    public function cartByUserId($userId) {
        $data = $this->_model
        ->where('user_id', $userId)
        ->first();

        return $data;
    }

    public function addCart($data) {
        $this->validate($data);

        if($this->hasErrors()) {
            return;
        }

        $cart = $this->_model->create($data);

        return $cart;
    }
}