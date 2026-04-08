<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopCategory;
use Exception;

class ShopCategoryController extends Controller
{
    /**
     * Retrieve featured shop categories
     *
     * This endpoint returns a list of featured shop categories that are marked
     * to be displayed on the homepage. Supports optional limit and ordering.
     *
     * @queryParam limit int optional The maximum number of categories to retrieve. Default is null (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "shop_cat_id": 1,
     *       "name": "Groceries",
     *       "show_home": 1
     *     },
     *     {
     *       "shop_cat_id": 2,
     *       "name": "Electronics",
     *       "show_home": 1
     *     }
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No data found.",
     *   "status": 404
     * }
     *
     * @response 500 {
     *   "data": "An error occurred.",
     *   "status": 500
     * }
     *
     * @param int|null $limit The maximum number of categories to retrieve. Default is null (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of featured shop categories (200),
     *                      an error message if none are found (404),
     *                      or a server error message (500).
     */

    public function getFeaturedShopCategory(?Int $limit = null, String $orderType = 'ASC'): object
    {
        try {
            $shopCategoryList = ShopCategory::select("*")
                ->where("show_home", "1")
                ->orderBy('shop_cat_id', $orderType);

            if ($limit !== null) {
                $shopCategoryList->limit($limit);
            }

            $data = $shopCategoryList->get();
            if ($data->count() > 0) {
                return response()->json(["data" => $data, "status" => 200], 200);
            } else {
                return response()->json(["data" => "No data found.", "status" => 404], 404);
            }
        } catch (Exception $e) {
            return response()->json(["data" => "An error occurred.", "status" => 500], 500);
        }
    }


    /**
     * Retrieve all shop categories
     *
     * This endpoint returns a list of all shop categories.
     * Supports optional limit and ordering.
     *
     * @queryParam limit int optional The maximum number of categories to retrieve. Default is null (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "shop_cat_id": 1,
     *       "name": "Groceries"
     *     },
     *     {
     *       "shop_cat_id": 2,
     *       "name": "Electronics"
     *     }
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No data found.",
     *   "status": 404
     * }
     *
     * @response 500 {
     *   "data": "An error occurred.",
     *   "status": 500
     * }
     *
     * @param int|null $limit The maximum number of categories to retrieve. Default is null (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of shop categories (200),
     *                      an error message if none are found (404),
     *                      or a server error message (500).
     */

    public function getAllShopCategory(?Int $limit = null, String $orderType = 'ASC'): object
    {
        try {
            $shopCategoryList = ShopCategory::select("*")
                ->orderBy('shop_cat_id', $orderType);

            if ($limit !== null) {
                $shopCategoryList->limit($limit);
            }

            $data = $shopCategoryList->get();
            if ($data->count() > 0) {
                return response()->json(["data" => $data, "status" => 200], 200);
            } else {
                return response()->json(["data" => "No data found.", "status" => 404], 404);
            }
        } catch (Exception $e) {
            return response()->json(["data" => "An error occurred.", "status" => 500], 500);
        }
    }
}
