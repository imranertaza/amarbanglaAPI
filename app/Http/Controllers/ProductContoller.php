<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use Exception;

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

    public function getPopularProductList(Int $offset=0, Int $limit=0, string $orderType='ASC') : object {
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.popular", 1)
            ->orderBy('products.prod_id', $orderType);

        if(($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }

        if($limit !== 0) {
            $shopList->limit($limit);
        }
        $data = $shopList->get();
        if (count($data) > 0) {
            foreach($data as $key=>$value) {
                if ($value->demo_id == null){
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                }else{
                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return response()->json(["data"=>$data, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }

    public function getHotProductList(Int $offset=0, ?Int $limit=0, string $orderType='ASC') : object {
        $shopList = DB::table("products")->select("*", "products.name as name", "shops.name as shop_name")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.hot", 1)
            ->orderBy('products.prod_id', $orderType);

        if(($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }

        if($limit !== 0) {
            $shopList->limit($limit);
        }
        $all_product_info = $shopList->get();
        if (count($all_product_info) > 0) {
            foreach($all_product_info as $k=>$singleProductInfo) {
                $shopData[$k]['product_image_path'] = "https://amarbangla.com.bd/uploads/product_image/";
                
                foreach($singleProductInfo as $key=>$value) {
                    $shopData[$k][$key] = $value;
                    
                    //update picture from demo product table if picture is null in product table
                    if (($key == 'picture') && ($value == null) && ($all_product_info[$k]->demo_id) != null) {
                        $shopData[$k]['picture'] = $this->getDemoProductPicture($all_product_info[$k]->demo_id);
                        $shopData[$k]['product_image_path'] = "https://amarbangla.com.bd/uploads/demo_product_image/";
                    }
                }
            }
            return response()->json(["data"=>$shopData, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 200);
        }
    }

    private function getDemoProductPicture(int $demoProductID) : string|null|array {
        $demoProduct = DB::table("demo_products")->select("*")
            ->where('id', $demoProductID)->first();
        return $demoProduct->picture;
    }


    public function getFeaturedProductList(?Int $offset=0, ?Int $limit=0, string $orderType='ASC') : object {
        
        // Enable query logging
        DB::connection()->enableQueryLog();
        
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.featured", 1)
            ->orderBy('products.prod_id', $orderType);

        if(($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }
        
        if($limit !== 0) {
            $shopList->limit($limit);
        }

        $data = $shopList->get();
        if (count($data) > 0) {
            foreach($data as $key=>$value) {
                if ($value->demo_id == null){
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                }else{
                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return response()->json(["data"=>$data, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 404);
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

    /**
     * Get Product Image by providing product ID
     * @param int $productID
     * @return string
     */
    public function getProductImage(int $productID) : object {
        $detailsQuery = Products::find($productID);
        if (!empty($detailsQuery)){
            if ($detailsQuery->get()->count() > 0) {
                $productImage = json_decode($detailsQuery->first()->picture);
                return response()->json(["data"=>$productImage->{1}, "status"=>200], 200);
            }else {
                return response()->json(["data"=>"no_image.jpg", "status"=>404], 200);
            }
        }else {
            return response()->json(["data"=>"no_image.jpg", "status"=>404], 200);
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
     * @param string $key
     * @param Int $limit
     * @param string $orderType
     * @return object
     */
    private function searchProduct(String $key, Int $limit=10, String $orderType='ASC') : object {
        $productList = DB::table("products")->select("*", 'products.name AS product_name')
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.opening_status', '1')
            ->where('shops.status', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("products.name", 'LIKE', "%{$key}%")
            // ->where("products.name", 'LIKE', "%{$key}%")
            ->orWhere("products.prod_id", 'LIKE', "%{$key}%")
            // ->orWhere("products.prod_id", 'LIKE', "%{$key}%")
            ->orWhere("products.description", 'LIKE', "%{$key}%")
            ->orderBy('products.prod_id', $orderType);

        if($limit !== 0) {
            $productList->limit($limit);
        }

        $data = $productList->get();
        if ($data->count() > 0) {
            foreach($data as $key=>$value) {
                
                if ($value->demo_id == null){
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                }else{
                    
                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return response()->json(["data"=>$data, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>200], 200);
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
            return response()->json(["data"=>"No Result Found.", "status"=>200], 200);
        }
    }
    // Search API functions End



}
