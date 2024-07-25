<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ShopController;
use Database\Factories\ShopFactory;

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
        $this->get("get_regular_shop_list/2/ShopID")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListWithURLWithLimitOrderBYAndOrderType(): void
    {
        $this->get("get_regular_shop_list/2/ShopID/desc")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListWithURLWithMoreParameters(): void
    {
        $this->get("get_regular_shop_list/2/ShopID/desc/43")
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
     * Testing of GetRegularShopsListByCategory API
     */
    public function testGetRegularShopsListByCategoryWithURLWithParameterCategory(): void
    {
        $this->get("get_regular_shop_list_by_category/5")
            ->assertStatus(200);
    }


    public function testGetRegularShopsListByCategoryWithURLWithParameterZero(): void
    {
        $this->get("get_regular_shop_list_by_category/0")
            ->assertStatus(404);
    }


    public function testGetRegularShopsListByCategoryWithURLWithParameterCategoryWithLimit(): void
    {
        $this->get("get_regular_shop_list_by_category/5/3")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListByCategoryWithURLWithCategoryWithLimitAndOrderType(): void
    {
        $this->get("get_regular_shop_list_by_category/5/2/ShopID")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListByCategoryWithURLWithCategoryWithLimitOrderBYAndOrderType(): void
    {
        $this->get("get_regular_shop_list_by_category/5/2/ShopID/desc")
            ->assertStatus(200);
    }

    public function testGetRegularShopsListByCategoryWithCategoryWithURLWithMoreParameters(): void
    {
        $this->get("get_regular_shop_list_by_category/2/ShopID/desc/43")
            ->assertStatus(500);
    }

    public function testGetRegularShopsListByCategoryFunction() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsListByCategory(5);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListByCategoryFunctionWithLimit() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsListByCategory(5, 2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListByCategoryFunctionWithLimitAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsListByCategory(5, 2, 'ShopID', 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetRegularShopsListByCategoryFunctionWithLimitZeroAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getRegularShopsListByCategory(5,0, null, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }




    /**
     * Testing of GetLocalShopsList API
     */
//    public function testGetLocalShopsListWithURL(): void
//    {
//        $this->get("get_local_shop_list")
//            ->assertStatus(200);
//    }


    public function testGetLocalShopsListWithURLWithLimitZero(): void
    {
        $this->get("get_local_shop_list/0")
            ->assertStatus(404);
    }


//    public function testGetLocalShopsListWithURLWithLimit(): void
//    {
//        $this->get("get_local_shop_list/1")
//            ->assertStatus(200);
//    }

//    public function testGetLocalShopsListWithURLWithLimitAndOrderType(): void
//    {
//        $this->get("get_local_shop_list/2/ShopID")
//            ->assertStatus(200);
//    }

//    public function testGetLocalShopsListWithURLWithLimitOrderBYAndOrderType(): void
//    {
//        $this->get("get_local_shop_list/2/ShopID/desc")
//            ->assertStatus(200);
//    }

    public function testGetLocalShopsListWithURLWithMoreParameters(): void
    {
        $this->get("get_local_shop_list/2/ShopID/desc/43")
            ->assertStatus(404);
    }


    public function testGetLocalShopsListFunctionWithLimit() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetLocalShopsListFunctionWithLimitAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(1,2, 'ShopID', 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetLocalShopsListFunctionWithLimitZeroAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(1,0, null, 'asc');
        $this->assertArrayHasKey('data', $response->original);
    }

    /**
     * Testing of GetLocalShopsListByCategory API
     */
//    public function testGetLocalShopsListByCategoryWithURLWithParameterCategory(): void
//    {
//        $this->get("get_local_shop_list_by_category/5")
//            ->assertStatus(200);
//    }


//    public function testGetLocalShopsListByCategoryWithURLWithParameterZero(): void
//    {
//        $this->get("get_local_shop_list_by_category/0")
//            ->assertStatus(404);
//    }


//    public function testGetLocalShopsListByCategoryWithURLWithParameterCategoryWithLimit(): void
//    {
//        $this->get("get_local_shop_list_by_category/5/3")
//            ->assertStatus(200);
//    }

//    public function testGetLocalShopsListByCategoryWithURLWithCategoryWithLimitAndOrderType(): void
//    {
//        $this->get("get_local_shop_list_by_category/5/2/ShopID")
//            ->assertStatus(200);
//    }

//    public function testGetLocalShopsListByCategoryWithURLWithCategoryWithLimitOrderBYAndOrderType(): void
//    {
////        $insert = ShopFactory()->create();
//        $this->get("get_local_shop_list_by_category/5/2/ShopID/desc")
//            ->assertStatus(200);
//    }

    public function testGetLocalShopsListByCategoryWithCategoryWithURLWithMoreParameters(): void
    {
        $this->get("get_local_shop_list_by_category/2/ShopID/desc/43")
            ->assertStatus(500);
    }

    public function testGetLocalShopsListByCategoryFunction() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(5);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetLocalShopsListByCategoryFunctionWithLimit() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(5, 2);
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetLocalShopsListByCategoryFunctionWithLimitAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(5, 2, 'ShopID', 'desc');
        $this->assertArrayHasKey('data', $response->original);
    }

    public function testGetLocalShopsListByCategoryFunctionWithLimitZeroAndOrderType() : void {
        $shopController = new ShopController();
        $response = $shopController->getLocalShopsListByCategory(5,0, null, 'asc');
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

//    public function testGetShopDetailsWithURL(){
//        $this->get("get_shop_details/2")
//            ->assertStatus(404);
//    }

    public function testGetShopDetailsWithURLByZero(){
        $this->get("get_shop_details/0")
            ->assertStatus(404);
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
