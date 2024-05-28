<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\global_address;

class GlobalAddressController extends Controller
{

    /**
     * Retrieve a list of all divisions.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of divisions and status code.
     */
    public function getAllDivisionList() : object {
        $divisions = array(
            array('id' => '1','name' => 'Chattagram','bn_name' => 'চট্টগ্রাম','url' => 'www.chittagongdiv.gov.bd'),
            array('id' => '2','name' => 'Rajshahi','bn_name' => 'রাজশাহী','url' => 'www.rajshahidiv.gov.bd'),
            array('id' => '3','name' => 'Khulna','bn_name' => 'খুলনা','url' => 'www.khulnadiv.gov.bd'),
            array('id' => '4','name' => 'Barisal','bn_name' => 'বরিশাল','url' => 'www.barisaldiv.gov.bd'),
            array('id' => '5','name' => 'Sylhet','bn_name' => 'সিলেট','url' => 'www.sylhetdiv.gov.bd'),
            array('id' => '6','name' => 'Dhaka','bn_name' => 'ঢাকা','url' => 'www.dhakadiv.gov.bd'),
            array('id' => '7','name' => 'Rangpur','bn_name' => 'রংপুর','url' => 'www.rangpurdiv.gov.bd'),
            array('id' => '8','name' => 'Mymensingh','bn_name' => 'ময়মনসিংহ','url' => 'www.mymensinghdiv.gov.bd')
          );

        if (!empty($divisions)) {
            return response()->json(["data" => $divisions, "status" => 200], 200);
        }else {
            return response()->json(["data" => "No Division found", "status" => 404], 404);
        }
    }



    /**
     * Retrieve districts based on the division ID.
     *
     * @param int $division The division ID.
     * @param int $limit (optional) The maximum number of districts to retrieve. Default is 0 (no limit).
     * @param string $orderBy (optional) The column to order the results by. Default is 'global_address_id'.
     * @param string $orderType (optional) The order type ('ASC' for ascending, 'DESC' for descending). Default is 'ASC'.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the retrieved districts and status code.
     */
    public function getDistrictsByDivisionID(Int $division, Int $limit=0, string $orderBy='global_address_id', string $orderType='ASC') : object {

        $division_list = global_address::select("*")
            ->where("division", $division)
            ->where("deleted", null);

        if ($limit !== 0){
            $division_list = $division_list->limit($limit);
        }

        if ($orderBy !== null) {
            $division_list = $division_list->orderBy($orderBy, $orderType);
        }

        $totalRows = $division_list->count();
        if ($totalRows > 0) {
            return response()->json(["data" => $division_list->get(), "status" => 200], 200);
        }else {
            return response()->json(["data" => "No District found", "status" => 404], 404);
        }
    }

    
}
