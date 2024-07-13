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
     * This function return the regular shops list
     *
     * @param Int|null $limit Limit variable will be null
     * @param string|null $orderBy
     * @param string $orderType
     * @return JsonResponse
     */
    public function getRegularShopsList(?Int $limit=0, ?string $orderBy='ShopID', string $orderType='ASC') : JsonResponse {
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
     * @return JsonResponse
     */
    public function getRegularShopsListByCategory(Int $shopCategory, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : JsonResponse {
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
     * @return JsonResponse
     */
    public function getAllLocalShopsList(?Int $limit=0, ?string $orderBy='ShopID', string $orderType='ASC') :JsonResponse {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image", "short_description as ShortDesc")
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
     * @return JsonResponse
     */
    public function getLocalShopsListByCategory(Int $shopCategory, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : JsonResponse {
        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image", "short_description as ShortDesc")
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




    /**
     * @param Int $shopID
     *
     * @return JsonResponse
     */
    public function getShopDetails(Int $shopID):JsonResponse{
        $shopInfo = Shops::where("sch_id", $shopID);
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }




    /**
     * @param Int $shopID
     * @param String $label
     *
     * @return JsonResponse
     */
    public function getShopSettingsInfo(Int $shopID, String $label):JsonResponse{
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", $label);
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }




    /**
     * @param Int $shopID
     *
     * @return JsonResponse
     */
    public function getShopYoutubeURL(Int $shopID):JsonResponse{
        $shopInfo = GeneralSettings::select("value")
            ->where("sch_id", $shopID)
            ->where("label", "customer_panel_video");
        if ($shopInfo->count() > 0) {
            return response()->json(["data"=>$shopInfo->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 404);
        }
    }


    /**
     * @param Int $global_address_id
     * @param Int|null $limit=0
     * @param string|null $orderBy=null
     * @param string $orderType='ASC'
     *
     * @return JsonResponse
     */
    public function getLocalShopList(Int $global_address_id, ?Int $limit=0, ?string $orderBy=null, string $orderType='ASC') : JsonResponse {

        $shop_list = Shops::select("sch_id as ShopID", "name as ShopName", "image", "short_description as ShortDesc")
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


    /**
     * @description This api provide all the details of a local shop
     * @param Int $shopID
     * @return JsonResponse
     */
    public function getLocalShopDetails(Int $shopID) : JsonResponse {

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

            $in = new ImagePath(shopID:$shopID);
            $shop_details[0]->image = $in->profile_image_path;
            $shop_details[0]->logo = $in->logo_path;
            $shop_details[0]->banner = $in->banner_path;

        }


        $totalRows = $shop_details->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $shop_details, "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Shops Details found", "status" => 404], 404);
        }
    }


}
