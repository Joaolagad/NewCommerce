<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController; 
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout', [CartController::class, 'checkout']);
});


Route::get('/categories', [CategoryController::class, 'getAllCategories']);
Route::get('/products/category/{categoryId}', [ProductController::class, 'getProductsCategory']); 
Route::get('/product/{id}', [ProductController::class, 'getProductDetail']);
Route::get('/trending-products', [ProductController::class, 'getTrendingProducts']);
Route::get('/products', [ProductController::class, 'searchProducts']);
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/get-cart-items', [CartController::class, 'getCartItems']);
Route::get('/search-products', [ProductController::class, 'searchProducts']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/initial-cart-count', [CartController::class, 'getInitialCartCount']);

