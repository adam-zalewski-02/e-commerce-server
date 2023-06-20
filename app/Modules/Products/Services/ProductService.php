<?php
namespace App\Modules\Products\Services;

use App\Models\Product;
use App\Modules\Core\Services\ServiceLanguages;

class ProductService extends ServiceLanguages {

    protected $_rules = [];
    protected $_rulesTranslations = [];

    public function __construct(Product $model) {
        parent::__construct($model);
    }

    public function all($pages = 10) {
        $data = $this->_model
        ->with('translations')
        ->paginate($pages)
        ->withQueryString();

        return $data;
    }

    public function productById($id) {
        $data = $this->_model
        ->with("translations")
        ->where('id', $id)
        ->first();
        return $data;
    }

    public function addProduct($data) {
        $this->validate($data);
        if($this->hasErrors()) {
            return;
        }

        $product = $this->_model->create($data);
        foreach($data['translations'] as $translation) {
            $product->translations()->create($translation);
        }

        return $product;
    }
}