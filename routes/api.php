<?php

use \App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\ProductContoller;

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

Route::get("get_sliders", [WebsiteSettingsController::class, 'slider_banners']);
Route::get("get_website_settings/{label}", [WebsiteSettingsController::class, 'getWebsiteSettings']);


Route::get("get_regular_shop_list/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getRegularShopsList']);
//Route::get("get_all_products", [ProductContoller::class, 'getPriorityProductList']);
Route::get("get_popular_products/{limit?}/{orderType?}", [ProductContoller::class, 'getPopularProductList']);
Route::get("get_hot_products/{limit?}/{orderType?}", [ProductContoller::class, 'getHotProductList']);
Route::get("get_featured_products/{limit?}/{orderType?}", [ProductContoller::class, 'getFeaturedProductList']);
