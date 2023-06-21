<?php
namespace App\Modules\Categories\Services;

use App\Models\Category;
use App\Modules\Core\Services\ServiceLanguages;

class CategoryService extends ServiceLanguages {

    protected $_rulesTranslations = [
        'category_id' => 'required|exists:categories,id',
        'locale' => 'required|string|min:2|max:2',
        'name' => 'required|string|max:255'
    ];

    public function __construct(Category $model) {
        parent::__construct($model);
    }

    public function all() {
        $data = $this->_model
        ->with('translations')
        ->get();

        return $data;
    }

    public function categoryById($id) {
        $data = $this->_model
        ->with("translations")
        ->where('id', $id)
        ->first();
        return $data;
    }
}