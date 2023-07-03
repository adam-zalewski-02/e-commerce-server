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
            return $this->sendNotFoundResponse("No categories found");
        }

        return $this->sendOkResponse(data: $categories);
    }

    public function getCategory($categoryId) {
        $category = $this->_service->categoryById($categoryId);

        if($category === null) {
            return $this->sendNotFoundResponse("No categories found");
        }

        return $this->sendOkResponse(data: $category);
    }

    public function addCategory(Request $request) {
        $data = $request->all();
        $category = $this->_service->addCategory($data);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }

        return $this->sendCreatedResponse("Category saved successfully", $category);
    }

    public function updateCategory(Request $request, $categoryId) {
        $data = $request->all();
        $category = $this->_service->updateCategory($data, $categoryId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }


        return $this->sendOkResponse("Category updated successfully", $category);
    }

    public function deleteCategory($categoryId) {
        $this->_service->deleteCategory($categoryId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            return $this->sendBadRequestResponse($errors);
        }

        return $this->sendOkResponse("Category deleted successfully");
    }
}
