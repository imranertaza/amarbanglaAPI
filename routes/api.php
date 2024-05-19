<?php

use \App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ShopController;
use \App\Http\Controllers\ProductContoller;
use App\Http\Controllers\ShopCategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("get_sliders", [WebsiteSettingsController::class, 'slider_banners']);
Route::get("get_website_settings/{label}", [WebsiteSettingsController::class, 'getWebsiteSettings']);


Route::get("get_regular_shop_list/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getRegularShopsList']);
Route::get("get_regular_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getRegularShopsListByCategory']);
Route::get("get_local_shop_list/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getLocalShopsList']);
Route::get("get_local_shop_list_by_category/{shop_category}/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getLocalShopsListByCategory']);
Route::get("get_shop_details/{shopID}/", [ShopController::class, 'getShopDetails']);
Route::get("get_shop_youtube_url/{shopID}/", [ShopController::class, 'getShopYoutubeURL']);
Route::get("get_shop_settings_info/{shopID}/{label}/", [ShopController::class, 'getShopSettingsInfo']);
//Route::get("get_all_products", [ProductContoller::class, 'getPriorityProductList']);


Route::get("get_popular_products/{offset?}/{limit?}/{orderType?}", [ProductContoller::class, 'getPopularProductList']);
Route::get("get_hot_products/{offset?}/{limit?}/{orderType?}", [ProductContoller::class, 'getHotProductList']);
Route::get("get_featured_products/{offset?}/{limit?}/{orderType?}", [ProductContoller::class, 'getFeaturedProductList']);
Route::get("get_products_details/{productID}/{shopID}", [ProductContoller::class, 'getProductDetails']);
Route::get("get_products_image/{productID}/", [ProductContoller::class, 'getProductImage']);



// Shop Category API
Route::get("get_featured_shop_category/{limit?}/{orderType?}", [ShopCategoryController::class, 'getFeaturedShopCategory']);
Route::get("get_all_shop_category/{limit?}/{orderType?}", [ShopCategoryController::class, 'getAllShopCategory']);


// Search API
Route::post("search", [ProductContoller::class, 'searchItem']);
Route::post("search/{limit?}", [ProductContoller::class, 'searchItemWithLimit']);
Route::post("search/{limit?}/{orderType?}", [ProductContoller::class, 'searchItemWithLimitAndOrderType']);
