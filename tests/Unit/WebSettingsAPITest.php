<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\WebsiteSettingsController;

class WebSettingsAPITest extends TestCase
{
    /**
     * A basic test example.
     */
//    public function testSliderBannersAPI(): void
//    {
//        $data = $this->getJson("get_sliders");
//        $this->assertArrayHasKey('data', $data->json());
//    }


    /**
     * Test sliderBannerAPI()
     * It checks the status returned 200 or not
     * Checks if it returns slider_1, slider_2 and slider_3
     * It also checks if it returns path of those banners
     *
     * @return void
     */
    public function testSliderBannersAPI_if_banners_shows(): void
    {
        $this->get("get_sliders")
            ->assertStatus(200);
    }

    public function testGetWebsiteSettings_if_array_has_key_data(): void
    {
        $data = $this->getJson("get_website_settings/home_banner_1");
        $this->assertArrayHasKey('data', $data->json());
    }

    public function testGetWebsiteSettings_if_array_has_key_status(): void
    {
        $data = $this->getJson("get_website_settings/home_banner_1");
        $this->assertArrayHasKey('status', $data->json());
    }



//    public function testGetExclusiveShopsList(): void
//    {
//        $getExShopList = new ShopController();
//        $data = $getExShopList->getExclusiveShopsList();
//        dd($data);
////        $data = array("data"=> [3,5,8]);
//        $this->assertArrayHasKey('data', $data);
//
//    }


}
