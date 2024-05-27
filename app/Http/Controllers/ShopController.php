<?php

namespace App\Http\Controllers;

use App\Models\Shops;
use App\Models\GeneralSettings;
use http\Env\Response;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * This function return the regular shops list
     *
     * @param Int|null $limit Limit variable will be null
     * @param string|null $orderBy
     * @param string $orderType
     * @return object
     */
    public function getRegularShopsList(?Int $limit=0, ?string $orderBy='ShopID', string $orderType='ASC') :object {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '1')
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');
        if ($limit !== 0){
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }

    /**
     * This function returns the list of regular shops filtering with category
     * @param Int $shopCategory
     * @param Int|null $limit
     * @param string|null $orderBy
     * @param string $orderType
     * @return object
     */
    public function getRegularShopsListByCategory(Int $shopCategory, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : object {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '1')
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


    /**
     * This function return the local shops list
     *
     * @param Int|null $limit Limit variable will be null
     * @param string|null $orderBy
     * @param string $orderType
     * @return object
     */
    public function getAllLocalShopsList(?Int $limit=0, ?string $orderBy='ShopID', string $orderType='ASC') :object {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("deleted", null)
            ->where("status", '1')
            ->where("opening_status", '1');
        if ($limit !== 0){
            $shop_list = $shop_list->limit($limit);
        }
        if ($orderBy !== null) {
            $shop_list = $shop_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $shop_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_list->get(), "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Shops found", "status" => 404], 404);
        }
    }


    /**
     * This function returns the list of local shops filtering with category
     * @param Int $shopCategory
     * @param Int|null $limit
     * @param string|null $orderBy
     * @param string $orderType
     * @return object
     */
    public function getLocalShopsListByCategory(Int $shopCategory, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : object {
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


    public function getShopDetails(Int $shopID):object{
        $shopInfo = Shops::where("sch_id", $shopID);
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }


    public function getShopSettingsInfo(Int $shopID, String $label):object{
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", $label);
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }

    public function getShopYoutubeURL(Int $shopID):object{
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", "customer_panel_video");
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 404);
        }
    }


    public function getLocalShopList(Int $global_address_id, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : object {
        
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image")
            ->where("priority", '0')
            ->where("global_address_id", $global_address_id)
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
