<?php
namespace App\Modules\Orders\Services;

use App\Models\Order;
use App\Modules\Core\Services\Service;

class OrderService extends Service {

    protected $_rules = [
        'user_id' => 'required|exists:users,id',
        'status' => 'required|in:pending,processing,completed,cancelled',
        'total_amount' => 'required|numeric|min:0',
        'shipping_address' => 'required|string|max:255',
        'billing_address' => 'required|string|max:255'
    ];

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function all() {
        $data = $this->_model->get();

        return $data;
    }

    public function orderById($id) {
        $data = $this->_model
        ->where('id', $id)
        ->first();
        
        return $data;
    }

    public function orderByUserId($userId) {
        $data = $this->_model
        ->where('user_id', $userId)
        ->get();

        return $data;
    }


    public function addOrder($data) {
        $this->validate($data);

        if($this->hasErrors()) {
            return;
        }

        $order = $this->_model->create($data);
        return $order;
    }
}