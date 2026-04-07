<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use App\Models\GeneralSettings;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Libraries\ImagePath;

class ShopController extends Controller
{
    /**
     * Retrieve regular shops list
     *
     * This endpoint returns a list of regular shops that are active, not deleted,
     * prioritized, and currently open.
     *
     * @queryParam limit int optional The maximum number of shops to retrieve. Default is 0 (no limit).
     * @queryParam orderBy string optional The column to order results by. Default is 'ShopID'.
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Shop A", "image": "shop_a.png"},
     *     {"ShopID": 2, "ShopName": "Shop B", "image": "shop_b.png"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops found",
     *   "status": 404
     * }
     *
     * @param int|null $limit The maximum number of shops to retrieve. Default is 0 (no limit).
     * @param string|null $orderBy The column to order results by. Default is 'ShopID'.
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of shops (200)
     *                      or an error message if none are found (404).
     */
    public function getRegularShopsList(?Int $limit = 0, ?string $orderBy = 'ShopID', string $orderType = 'ASC'): JsonResponse
    {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '1')
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');
        if ($limit !== 0) {
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }

    /**
     * Retrieve regular shops list by category
     *
     * This endpoint returns a list of regular shops filtered by a given category.
     * Shops must be active, prioritized, not deleted, and currently open.
     *
     * @urlParam shopCategory int required The category ID to filter shops by.
     * @queryParam limit int optional The maximum number of shops to retrieve. Default is 0 (no limit).
     * @queryParam orderBy string optional The column to order results by. Default is null (no specific order).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Electronics Hub", "image": "electronics.png"},
     *     {"ShopID": 2, "ShopName": "Fashion World", "image": "fashion.png"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops found",
     *   "status": 404
     * }
     *
     * @param int $shopCategory The category ID used to filter shops.
     * @param int|null $limit The maximum number of shops to retrieve. Default is 0 (no limit).
     * @param string|null $orderBy The column to order results by. Default is null.
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of shops (200)
     *                      or an error message if none are found (404).
     */

    public function getRegularShopsListByCategory(Int $shopCategory, ?Int $limit = 0, ?string $orderBy = null, string $orderType = 'ASC'): JsonResponse
    {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '1')
            ->where("shop_cat_id", $shopCategory)
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');

        if ($limit !== 0) {
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


    /**
     * Retrieve all local shops list
     *
     * This endpoint returns a list of local shops that are active, not deleted,
     * prioritized as local, and currently open.
     *
     * @queryParam limit int optional The maximum number of shops to retrieve. Default is 0 (no limit).
     * @queryParam orderBy string optional The column to order results by. Default is 'ShopID'.
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Local Grocery", "image": "grocery.png", "ShortDesc": "Fresh produce daily"},
     *     {"ShopID": 2, "ShopName": "Local Bakery", "image": "bakery.png", "ShortDesc": "Artisan breads and cakes"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops found",
     *   "status": 404
     * }
     *
     * @param int|null $limit The maximum number of shops to retrieve. Default is 0 (no limit).
     * @param string|null $orderBy The column to order results by. Default is 'ShopID'.
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of local shops (200)
     *                      or an error message if none are found (404).
     */

    public function getAllLocalShopsList(?Int $limit = 0, ?string $orderBy = 'ShopID', string $orderType = 'ASC'): JsonResponse
    {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');
        if ($limit !== 0) {
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


    /**
     * Retrieve local shops list by category
     *
     * This endpoint returns a list of local shops filtered by a given category.
     * Shops must be active, prioritized as local, not deleted, and currently open.
     *
     * @urlParam shopCategory int required The category ID to filter shops by.
     * @queryParam limit int optional The maximum number of shops to retrieve. Default is 0 (no limit).
     * @queryParam orderBy string optional The column to order results by. Default is null (no specific order).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Local Grocery", "image": "grocery.png", "ShortDesc": "Fresh produce daily"},
     *     {"ShopID": 2, "ShopName": "Local Bakery", "image": "bakery.png", "ShortDesc": "Artisan breads and cakes"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops found",
     *   "status": 404
     * }
     *
     * @param int $shopCategory The category ID used to filter shops.
     * @param int|null $limit The maximum number of shops to retrieve. Default is 0 (no limit).
     * @param string|null $orderBy The column to order results by. Default is null.
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of local shops (200)
     *                      or an error message if none are found (404).
     */

    public function getLocalShopsListByCategory(Int $shopCategory, ?Int $limit = 0, ?string $orderBy = null, string $orderType = 'ASC'): JsonResponse
    {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("shop_cat_id", $shopCategory)
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');

        if ($limit !== 0) {
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }




    /**
     * Retrieve shop details by ID
     *
     * This endpoint returns detailed information about a specific shop.
     * Shops must be active, prioritized, not deleted, and currently open.
     *
     * @urlParam shopID int required The unique ID of the shop to retrieve details for.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "ShopID": 1,
     *       "ShopName": "Electronics Hub",
     *       "image": "electronics.png",
     *       "priority": 1,
     *       "status": 1,
     *       "opening_status": 1
     *     }
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int $shopID The unique shop ID used to retrieve details.
     *
     * @return JsonResponse A JSON response containing either the shop details (200)
     *                      or an error message if none are found (404).
     */

    public function getShopDetails(Int $shopID): JsonResponse
    {
        $shopInfo = Shops::where("sch_id", $shopID)
            ->where('shops.priority', '1')
            ->where("shops.status", '1')
            ->whereNull("shops.deleted")
            ->where("shops.status", '1')
            ->where("shops.opening_status", '1');
        if ($shopInfo->count() > 0) {
            return response()->json(["data" => $shopInfo->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }




    /**
     * Retrieve shop settings by label
     *
     * This endpoint returns a specific shop setting value based on the shop ID and label.
     *
     * @urlParam shopID int required The unique ID of the shop to retrieve settings for.
     * @urlParam label string required The label key used to filter the shop setting.
     *
     * @response 200 {
     *   "data": [
     *     {"value": "Open 9 AM - 9 PM"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int $shopID The unique shop ID used to retrieve settings.
     * @param string $label The label key used to filter the shop setting.
     *
     * @return JsonResponse A JSON response containing either the shop setting value (200)
     *                      or an error message if none are found (404).
     */

    public function getShopSettingsInfo(Int $shopID, String $label): JsonResponse
    {
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", $label);
        if ($shopInfo->count() > 0) {
            return response()->json(["data" => $shopInfo->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 200);
        }
    }




    /**
     * Retrieve shop YouTube video URL
     *
     * This endpoint returns the YouTube video URL configured for a specific shop.
     * Shops must be active, prioritized, not deleted, and currently open.
     *
     * @urlParam shopID int required The unique ID of the shop to retrieve the YouTube video for.
     *
     * @response 200 {
     *   "data": [
     *     {"value": "https://www.youtube.com/watch?v=abcd1234"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int $shopID The unique shop ID used to retrieve the YouTube video URL.
     *
     * @return JsonResponse A JSON response containing either the YouTube video URL (200)
     *                      or an error message if none is found (404).
     */

    public function getShopYoutubeURL(Int $shopID): JsonResponse
    {
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", "customer_panel_video");
        if ($shopInfo->count() > 0) {
            return response()->json(["data" => $shopInfo->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }


    /**
     * Retrieve local shops list by global address
     *
     * This endpoint returns a list of local shops filtered by a given global address ID.
     * Shops must be active, prioritized as local, not deleted, and currently open.
     *
     * @urlParam global_address_id int required The global address ID to filter shops by.
     * @queryParam limit int optional The maximum number of shops to retrieve. Default is 0 (no limit).
     * @queryParam orderBy string optional The column to order results by. Default is null (no specific order).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Local Grocery", "image": "grocery.png", "ShortDesc": "Fresh produce daily"},
     *     {"ShopID": 2, "ShopName": "Local Bakery", "image": "bakery.png", "ShortDesc": "Artisan breads and cakes"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops found",
     *   "status": 404
     * }
     *
     * @param int $global_address_id The global address ID used to filter shops.
     * @param int|null $limit The maximum number of shops to retrieve. Default is 0 (no limit).
     * @param string|null $orderBy The column to order results by. Default is null.
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of local shops (200)
     *                      or an error message if none are found (404).
     */
    public function getLocalShopList(Int $global_address_id, ?Int $limit = 0, ?string $orderBy = null, string $orderType = 'ASC'): JsonResponse
    {

        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("global_address_id", $global_address_id)
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');

        if ($limit !== 0) {
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


    /**
     * Retrieve local shop details by ID
     *
     * This endpoint returns detailed information about a specific local shop.
     * Shops must be active, prioritized as local, not deleted, and currently open.
     * Additional settings and image paths are merged into the shop details.
     *
     * @urlParam shopID int required The unique ID of the local shop to retrieve details for.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "sch_id": 1,
     *       "name": "Local Grocery",
     *       "status": 1,
     *       "priority": 0,
     *       "opening_status": 1,
     *       "profile_image_path": "profile.png",
     *       "logo_path": "logo.png",
     *       "banner_path": "banner.png",
     *       "customer_panel_banner": "panel_banner.png",
     *       "customer_panel_banner_mobile": "panel_banner_mobile.png",
     *       "setting_key": "setting_value"
     *     }
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Shops Details found",
     *   "status": 404
     * }
     *
     * @param int $shopID The unique shop ID used to retrieve local shop details.
     *
     * @return JsonResponse A JSON response containing either the shop details (200)
     *                      or an error message if none are found (404).
     */

    public function getLocalShopDetails(Int $shopID): JsonResponse
    {

        $shop_details = Shops::select("*")
            ->where("shops.sch_id", $shopID)
            ->whereNull("shops.deleted")
            ->where("shops.status", '1')
            ->where("shops.priority", '0')
            ->where("shops.opening_status", '1')->get();

        if ($shop_details->count() > 0) {
            $getSettingsInfo = GeneralSettings::select("label", "value")->where('sch_id', $shopID)->get();
            foreach ($getSettingsInfo as $result) {
                $shop_details[0][$result->label] = $result->value;
            }

            $imagePath = new ImagePath(shopID: $shopID);
            $shop_details[0]->image = $imagePath->profile_image_path;
            $shop_details[0]->logo = $imagePath->logo_path;
            $shop_details[0]->banner = $imagePath->banner_path;
            $shop_details[0]->customer_panel_banner = $imagePath->customer_panel_banner;
            $shop_details[0]->customer_panel_banner_mobile = $imagePath->customer_panel_banner_mobile;
        }


        $totalRows = $shop_details->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_details, "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Shops Details found", "status" => 404], 404);
        }
    }
}
