<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuthController extends Controller
{
    /**
     * @param Request $request
     * 
     * @return object
     */
    public function register(Request $request) : object{
        // Manually validate the request
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:customers',
            'password' => 'required',
            'customer_name' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return custom response with validation errors
            $response = [
                'success' => false,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ];
            return response()->json($response, 404);
        }

        $customer = Customer::create([
            'mobile' => $request->mobile,
            'password' => sha1($request->password),
            'customer_name' => $request->customer_name,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'age' => $request->age,
            'pass' => $request->pass,
            'pic' => $request->pic,
            'nid' => $request->nid,
            'cus_type_id' => $request->cus_type_id,
            'balance' => $request->balance,
            'mac_address' => $request->mac_address,
            'address' => $request->address,
            'global_address_id' => $request->global_address_id,
            'createdBy' => $request->createdBy,
            'updatedBy' => $request->updatedBy,
            'deleted' => $request->deleted,
            'deletedRole' => $request->deletedRole
        ]);

        // $customer = Customer::create($input);
        $success['token'] = $customer->createToken('amarBanglaCustomer')->plainTextToken;
        $success['customer'] = $customer->customer_name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'Successfully Created Customer'
        ];

        return response()->json($response, 200);
    }


    /**
     * @param Request $request
     * 
     * @return object
     */
    public function login(Request $request) : object{
        {
            $request->validate([
                'mobile' => 'required',
                'password' => 'required',
            ]);

            $customer = Customer::where('mobile', $request->mobile)->first();

            if (!$customer || (sha1($request->password) !== $customer->password)) {
                $response = [
                    'success' => false,
                    'data' => 'Unauthorized',
                    'message' => 'You are unauthorized'
                ];
    
                return response()->json($response, 404);
            }

            $success['token'] = $customer->createToken('amarBanglaCustomer')->plainTextToken;
            $success['customer_name'] = $customer->customer_name;

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Successfully logged In',
                'tokenableID' => $customer->getKey(),
            ];

            return response()->json($response, 200);
        }
    }
}
