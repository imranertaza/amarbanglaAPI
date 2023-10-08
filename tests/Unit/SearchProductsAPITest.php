<?php

namespace Tests\Unit;

use ReflectionMethod;
use Tests\TestCase;
use App\Http\Controllers\ProductContoller;

class SearchProductsAPITest extends TestCase
{
    /**
     * Testing of GetPouplarProductList API
     */
    public function testSearchItem(): void
    {
        $response = $this->post("search", [
            'search_item' => '5',
        ])->assertStatus(200);
        $this->assertArrayHasKey('data', $response->original);
    }


    /**
     * Testing function for POST API function "SearchItemWithLimit" if it is working
     */
    public function testSearchItemWithLimit(): void
    {
        $response = $this->post("search/2", [
            'search_item' => '2',
        ])->assertStatus(200);
        $this->assertArrayHasKey('data', $response->original);
    }


    /**
     * Testing function for POST API function "SearchItemWithLimitAndOrderType" if it is working
     */
    public function testSearchItemWithLimitAndOrderType(): void
    {
        $response = $this->post("search/2/DESC", [
            'search_item' => '85',
        ])->assertStatus(200);
        $this->assertArrayHasKey('data', $response->original);
    }


    /**
     * Tested the private function "SearchProduct"
     * @throws \ReflectionException
     */
    public function testSearchProduct() : void {
        $productController = new ProductContoller();
        $response = new ReflectionMethod($productController, 'searchProduct');
        $result = $response->invokeArgs($productController, array(2, 2));
//        dd($result);
//        $response = $reflectionMethod->getMethod( 'searchProduct');
//        $getMethod->setAccessible("public");
//        $result = $getMethod->invoke($productController, );
//        $response = $productController->searchProduct(2);
//        $data = json_decode($response, true);
        $this->assertArrayHasKey('data', $result->original);
    }


    /**
     * Tested the private function "SearchShop"
     * @throws \ReflectionException
     */
    public function testSearchShop() : void {
        $productController = new ProductContoller();
        $response = new ReflectionMethod($productController, 'searchShop');
        $result = $response->invokeArgs($productController, array(2, 2));
        $this->assertArrayHasKey('data', $result->original);
    }


//    public function testGetPopularProductListWithLimitZero(): void
//    {
//        $this->get("get_popular_products/0")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetPopularProductListWithLimit(): void
//    {
//        $this->get("get_popular_products/1")
//            ->assertStatus(200);
//    }
//
//    public function testGetPopularProductListWithLimitAndOrderType(): void
//    {
//        $this->get("get_popular_products/2/desc")
//            ->assertStatus(200);
//    }
//
//    public function testGetPopularProductListFunction() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getPopularProductList();
////        $data = json_decode($response, true);
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetPopularProductListFunctionWithLimit() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getPopularProductList(2);
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetPopularProductListFunctionWithLimitAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getPopularProductList(2, 'desc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetPopularProductListFunctionWithLimitZeroAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getPopularProductList(0, 'asc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//
//
//
//    /**
//     * Testing of GetHotProductList API
//     */
//    public function testGetHotProductList(): void
//    {
//        $this->get("get_hot_products")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetHotProductListWithLimitZero(): void
//    {
//        $this->get("get_hot_products/0")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetHotProductListWithLimit(): void
//    {
//        $this->get("get_hot_products/1")
//            ->assertStatus(200);
//    }
//
//    public function testGetHotProductListWithLimitAndOrderType(): void
//    {
//        $this->get("get_hot_products/2/desc")
//            ->assertStatus(200);
//    }
//
//    public function testGetHotProductListFunction() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getHotProductList();
////        $data = json_decode($response, true);
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetHotProductListFunctionWithLimit() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getHotProductList(2);
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetHotProductListFunctionWithLimitAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getHotProductList(2, 'desc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetHotProductListFunctionWithLimitZeroAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getHotProductList(0, 'asc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//
//    /**
//     * Testing of GetFeaturedProductList API
//     */
//    public function testGetFeaturedProductList(): void
//    {
//        $this->get("get_featured_products")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetFeaturedProductListWithLimitZero(): void
//    {
//        $this->get("get_featured_products/0")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetFeaturedProductListWithLimit(): void
//    {
//        $this->get("get_featured_products/1")
//            ->assertStatus(200);
//    }
//
//    public function testGetFeaturedProductListWithLimitAndOrderType(): void
//    {
//        $this->get("get_featured_products/2/desc")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetFeaturedProductListFunction() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getFeaturedProductList();
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetFeaturedProductListFunctionWithLimit() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getFeaturedProductList(2);
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetFeaturedProductListFunctionWithLimitAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getFeaturedProductList(2, 'desc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//    public function testGetFeaturedProductListFunctionWithLimitZeroAndOrderType() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getFeaturedProductList(0, 'asc');
//        $this->assertArrayHasKey('data', $response->original);
//    }
//
//
//
//    /**
//     * Testing of getProductDetails API
//     */
//    public function testGetProductDetailsAPI(): void
//    {
//        $this->get("get_products_details/2/6")
//            ->assertStatus(200);
//    }
//
//
//    public function testGetProductDetailsWithoutShopID(): void
//    {
//        $this->get("get_featured_products/2")
//            ->assertStatus(200)->isNotFound();
//    }
//
//
//    public function testGetProductDetailsWithoutParameters(): void
//    {
//        $this->get("get_featured_products")
//            ->assertStatus(200)->isNotFound();
//    }
//
//
//    public function testGetProductDetailsFunction() : void {
//        $productController = new ProductContoller();
//        $response = $productController->getProductDetails(2, 6);
//        $this->assertArrayHasKey('data', $response->original);
//    }

}
