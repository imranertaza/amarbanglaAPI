<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use http\Env\Response;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Here will be the description of the function
     *
     * @param Int|null $limit Limit variable will be null
     * @param string|null $orderBy
     * @param string $orderType
     * @return object
     */
    public function getRegularShopsList(?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');
        if ($limit !== 0){
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null){
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


    public function getRegularShopsListByCategory(Int $shopCategory, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("shop_cat_id", $shopCategory)
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');

        if ($limit !== 0){
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null){
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


}
