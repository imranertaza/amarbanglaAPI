<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ProductContoller;

class ProductsAPITest extends TestCase
{
    /**
     * Testing of GetPouplarProductList API
     */
    public function testGetPopularProductList(): void
    {
        $this->get("get_popular_products")
            ->assertStatus(200);
    }


    public function testGetPopularProductListWithLimitZero(): void
    {
        $this->get("get_popular_products/0")
            ->assertStatus(200);
    }


    public function testGetPopularProductListWithLimit(): void
    {
        $this->get("get_popular_products/1")
            ->assertStatus(200);
    }

    public function testGetPopularProductListWithLimitAndOrderType(): void
    {
        $this->get("get_popular_products/2/desc")
            ->assertStatus(200);
    }

    public function testGetPopularProductListFunction() : void {
        $productController = new ProductContoller();
        $response = $productController->getPopularProductList();
//        $data = json_decode($response, true);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetPopularProductListFunctionWithLimit() : void {
        $productController = new ProductContoller();
        $response = $productController->getPopularProductList(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetPopularProductListFunctionWithLimitAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getPopularProductList(2, 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetPopularProductListFunctionWithLimitZeroAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getPopularProductList(0, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }




    /**
     * Testing of GetHotProductList API
     */
    public function testGetHotProductList(): void
    {
        $this->get("get_hot_products")
            ->assertStatus(200);
    }


    public function testGetHotProductListWithLimitZero(): void
    {
        $this->get("get_hot_products/0")
            ->assertStatus(200);
    }


    public function testGetHotProductListWithLimit(): void
    {
        $this->get("get_hot_products/1")
            ->assertStatus(200);
    }

    public function testGetHotProductListWithLimitAndOrderType(): void
    {
        $this->get("get_hot_products/2/desc")
            ->assertStatus(200);
    }

    public function testGetHotProductListFunction() : void {
        $productController = new ProductContoller();
        $response = $productController->getHotProductList();
//        $data = json_decode($response, true);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetHotProductListFunctionWithLimit() : void {
        $productController = new ProductContoller();
        $response = $productController->getHotProductList(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetHotProductListFunctionWithLimitAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getHotProductList(2, 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetHotProductListFunctionWithLimitZeroAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getHotProductList(0, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }


    /**
     * Testing of GetFeaturedProductList API
     */
    public function testGetFeaturedProductList(): void
    {
        $this->get("get_featured_products")
            ->assertStatus(200);
    }


    public function testGetFeaturedProductListWithLimitZero(): void
    {
        $this->get("get_featured_products/0")
            ->assertStatus(200);
    }


    public function testGetFeaturedProductListWithLimit(): void
    {
        $this->get("get_featured_products/1")
            ->assertStatus(200);
    }

    public function testGetFeaturedProductListWithLimitAndOrderType(): void
    {
        $this->get("get_featured_products/2/desc")
            ->assertStatus(200);
    }


    public function testGetFeaturedProductListFunction() : void {
        $productController = new ProductContoller();
        $response = $productController->getFeaturedProductList();
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetFeaturedProductListFunctionWithLimit() : void {
        $productController = new ProductContoller();
        $response = $productController->getFeaturedProductList(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetFeaturedProductListFunctionWithLimitAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getFeaturedProductList(2, 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetFeaturedProductListFunctionWithLimitZeroAndOrderType() : void {
        $productController = new ProductContoller();
        $response = $productController->getFeaturedProductList(0, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }





}
