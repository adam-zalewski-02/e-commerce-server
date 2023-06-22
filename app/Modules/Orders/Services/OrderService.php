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
}