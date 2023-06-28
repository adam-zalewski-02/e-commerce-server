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
            $this->sendNotFoundResponse("No categories found");
        }

        $this->sendOkResponse(null, $categories);
    }

    public function getCategory($categoryId) {
        $category = $this->_service->categoryById($categoryId);

        if($category === null) {
            $this->sendNotFoundResponse("No categories found");
        }

        $this->sendOkResponse(null, $category);
    }

    public function addCategory(Request $request) {
        $data = $request->all();
        $category = $this->_service->addCategory($data);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendCreatedResponse("Category saved successfully", $category);
    }

    public function updateCategory(Request $request, $categoryId) {
        $data = $request->all();
        $category = $this->_service->updateCategory($data, $categoryId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }


        $this->sendOkResponse("Category updated successfully", $category);
    }

    public function deleteCategory($categoryId) {
        $this->_service->deleteCategory($categoryId);

        if($this->_service->hasErrors()) {
            $errors = $this->_service->getErrors();
            $this->sendBadRequestResponse($errors);
        }

        $this->sendOkResponse("Category deleted successfully");
    }
}
