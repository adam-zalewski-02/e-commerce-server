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
}