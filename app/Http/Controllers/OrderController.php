<?php

namespace App\Http\Controllers;

use App\Models\GeneralSettings;
use App\Models\SuperGeneralSettings;
use Illuminate\Http\Request;
use App\Models\global_address;
use App\Models\Invoice;
use App\Models\Products;
use App\Models\Package;
use App\Models\Shops;
use APP\Libraries\BulkSMSBD;

class OrderController extends Controller
{
    public function create(Request $request){
        $userId = $request->post('userId');
        $shopId_cus = $request->post('shopId_cus');
        $customer_id = $request->post('customer_id');
        $proId = $request->post('productId');
        $qty = $request->post('qty[]');
        $proPrice = $request->post('price');
        $prodsubtotal = $request->post('subtotal');
        $prosubTo = $request->post('suballtotal');
        $fastDelivery = $request->post('fast_delivery');
        $amount = $request->post('grandtotal2');
        $finalAmount = $request->post('grandtotal');
        $dueAmount = $request->post('grandtotaldue');
        $division = $request->post('division');
        $district = $request->post('district');
        $sub_district= $request->post('sub_district');
        $union_pourashava = $request->post('union_pourashava');
        $ward = $request->post('ward');
        $address = $request->post('address');

        if (empty($proId)) {
            return response()->json(["data"=>"Your Cart Is Empty !!", "status"=>404], 404);
        }

        $global_address = global_address::select("*")->where(array('division' => $division,'zila' => $district,'upazila' => $sub_district,'pourashava' => $union_pourashava,'ward' => $ward));


        if ($global_address->count() == 1) {

            //create invoice in invoice table (start)
            $invoice = Invoice::create([
                'amount' => $amount,
                'final_amount' =>$finalAmount,
                'due' => $dueAmount,
                'status' => "2",
                'createdBy' => $userId,
                'customer_id' => $customer_id,
                'global_address_id' => $global_address->first()->global_address_id,
                'address' => $address,
                'createdDtm' => date('Y-m-d H:i:s'),
                'updatedDtm' => date('Y-m-d H:i:s')
            ]);
            //create invoice in invoice table (End)


            for($i = 0; $i < count($proId); $i++) {
                $shopID = Products::getShopIDByProductID($proId);

                $package = Package::isPackageExist($invoice['invoice_id'],$shopID);

                if ($package == false) {
                    $checkShopType = Shops::select('priority')->where('sch_id', $shopID)->first();

                    if ($checkShopType->priority == 1){
                        $deliveryCharge = GeneralSettings::select('value')->where("sch_id", $shopID)->where("label", 'regular_shop_delivery_charge')->first();
                        if (empty($deliveryCharge)) {
                            $deliveryCharge = SuperGeneralSettings::select('value')->where("label", 'regular_shop_delivery_charge')->first();
                        }
                    }else{
                        $deliveryCharge = GeneralSettings::select('value')->where("sch_id", $shopID)->where("label", 'express_shop_delivery_charge')->first();
                        if (empty($fastDelivery)){
                            if (empty($deliveryCharge)){
                                $deliveryCharge = SuperGeneralSettings::select('value')->where("label", 'express_shop_delivery_charge')->first();
                            }
                        }else {
                            $deliveryCharge = GeneralSettings::select('value')->where("sch_id", $shopID)->where("label", 'express_shop_fast_delivery_charge')->first();
                            if (empty($deliveryCharge)) {
                                $deliveryCharge = SuperGeneralSettings::select('value')->where("label", 'express_shop_fast_delivery_charge')->first();
                            }
                        }
                    }

                    $packdata = Package::create(array(
                        'invoice_id' => $invoice['invoice_id'],
                        'sch_id' => $shopID,
                        'price' => $prodsubtotal[$i],
                        'delivery_charge' => $deliveryCharge->value
                    ));

//                    $mobile = get_data_by_id('mobile','shops','sch_id',$schId);
                    $mobileInfo = Shops::select("mobile")->where("sch_id", $shopID)->first();
                    if (!empty($mobileInfo->mobile)) {
                        $adminMess = 'New order from AmarBangla Invoice id: ' . $packdata->package_id;
                        $BulkSMSbd = new BulkSMSBD();
                        $BulkSMSbd->send_sms($mobileInfo->mobile, $adminMess);
                    }


                }else {

                }
            }

        }

        if ($global_address->count() > 0) {
            return response()->json(["data"=>$mobileInfo->mobile, "status"=>200], 200);
        }else {
            return response()->json(["data"=>"No Result Found.", "status"=>404], 404);
        }

    }
}
