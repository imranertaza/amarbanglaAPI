<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use http\Env\Response;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function getExclusiveShopsList(?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : object {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")->where(array('priority' => '1', 'home_feature' => '1', 'deleted' => null, 'status' => '1','opening_status' => '1'));
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
