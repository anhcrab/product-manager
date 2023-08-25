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
use \App\Http\Controllers\Api\orders\BanksController;
use \App\Http\Controllers\Api\orders\StoresController;
use \App\Http\Controllers\Api\orders\ShippingController;
use \App\Http\Controllers\Api\orders\PaymentController;
use \App\Http\Controllers\Api\inventory\InventoriesController;

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

/*
|--------------------------------------------------------------------------
| Shop page Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/get/{id}', [ProductController::class, 'show']);
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']);
Route::get('/product-types', [ProductTypeController::class, 'index']);
Route::get('/product-categories', [ProductCategoryController::class, 'index']);
Route::get('/product-attributes', [ProductAttributeController::class, 'index']);
Route::get('/product-tags', [ProductTagController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/users')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('log-fb', [UserController::class, 'fb']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('/products')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::post('/update/{id}', [ProductController::class, 'update']);
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
Route::prefix('/attributes')->group(function () {
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

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/carts')->group(function () {
    Route::get('/{device}', [CartController::class, 'show']);
    Route::post('/', [CartController::class, 'store']);
//    Route::delete('/{device}', [CartController::class, 'destroy']);
    Route::post('/add', [CartController::class, 'addProducts']);
    Route::post('/remove', [CartController::class, 'removeProducts']);
    Route::get('/clear', [CartController::class, 'clearProducts']);
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

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/orders')->group(function (){
    Route::get('/', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'index']);
    Route::post('/', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'store']);
    Route::get('/{slug}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'showBySlug']);
    Route::put('/{id}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'update']);
    Route::delete('/{id}', [\App\Http\Controllers\Api\orders\OrderContronller::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Banks Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/banks')->group(function () {
   Route::get('/', [BanksController::class, 'index']);
   Route::post('/', [BanksController::class, 'store']);
   Route::get('/{id}', [BanksController::class, 'show']);
   Route::put('/{id}', [BanksController::class, 'update']);
   Route::delete('/{id}', [BanksController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Stores Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/stores')->group(function () {
    Route::get('/', [StoresController::class, 'index']);
    Route::post('/', [StoresController::class, 'store']);
    Route::get('/{id}', [StoresController::class, 'show']);
    Route::put('/{id}', [StoresController::class, 'update']);
    Route::delete('/{id}', [StoresController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/payment')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
    Route::get('/{id}', [PaymentController::class, 'show']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::delete('/{id}', [PaymentController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Shipping Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/shipping')->group(function () {
    Route::get('/', [ShippingController::class, 'index']);
    Route::post('/', [ShippingController::class, 'store']);
    Route::get('/{id}', [ShippingController::class, 'show']);
    Route::put('/{id}', [ShippingController::class, 'update']);
    Route::delete('/{id}', [ShippingController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Inventories Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('/shipping')->group(function () {
    Route::get('/', [InventoriesController::class, 'index']);
    Route::post('/', [InventoriesController::class, 'store']);
    Route::get('/{id}', [InventoriesController::class, 'show']);
    Route::put('/{id}', [InventoriesController::class, 'update']);
    Route::delete('/{id}', [InventoriesController::class, 'destroy']);
});
