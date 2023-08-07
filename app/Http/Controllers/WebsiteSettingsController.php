<?php

namespace App\Http\Controllers;


use App\Models\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebsiteSettingsController extends Controller
{
    protected string $imagePath = "/var/www/amarbangla.dn/public_html/uploads/website_image/";
    public function slider_banners() : object {
        for($i=1; $i<=3; $i++){
            $img_name = WebsiteSettings::where('label', 'slider_'.$i.'_mob')->get()[0]->value;
            $sliderImage = $this->imagePath.$img_name;
            $data['slider_'.$i] =  (!file_exists($sliderImage)) ? "slider_mo.jpg" : $img_name;
        }
        $data['path'] = url("/uploads/website_image/");
        return response()->json(["data" => $data, "status"=>200], 200);
    }

    public function getWebsiteSettings(string $label) : object {
        $query = WebsiteSettings::where('label', $label);
        if ($query->count() > 0) {
            return response()->json(["data"=>$query->first()->value, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 404);
        }
    }


}
