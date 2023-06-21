<?php

namespace App\Http\Controllers;

use App\Modules\Categories\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $_service;
    public function __construct(CategoryService $service)
    {
        $this->_service = $service;
    }

    public function getCategories() {
        $categories = $this->_service->all();

        if(empty($categories)) {
            return response()->json([
                'error' => "No categories found"
            ], 404);
        }

        return response()->json([
            'data' => $categories
        ], 200);
    }

    public function getCategory($categoryId) {
        $category = $this->_service->categoryById($categoryId);

        if($category === null) {
            return response()->json([
                'error' => "No categories found"
            ], 404);
        }

        return response()->json([
            'data' => $category
        ], 200);
    }
}
