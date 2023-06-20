<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'getProducts']);
Route::post('/products', [ProductController::class, 'addProduct']);

Route::get('/products/{productId}', [ProductController::class, 'getProduct']);
Route::put('/products/{productId}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{productId}', [ProductController::class, 'deleteProduct']);