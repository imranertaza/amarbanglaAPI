<?php

namespace App\Http\Controllers;


use App\Models\WebsiteSettings;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebsiteSettingsController extends Controller
{
    protected string $imagePath = "/var/www/amarbangla.dn/public_html/uploads/website_image/";


    /**
     * Retrieve slider banners
     *
     * This endpoint returns the slider banner images configured in website settings.
     * It checks for three mobile slider images (`slider_1_mob`, `slider_2_mob`, `slider_3_mob`).
     * If an image file does not exist, a default placeholder (`slider_mo.jpg`) is returned instead.
     *
     * @response 200 {
     *   "data": [
     *     {"slider": "slider_1.jpg"},
     *     {"slider": "slider_2.jpg"},
     *     {"slider": "slider_mo.jpg"}
     *   ],
     *   "path": "https://example.com/uploads/website_image/",
     *   "status": 200
     * }
     *
     * @param void No parameters are required.
     *
     * @return JsonResponse A JSON response containing the list of slider banner images (200).
     */

    public function slider_banners()
    {
        for ($i = 1; $i <= 3; $i++) {
            $img_name = WebsiteSettings::where('label', 'slider_' . $i . '_mob')->get()[0]->value;
            $sliderImage = $this->imagePath . $img_name;
            $data[]['slider'] =  (!file_exists($sliderImage)) ? "slider_mo.jpg" : $img_name;
        }
        $path = url("/uploads/website_image/");
        return response()->json(["data" => $data, "path" => $path, "status" => 200], 200);
    }



    /**
     * Retrieve website setting by label
     *
     * This endpoint returns the value of a specific website setting
     * based on the provided label key.
     *
     * @urlParam label string required The unique label key of the website setting to retrieve.
     *
     * @response 200 {
     *   "data": "slider_1.jpg",
     *   "status": 200
     * }
     *
     * @response 404 {
     *   "data": "No Result Found.",
     *   "status": 404
     * }
     *
     * @param string $label The label key used to retrieve the website setting.
     *
     * @return JsonResponse A JSON response containing either the setting value (200)
     *                      or an error message if none is found (404).
     */

    public function getWebsiteSettings(string $label): object
    {
        $query = WebsiteSettings::where('label', $label);
        if ($query->count() > 0) {
            return response()->json(["data" => $query->first()->value, "status" => 200], 200);
        } else {
            return response()->json(["data" => "No Result Found.", "status" => 404], 404);
        }
    }
}
