<?php

namespace App\Libraries;

use App\Models\Shops;

class ImagePath
{
    public string $profile_image_path;
    public string $logo_path;
    public string $banner_path;
    public string $customer_panel_banner;
    public string $customer_panel_banner_mobile;
    private int $shopID;

    public function __construct(int $shopID) {
        $this->shopID = $shopID;
        $this->set_image_path();
        return $this;
    }

    public function set_image_path() : void {
        $image_directory = "uploads/schools/";
        $image = Shops::select("logo", "image", "banner")->where("sch_id", $this->shopID)->first();
        if ($image->count() > 0) {

            // Set logo Path
            if ($this->url_exist("http://amarbangla.dn/uploads/customer_dashboard/banner_1692417408.jpg")) {
                $this->logo_path = config('app.url').$image_directory.$image->logo;
            }else {
                $this->logo_path = config('app.url').$image_directory."no_image.jpg";
            }

            // Set profile image path
            if ($this->url_exist("https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg")) {
                $this->profile_image_path = config('app.url').$image_directory.$image->image;
            }else {
                $this->profile_image_path = config('app.url').$image_directory."no_image.jpg";
            }


            // Set banner image path
            if ($this->url_exist("https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg")) {
                $this->banner_path = config('app.url').$image_directory.$image->banner;
            }else {
                $this->banner_path = config('app.url').$image_directory."no_image.jpg";
            }

        }else {
            $this->banner_path = "Not Set";
            $this->profile_image_path = "Not Set";
            $this->logo_path = "Not Set";
        }
    }


    public function url_exist($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false)
        {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode == 404)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }
}
