<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopCategory;
use Exception;

class ShopCategoryController extends Controller
{
    /**
     * This method provides the featured shop category list.
     * 
     * @param Int $limit
     * @param String $orderType
     * @return object
     */
    public function getFeaturedShopCategory(?Int $limit=null, String $orderType='ASC') : object {
        try{
            $shopCategoryList = ShopCategory::select("*")
                                ->where("show_home", "1")
                                ->orderBy('shop_cat_id', $orderType);
            
            if($limit !== null) {
                $shopCategoryList->limit($limit);
            }
                                
            $data = $shopCategoryList->get();
            if ($data->count() > 0) {
                return response()->json(["data"=>$data, "status"=>200], 200);
            }else {
                return response()->json(["data"=>"No data found.", "status"=>404], 404);
            }
        } catch(Exception $e) {
            return response()->json(["data"=>"An error occurred.", "status"=>500], 500);
        }
    }


    /**
     * This method provides the all shop category list.
     * 
     * @param Int $limit
     * @param String $orderType
     * @return object
     */
    public function getAllShopCategory(?Int $limit=null, String $orderType='ASC') : object {
        try{
            $shopCategoryList = ShopCategory::select("*")
                                ->orderBy('shop_cat_id', $orderType);
            
            if($limit !== null) {
                $shopCategoryList->limit($limit);
            }
                                
            $data = $shopCategoryList->get();
            if ($data->count() > 0) {
                return response()->json(["data"=>$data, "status"=>200], 200);
            }else {
                return response()->json(["data"=>"No data found.", "status"=>404], 404);
            }
        } catch(Exception $e) {
            return response()->json(["data"=>"An error occurred.", "status"=>500], 500);
        }
    }

}
