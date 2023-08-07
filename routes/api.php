<?php

use \App\Http\Controllers\WebsiteSettingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ShopController;

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


Route::get("get_exclusive_shop_list/{limit?}/{orderBy?}/{orderType?}", [ShopController::class, 'getExclusiveShopsList']);
