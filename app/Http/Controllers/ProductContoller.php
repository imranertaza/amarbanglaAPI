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


    // Search API functions start
    /**
     * Search Item with Limit And OrderType
     * @param Int|null $limit
     * @param string $orderType
     * @param Request $request
     * @return object
     */
    public function searchItemWithLimitAndOrderType(?Int $limit=0, string $orderType='ASC', Request $request) : object
    {
        $key = $request->post('search_item');
        $carecter = substr($key, 0, 1);
        if ($carecter == '#') {
            $shopId = str_replace('#', '', $key);
            return $this->searchShop($shopId, $limit, $orderType);
        } else {
            return $this->searchProduct($key, $limit, $orderType);
        }
    }


    /**
     * Search Item with Limit
     * @param Int|null $limit
     * @param Request $request
     * @return object
     */
    public function searchItemWithLimit(?Int $limit=0, Request $request) : object
    {
        $key = $request->post('search_item');
        $carecter = substr($key, 0, 1);
        if ($carecter == '#') {
            $shopId = str_replace('#', '', $key);
            return $this->searchShop($shopId, $limit);
        } else {
            return $this->searchProduct($key, $limit);
        }
    }



    /**
     * Search Products API
     * @param Request $request
     * @return object
     */
    public function searchItem(Request $request) : object
    {
        $key = $request->post('search_item');
        $carecter = substr($key, 0, 1);
        if ($carecter == '#') {
            $shopId = str_replace('#', '', $key);
            return $this->searchShop($shopId);
        } else {
            return $this->searchProduct($key);
        }
    }



    /**
     * Product Search Function. It's a private function that is called by above functions.
     * @param Int $key
     * @param Int $limit
     * @param string $orderType
     * @return object
     */
    private function searchProduct(Int $key, Int $limit=10, String $orderType='ASC') : object {
        $productList = DB::table("products")->select("*")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.opening_status', '1')
            ->where('shops.status', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("products.name", 'LIKE', "%{$key}%")
            ->where("products.name", 'LIKE', "%{$key}%")
            ->orWhere("products.prod_id", 'LIKE', "%{$key}%")
            ->orWhere("products.prod_id", 'LIKE', "%{$key}%")
            ->orWhere("products.description", 'LIKE', "%{$key}%")
            ->orderBy('products.prod_id', $orderType);

        if($limit !== 0) {
            $productList->limit($limit);
        }

        if ($productList->count() > 0) {
            return response()->json(["data"=>$productList->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }



    /**
     * Shop Search Function. It's a private function that is called by above functions.
     * @param Int $shopId
     * @param Int $limit
     * @param string $orderType
     * @return object
     */
    private function searchShop(Int $shopId, Int $limit=10, String $orderType='ASC') : object {
        $shopList = DB::table("shops")->select("*")
            ->where('shops.sch_id', $shopId)
            ->where('shops.status', '1')
            ->where('shops.opening_status', '1')
            ->where('shops.deleted', null)
            ->orderBy('shops.sch_id', $orderType);

        if($limit !== 0) {
            $shopList->limit($limit);
        }

        if ($shopList->count() > 0) {
            return response()->json(["data"=>$shopList->get(), "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }
    // Search API functions End


}
