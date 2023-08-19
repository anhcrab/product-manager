<?php

use \Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use \App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;
use \App\Http\Controllers\Api\ProductTypeController;
use \App\Http\Controllers\Api\ProductCategoryController;
use \App\Http\Controllers\Api\ProductAttributeController;
use \App\Http\Controllers\Api\ProductTagController;
use \App\Http\Controllers\Api\CartController;

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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/get/{id}', [ProductController::class, 'show']);
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']);
Route::get('/product-types', [ProductTypeController::class, 'index']);
Route::get('/product-categories', [ProductCategoryController::class, 'index']);
Route::get('/product-attributes', [ProductAttributeController::class, 'index']);
Route::get('/product-tags', [ProductTagController::class, 'index']);

Route::prefix('/users')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('log-fb', [UserController::class, 'fb']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('/products')->group(function () {
//    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});
Route::prefix('/types')->group(function () {
    Route::get('/', [ProductTypeController::class, 'index']);
    Route::post('/', [ProductTypeController::class, 'store']);
    Route::get('/{id}', [ProductTypeController::class, 'show']);
    Route::put('/{id}', [ProductTypeController::class, 'update']);
    Route::delete('/{id}', [ProductTypeController::class, 'destroy']);
});
Route::prefix('/categories')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index']);
    Route::post('/', [ProductCategoryController::class, 'store']);
    Route::get('/{id}', [ProductCategoryController::class, 'show']);
    Route::put('/{id}', [ProductCategoryController::class, 'update']);
    Route::delete('/{id}', [ProductCategoryController::class, 'destroy']);
});
Route::prefix('/product-attributes')->group(function () {
    Route::post('/', [ProductAttributeController::class, 'store']);
    Route::get('/{id}', [ProductAttributeController::class, 'show']);
    Route::put('/{id}', [ProductAttributeController::class, 'update']);
    Route::delete('/{id}', [ProductAttributeController::class, 'destroy']);
});
Route::prefix('/product-tags')->group(function () {
    Route::post('/', [ProductTagController::class, 'store']);
    Route::get('/{id}', [ProductTagController::class, 'show']);
    Route::put('/{id}', [ProductTagController::class, 'update']);
    Route::delete('/{id}', [ProductTagController::class, 'destroy']);
});
Route::post('/search',[\App\Http\Controllers\Api\SearchController::class, 'searchProductByRelatedString']);
Route::prefix('/carts')->group(function () {
    Route::get('/{device}', [CartController::class, 'show']);
    Route::post('/', [CartController::class, 'store']);
    Route::delete('/{device}', [CartController::class, 'destroy']);
    Route::post('/add', [CartController::class, 'addProducts']);
    Route::post('/remove', [CartController::class, 'removeProducts']);
});
Route::prefix('/shop')->group(function () {
    Route::post('filter', [\App\Http\Controllers\Api\ShopController::class, 'filter']);
    Route::post('sort', [\App\Http\Controllers\Api\ShopController::class, 'sort']);
    Route::post('filter/total', [\App\Http\Controllers\Api\ShopController::class, 'total']);
});
Route::prefix('/comments-ratings')->group(function () {
    Route::get('/{slug}', [\App\Http\Controllers\Api\RatingCommentController::class, 'show']);
    Route::post('/{slug}/new', [\App\Http\Controllers\Api\RatingCommentController::class, 'store']);
    Route::put('/{slug}', [\App\Http\Controllers\Api\RatingCommentController::class, 'update']);
});

Route::prefix('/orders')->group(function (){
    Route::prefix('payment')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\orders\PayController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\orders\PayController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\Api\orders\PayController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\Api\orders\PayController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\orders\PayController::class, 'destroy']);
    });
    Route::prefix('shipping')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\orders\ShipController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\orders\ShipController::class, 'store']);
        Route::get('/{id}', [\App\Http\Controllers\Api\orders\ShipController::class, 'show']);
        Route::put('/{id}', [\App\Http\Controllers\Api\orders\ShipController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\orders\ShipController::class, 'destroy']);
    });
    Route::get('/', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'index'])
        ->middleware('auth:sanctum');
    Route::post('/', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'store']);
    Route::get('/{slug}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'showBySlug']);
    Route::put('/{id}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'destroy']);
});
