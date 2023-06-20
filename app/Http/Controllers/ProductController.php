<?php

namespace App\Http\Controllers;

use App\Modules\Products\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $_service;
    public function __construct(ProductService $service)
    {
        $this->_service = $service;
    }

    public function getProducts(Request $request) {
        $pages = $request->get("pages", 10);

        if($pages == 0) {
            return response()->json(['error' => 'No products found.'], 404);
        }

        return response()->json([
            'data' => $this->_service->all($pages)
        ], 200);
    }
}
