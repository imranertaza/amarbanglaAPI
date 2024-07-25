<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ShopController;

class ShopGeneralSettingAPITest extends TestCase
{
    /**
     * Testing of GetShopSettingsInfo API
     */
    public function testGetShopSettingsInfoWithURL(): void
    {
        $this->get("get_shop_settings_info/2/")
            ->assertStatus(404);
    }

    public function testGetShopSettingsInfoWithURLPassingMoreParameters(): void
    {
        $this->get("get_shop_settings_info/2/customer_panel_video")
            ->assertStatus(200);
    }


    public function testGetShopSettingsInfoWithURLWithParameterZero(): void
    {
        $this->get("get_shop_settings_info/0")
            ->assertStatus(404);
    }


    public function testGetShopSettingsInfoFunction() : void {
        $shopController = new ShopController();
        $response = $shopController->getShopSettingsInfo(2,'customer_panel_video');
        $this->assertArrayHasKey('data', $response->original);
    }



    /**
     * Testing of GetShopSettingsInfo API
     */
    public function testGetShopYoutubeURLWithURL(): void
    {
        $this->get("get_shop_youtube_url/2/")
            ->assertStatus(200);
    }

    public function testGetShopYoutubeURLWithURLPassingMoreParameters(): void
    {
        $this->get("get_shop_youtube_url/2/3")
            ->assertStatus(404);
    }


    public function testGetShopYoutubeURLWithURLWithParameterZero(): void
    {
        $this->get("get_shop_youtube_url/0")
            ->assertStatus(404);
    }


    public function testGetShopYoutubeURLFunction() : void {
        $shopController = new ShopController();
        $response = $shopController->getShopYoutubeURL(2);
        $this->assertArrayHasKey('data', $response->original);
    }


}
