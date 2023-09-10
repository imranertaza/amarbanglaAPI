<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class ProductContoller extends Controller
{
//    public function getPriorityProductList() : object{
//        $query = DB::table("shops")->select("*")
//            ->join('products', 'products.sch_id', "=", "shops.sch_id")
//            ->where('shops.priority', '1')
//            ->where('shops.status', '1')
//            ->where('shops.opening_status', '1')
//            ->where("shops.deleted", null)
//            ->groupBy('shops.sch_id')
//            ->limit(2)
//            ->get();
//        dd($query);
//    }

    public function getPopularProductList(Int $limit=0, string $orderType='ASC') : object {
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.popular", 1)
            ->orderBy('products.prod_id', $orderType);
        if($limit !== 0) {
            $shopList->limit($limit);
        }
        if ($shopList->count() > 0) {
            return response()->json(["data"=>$shopList->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }

    public function getHotProductList(?Int $limit=0, string $orderType='ASC') : object {
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.hot", 1)
            ->orderBy('products.prod_id', $orderType);
        if($limit !== 0) {
            $shopList->limit($limit);
        }
        if ($shopList->count() > 0) {
            return response()->json(["data"=>$shopList->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }


    public function getFeaturedProductList(?Int $limit=0, string $orderType='ASC') : object {
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.featured", 1)
            ->orderBy('products.prod_id', $orderType);
        if($limit !== 0) {
            $shopList->limit($limit);
        }
        if ($shopList->count() > 0) {
            return response()->json(["data"=>$shopList->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }

    public function getProductDetails(int $productID, int $shopID) : object {
        $detailsQuery = Products::where('prod_id', $productID)->where('sch_id', $shopID);
        if ($detailsQuery->get()->count() > 0) {
            return response()->json(["data"=>$detailsQuery->first(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }


}
