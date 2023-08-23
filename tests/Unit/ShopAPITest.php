<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ShopController;

class ShopAPITest extends TestCase
{
    /**
     * Testing of GetRegularShopsList API
     */
    public function testGetRegularShopsListWithURL(): void
    {
        $this->get("get_regular_shop_list")
            ->assertStatus(200);
    }


    public function testGetRegularShopsListWithURLWithLimitZero(): void
    {
        $this->get("get_regular_shop_list/0")
            ->assertStatus(200);
    }


    public function testGetRegularShopsListWithURLWithLimit(): void
    {
        $this->get("get_regular_shop_list/1")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListWithURLWithLimitAndOrderType(): void
    {
        $this->get("get_popular_products/2/desc")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListWithURLWithMoreParameters(): void
    {
        $this->get("get_popular_products/2/desc/43")
            ->assertStatus(404);
    }

    public function testGetRegularShopsListFunction() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsList();
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListFunctionWithLimit() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsList(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListFunctionWithLimitAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsList(2, 'ShopID', 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListFunctionWithLimitZeroAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsList(0, null, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }


    /**
     * Testing of getShopDetails function
     */
    public function testGetShopDetailsFunction(){
        $shopController = new ShopController();
        $response = $shopController->getShopDetails(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetShopDetailsFunctionWithShopIDZero(){
        $shopController = new ShopController();
        $response = $shopController->getShopDetails(0);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetShopDetailsWithURL(){
        $this->get("get_shop_details/2")
            ->assertStatus(200);
    }

    public function testGetShopDetailsWithURLByZero(){
        $this->get("get_shop_details/0")
            ->assertStatus(200);
    }

    public function testGetShopDetailsWithURLWithoutParameter(){
        $this->get("get_shop_details")
            ->assertStatus(404);
    }

    public function testGetShopDetailsWithURLByAddingMoreParameters(){
        $this->get("get_shop_details/2/4")
            ->assertStatus(404);
    }

}
