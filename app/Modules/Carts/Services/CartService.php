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
}