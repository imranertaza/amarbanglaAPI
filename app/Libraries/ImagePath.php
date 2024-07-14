<?php

namespace App\Libraries;

use App\Models\Shops;
use App\Models\GeneralSettings;

class ImagePath
{
    public string $profile_image_path;
    public string $logo_path;
    public string $banner_path;
    public string $customer_panel_banner;
    public string $customer_panel_banner_mobile;
    private int $shopID;
    private string $image_directory = "uploads/schools/";
    private string $image_customer_directory = "uploads/customer_dashboard/";
    private string $amarBanglaURL = "https://amarbangla.com.bd/";

    public function __construct(int $shopID) {
        $this->shopID = $shopID;
        $this->set_image_path();
        $this->set_customer_panel_banners();
        $this->customer_panel_banner_mobile();
        return $this;
    }

    /**
     * @description This method sets logo, profile_image and banner image path.
     * @return void
     */
    public function set_image_path() : void {
        $image = Shops::select("logo", "image", "banner")->where("sch_id", $this->shopID)->first();
        if ($image->count() > 0) {

            // Set logo Path
            if ($this->url_exist($this->amarBanglaURL.$this->image_directory.$image->logo)) {
                $this->logo_path = $this->amarBanglaURL.$this->image_directory.$image->logo;
            }else {
                $this->logo_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
            }

            // Set profile image path
            if ($this->url_exist($this->amarBanglaURL.$this->image_directory.$image->image)) {
                $this->profile_image_path = $this->amarBanglaURL.$this->image_directory.$image->image;
            }else {
                $this->profile_image_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
            }


            // Set banner image path
            if ($this->url_exist($this->amarBanglaURL.$this->image_directory.$image->banner)) {
                $this->banner_path = $this->amarBanglaURL.$this->image_directory.$image->banner;
            }else {
                $this->banner_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
            }

        }else {
            $this->banner_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
            $this->profile_image_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
            $this->logo_path = $this->amarBanglaURL.$this->image_directory."no_image.jpg";
        }
    }


    /**
     * @description This method sets customer panel banner image path.
     * @return void
     */
    public function set_customer_panel_banners() : void{
        $result = GeneralSettings::select("value")
            ->where("label", "customer_panel_banner")
            ->Where("sch_id", $this->shopID)->get();

        if ($this->url_exist($this->amarBanglaURL.$this->image_customer_directory.$result[0]->value)) {
            $this->customer_panel_banner = $this->amarBanglaURL.$this->image_customer_directory.$result[0]->value;
        }else {
            $this->customer_panel_banner = $this->amarBanglaURL.$this->image_customer_directory."no_image.jpg";
        }
    }

    /**
     * @description This method sets customer mobile panel banner image path.
     * @return void
     */
    public function customer_panel_banner_mobile() : void{
        $result = GeneralSettings::select("value")
            ->where("label", "customer_panel_banner_mobile")
            ->Where("sch_id", $this->shopID)->get();

        if ($this->url_exist($this->amarBanglaURL.$this->image_customer_directory.$result[0]->value)) {
            $this->customer_panel_banner_mobile = $this->amarBanglaURL.$this->image_customer_directory.$result[0]->value;
        }else {
            $this->customer_panel_banner_mobile = $this->amarBanglaURL.$this->image_customer_directory."no_image.jpg";
        }
    }


    /**
     * @description This method checks if the image exist in the given URL.
     *
     * @param string $url
     * @return bool
     */
    public function url_exist(string $url):bool{
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);
        if ($result !== false)
        {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            return $statusCode == 200;
        }
        else
        {
            return false;
        }
    }
}
