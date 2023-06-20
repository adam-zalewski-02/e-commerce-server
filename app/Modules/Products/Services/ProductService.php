<?php
namespace App\Modules\Products\Services;

use App\Models\Product;
use App\Modules\Core\Services\ServiceLanguages;

class ProductService extends ServiceLanguages {

    protected $_rules = [
        'SKU' => 'required|string|unique:products',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'nullable|exists:categories,id',
    ];
    
    protected $_rulesTranslations = [
        'product_id' => 'required|exists:products,id',
        'locale' => 'required|string|min:2|max:2',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

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

    public function updateProduct($data, $productId) {
        $this->validate($data);
        if($this->hasErrors()) {
            return;
        }

        $product = $this->productById($productId);
        $product->update($data);
        foreach($data['translations'] as $translation) {
            $product->translations()->where('locale', $translation['locale'])->update($translation);
        }

        return $product;
    }
}