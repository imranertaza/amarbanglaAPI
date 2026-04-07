<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\Shops;
use Exception;


class ProductController extends Controller
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



    /**
     * Retrieve popular product list
     *
     * This endpoint returns a list of popular products across shops.
     * Products must be active, not deleted, and marked as popular.
     * Supports pagination and ordering.
     *
     * @queryParam offset int optional The number of records to skip before starting to return results. Default is 0.
     * @queryParam limit int optional The maximum number of products to retrieve. Default is 0 (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "prod_id": 1,
     *       "name": "Popular Product A",
     *       "picture": "product_a.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/product_image/"
     *     },
     *     {
     *       "prod_id": 2,
     *       "name": "Popular Product B",
     *       "picture": "product_b.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/demo_product_image/"
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
     * @param int $offset The number of records to skip before starting to return results. Default is 0.
     * @param int $limit The maximum number of products to retrieve. Default is 0 (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of popular products (200)
     *                      or an error message if none are found (404).
     */

    public function getPopularProductList(Int $offset = 0, Int $limit = 0, string $orderType = 'ASC'): object
    {
        $shopList = DB::table("products")->select("*")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.popular", 1)
            ->orderBy('products.prod_id', $orderType);

        if (($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }

        if ($limit !== 0) {
            $shopList->limit($limit);
        }
        $data = $shopList->get();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($value->demo_id == null) {
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                } else {
                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return response()->json(["data" => $data, "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }

    /**
     * Retrieve hot product list
     *
     * This endpoint returns a list of hot products across shops.
     * Products must be active, not deleted, and marked as hot.
     * Supports pagination and ordering.
     *
     * @queryParam offset int optional The number of records to skip before starting to return results. Default is 0.
     * @queryParam limit int optional The maximum number of products to retrieve. Default is 0 (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "prod_id": 1,
     *       "name": "Hot Product A",
     *       "shop_name": "Electronics Hub",
     *       "picture": "product_a.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/product_image/"
     *     },
     *     {
     *       "prod_id": 2,
     *       "name": "Hot Product B",
     *       "shop_name": "Fashion World",
     *       "picture": "product_b.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/demo_product_image/"
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
     * @param int $offset The number of records to skip before starting to return results. Default is 0.
     * @param int|null $limit The maximum number of products to retrieve. Default is 0 (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of hot products (200)
     *                      or an error message if none are found (404).
     */

    public function getHotProductList(Int $offset = 0, ?Int $limit = 0, string $orderType = 'ASC'): object
    {
        $shopList = DB::table("products")->select("*", "products.name as name", "shops.name as shop_name")
            ->join('product_features', 'product_features.prod_id', "=", "products.prod_id")
            ->join('shops', 'products.sch_id', "=", "shops.sch_id")
            ->where('shops.priority', '1')
            ->where('products.status', '1')
            ->where("products.deleted", null)
            ->where("product_features.hot", 1)
            ->orderBy('products.prod_id', $orderType);

        if (($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }

        if ($limit !== 0) {
            $shopList->limit($limit);
        }
        $all_product_info = $shopList->get();
        if (count($all_product_info) > 0) {
            foreach ($all_product_info as $k => $singleProductInfo) {
                $shopData[$k]['product_image_path'] = "https://amarbangla.com.bd/uploads/product_image/";

                foreach ($singleProductInfo as $key => $value) {
                    $shopData[$k][$key] = $value;

                    //update picture from demo product table if picture is null in product table
                    if (($key == 'picture') && ($value == null) && ($all_product_info[$k]->demo_id) != null) {
                        $shopData[$k]['picture'] = $this->getDemoProductPicture($all_product_info[$k]->demo_id);
                        $shopData[$k]['product_image_path'] = "https://amarbangla.com.bd/uploads/demo_product_image/";
                    }
                }
            }
            return response()->json(["data" => $shopData, "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }

    private function getDemoProductPicture(int $demoProductID): string|null
    {
        $demoProduct = DB::table("demo_products")->select("*")
            ->where('id', $demoProductID)->first();
        return $demoProduct->picture;
    }


    /**
     * Retrieve featured product list
     *
     * This endpoint returns a list of featured products across shops.
     * Products must be active, not deleted, and marked as featured.
     * Supports pagination and ordering.
     *
     * @queryParam offset int optional The number of records to skip before starting to return results. Default is 0.
     * @queryParam limit int optional The maximum number of products to retrieve. Default is 0 (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "prod_id": 1,
     *       "name": "Featured Product A",
     *       "picture": "product_a.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/product_image/"
     *     },
     *     {
     *       "prod_id": 2,
     *       "name": "Featured Product B",
     *       "picture": "product_b.png",
     *       "product_image_path": "https://amarbangla.com.bd/uploads/demo_product_image/"
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
     * @param int|null $offset The number of records to skip before starting to return results. Default is 0.
     * @param int|null $limit The maximum number of products to retrieve. Default is 0 (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     *
     * @return JsonResponse A JSON response containing either the list of featured products (200)
     *                      or an error message if none are found (404).
     */

    public function getFeaturedProductList(?Int $offset = 0, ?Int $limit = 0, string $orderType = 'ASC'): object
    {

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

        if (($offset !== 0) && ($limit !== 0)) {
            $shopList->offset($offset);
        }

        if ($limit !== 0) {
            $shopList->limit($limit);
        }

        $data = $shopList->get();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($value->demo_id == null) {
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                } else {
                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return response()->json(["data" => $data, "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }

    /**
     * Retrieve product details by ID
     *
     * This endpoint returns detailed information about a specific product
     * within a given shop. Products must be active and not deleted.
     *
     * @urlParam productID int required The unique ID of the product to retrieve details for.
     * @urlParam shopID int required The unique ID of the shop the product belongs to.
     *
     * @response 200 {
     *   "data": {
     *     "prod_id": 1,
     *     "sch_id": 10,
     *     "name": "Sample Product",
     *     "price": 250,
     *     "status": 1,
     *     "picture": "product.png"
     *   },
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int $productID The unique product ID used to retrieve details.
     * @param int $shopID The unique shop ID the product belongs to.
     *
     * @return JsonResponse A JSON response containing either the product details (200)
     *                      or an error message if none are found (404).
     */

    public function getProductDetails(int $productID, int $shopID): object
    {
        $detailsQuery = Products::where('prod_id', $productID)->where('sch_id', $shopID);
        if ($detailsQuery->get()->count() > 0) {
            return response()->json(["data" => $detailsQuery->first(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }





    /**
     * Retrieve product size options
     *
     * This endpoint returns all available size options for a specific product
     * within a given shop. Products are grouped by product code, so multiple
     * size variations can be retrieved.
     *
     * @urlParam productID int required The unique ID of the product to retrieve size options for.
     * @urlParam shopID int required The unique ID of the shop the product belongs to.
     *
     * @response 200 {
     *   "data": [
     *     {"prod_id": 101, "size": "Small"},
     *     {"prod_id": 102, "size": "Medium"},
     *     {"prod_id": 103, "size": "Large"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @response 500 {
     *   "data": "An error occurred.",
     *   "status": 500
     * }
     *
     * @param int $productID The unique product ID used to retrieve size options.
     * @param int $shopID The unique shop ID the product belongs to.
     *
     * @return JsonResponse A JSON response containing either the list of size options (200),
     *                      an error message if none are found (404),
     *                      or a server error message (500).
     */

    public function getProductSizeOption(int $productID, int $shopID): object
    {
        try {
            $detailsInfo = Products::where('prod_id', $productID)->where('sch_id', $shopID)->first();

            if (!$detailsInfo) {
                return response()->json(["data" => "No Result Found.", "status" => 404], 404);
            }

            $allOptionProducts = Products::select('prod_id', 'size')
                ->where('product_code', $detailsInfo->product_code)
                ->where('sch_id', $shopID)
                ->get();

            $data = [];
            foreach ($allOptionProducts as $key => $val) {
                if ($val->size !== null) {
                    $data[] = $val;
                }
            }

            if (!empty($data)) {
                return response()->json(["data" => $data, "status" => 200], 200);
            } else {
                return response()->json(["data" => "No Result Found.", "status" => 404], 404);
            }
        } catch (Exception $e) {
            return response()->json(["data" => "An error occurred.", "status" => 500], 500);
        }
    }




    /**
     * Retrieve product color options
     *
     * This endpoint returns all available color options for a specific product
     * within a given shop. Products are grouped by product code, so multiple
     * color variations can be retrieved.
     *
     * @urlParam productID int required The unique ID of the product to retrieve color options for.
     * @urlParam shopID int required The unique ID of the shop the product belongs to.
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "prod_id": 101,
     *       "color_family_id": 5,
     *       "code": "RED01",
     *       "color_name": "Red"
     *     },
     *     {
     *       "prod_id": 102,
     *       "color_family_id": 6,
     *       "code": "BLU01",
     *       "color_name": "Blue"
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
     * @response 500 {
     *   "data": "An error occurred.",
     *   "status": 500
     * }
     *
     * @param int $productID The unique product ID used to retrieve color options.
     * @param int $shopID The unique shop ID the product belongs to.
     *
     * @return JsonResponse A JSON response containing either the list of color options (200),
     *                      an error message if none are found (404),
     *                      or a server error message (500).
     */

    public function getProductColorOption(int $productID, int $shopID): object
    {
        try {
            $detailsInfo = Products::where('prod_id', $productID)->where('sch_id', $shopID)->first();

            if (!$detailsInfo) {
                return response()->json(["data" => "No Result Found.", "status" => 404], 404);
            }

            $allOptionProducts = Products::select('prod_id', 'products.color_family_id', 'code', 'color_name')
                ->where('product_code', $detailsInfo->product_code)
                ->where('sch_id', $shopID)
                ->join('color_family', 'color_family.color_family_id', '=', 'products.color_family_id')
                ->get();
            $data = array();
            foreach ($allOptionProducts as $key => $val) {
                if ($val['color_family_id'] != null) {
                    $data[$key] = $val;
                }
            }

            if (count($data) > 0) {
                return response()->json(["data" => $data, "status" => 200], 200);
            } else {
                return response()->json(["data" => "No Result Found.", "status" => 404], 404);
            }
        } catch (Exception $e) {
            return response()->json(["data" => "An error occurred.", "status" => 500], 500);
        }
    }



    /**
     * Retrieve product image by ID
     *
     * This endpoint returns the product image for a given product ID.
     * If no image is found, a default placeholder (`no_image.jpg`) is returned.
     *
     * @urlParam productID int required The unique ID of the product to retrieve the image for.
     *
     * @response 200 {
     *   "data": "product_image.jpg",
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "no_image.jpg",
     *   "status": 404
     * }
     *
     * @param int $productID The unique product ID used to retrieve the image.
     *
     * @return JsonResponse A JSON response containing either the product image (200)
     *                      or a default placeholder if none is found (404).
     */

    public function getProductImage(int $productID): object
    {
        $product = Products::find($productID);
        // dd($detailsQuery);
        if ($product) {
            $productImage = json_decode($product->picture);
            // dd($productImage);
            return response()->json([
                "data" => $productImage[0] ?? "no_image.jpg",
                "status" => 200
            ], 200);
        }

        return response()->json([
            "data" => "no_image.jpg",
            "status" => 404
        ], 404);
    }


    // Search API functions start
    /**
     * Search items with limit and order type
     *
     * This endpoint searches for either shops or products based on the provided search key.
     * - If the search key starts with `#`, it will search for shops by ID.
     * - Otherwise, it will search for products by name or keyword.
     * Supports optional limit and ordering.
     *
     * @queryParam limit int optional The maximum number of results to retrieve. Default is 0 (no limit).
     * @queryParam orderType string optional The order type. Allowed values: 'ASC', 'DESC'. Default is 'ASC'.
     * @bodyParam search_item string required The search keyword. Prefix with `#` to search by shop ID.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Electronics Hub", "image": "electronics.png"},
     *     {"prod_id": 101, "name": "Smartphone X", "picture": "smartphone.png"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int|null $limit The maximum number of results to retrieve. Default is 0 (no limit).
     * @param string $orderType The order type ('ASC' or 'DESC'). Default is 'ASC'.
     * @param Request $request The request object containing the search keyword (`search_item`).
     *
     * @return JsonResponse A JSON response containing either the search results (200)
     *                      or an error message if none are found (404).
     */

    public function searchItemWithLimitAndOrderType(?Int $limit = 0, string $orderType = 'ASC', Request $request): object
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
     * Search items with limit
     *
     * This endpoint searches for either shops or products based on the provided search key.
     * - If the search key starts with `#`, it will search for shops by ID.
     * - Otherwise, it will search for products by name or keyword.
     * Supports optional limit.
     *
     * @queryParam limit int optional The maximum number of results to retrieve. Default is 0 (no limit).
     * @bodyParam search_item string required The search keyword. Prefix with `#` to search by shop ID.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Electronics Hub", "image": "electronics.png"},
     *     {"prod_id": 101, "name": "Smartphone X", "picture": "smartphone.png"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param int|null $limit The maximum number of results to retrieve. Default is 0 (no limit).
     * @param Request $request The request object containing the search keyword (`search_item`).
     *
     * @return JsonResponse A JSON response containing either the search results (200)
     *                      or an error message if none are found (404).
     */

    public function searchItemWithLimit(?Int $limit = 0, Request $request): object
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
     * Search products or shops
     *
     * This endpoint searches for either shops or products based on the provided search key.
     * - If the search key starts with `#`, it will search for shops by ID.
     * - Otherwise, it will search for products by name or keyword.
     *
     * @bodyParam search_item string required The search keyword. Prefix with `#` to search by shop ID.
     *
     * @response 200 {
     *   "data": [
     *     {"ShopID": 1, "ShopName": "Electronics Hub", "image": "electronics.png"},
     *     {"prod_id": 101, "name": "Smartphone X", "picture": "smartphone.png"}
     *   ],
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param Request $request The request object containing the search keyword (`search_item`).
     *
     * @return JsonResponse A JSON response containing either the search results (200)
     *                      or an error message if none are found (404).
     */

    public function searchItem(Request $request): object
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
    private function searchProduct(String $key, Int $limit = 10, String $orderType = 'ASC'): object
    {
        $productList = Products::with('shop') // eager load shop relation
            ->whereHas('shop', function ($query) {
                $query->where('opening_status', '1')
                    ->where('status', '1');
            })
            ->where('status', '1')
            ->whereNull('deleted')
            ->where(function ($query) use ($key) {
                $query->where('name', 'LIKE', "%{$key}%")
                    ->orWhere('prod_id', 'LIKE', "%{$key}%")
                    ->orWhere('description', 'LIKE', "%{$key}%");
            })
            ->orderBy('prod_id', $orderType);

        if ($limit !== 0) {
            $productList->limit($limit);
        }

        $data = $productList->get();
        if ($data->count() > 0) {
            foreach ($data as $key => $value) {

                if ($value->demo_id == null) {
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/product_image/";
                } else {

                    //update picture from demo product table if picture is null in product table
                    if ($value->picture == null) {
                        $data[$key]->picture = $this->getDemoProductPicture($value->demo_id);
                    }
                    $data[$key]->product_image_path = "https://amarbangla.com.bd/uploads/demo_product_image/";
                }
            }
            return ApiResponse::success('success', 200, $data);
        } else {
            return ApiResponse::error('No Result Found.', 404);
        }
    }



    /**
     * Shop Search Function. It's a private function that is called by above functions.
     * @param Int $shopId
     * @param Int $limit
     * @param string $orderType
     * @return object
     */
    private function searchShop(Int $shopId, Int $limit = 10, String $orderType = 'ASC'): object
    {
        $shopList = Shops::query()
            ->where('sch_id', $shopId)
            ->where('status', '1')
            ->where('opening_status', '1')
            ->whereNull('deleted')
            ->orderBy('sch_id', $orderType);

        if ($limit !== 0) {
            $shopList->limit($limit);
        }

        if ($shopList->count() > 0) {
            return response()->json(["data" => $shopList->get(), "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }
    // Search API functions End
}
