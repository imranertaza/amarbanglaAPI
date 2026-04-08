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
     * Customer registration
     *
     * This endpoint registers a new customer account. It validates the request data,
     * creates a new customer record, and issues an API token upon successful registration.
     *
     * @bodyParam mobile string required The customer's mobile number. Must be unique.
     * @bodyParam password string required The customer's password (stored as SHA1 hash).
     * @bodyParam customer_name string required The customer's full name.
     * @bodyParam father_name string optional The customer's father's name.
     * @bodyParam mother_name string optional The customer's mother's name.
     * @bodyParam age int optional The customer's age.
     * @bodyParam pass string optional Additional pass information.
     * @bodyParam pic string optional Profile picture filename or path.
     * @bodyParam nid string optional National ID number.
     * @bodyParam cus_type_id int optional Customer type ID.
     * @bodyParam balance float optional Initial balance for the customer.
     * @bodyParam mac_address string optional Device MAC address.
     * @bodyParam address string optional Customer's address.
     * @bodyParam global_address_id int optional Global address reference ID.
     * @bodyParam createdBy int optional ID of the user who created the record.
     * @bodyParam updatedBy int optional ID of the user who last updated the record.
     * @bodyParam deleted boolean optional Flag indicating if the record is deleted.
     * @bodyParam deletedRole string optional Role responsible for deletion.
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     *     "customer": "Rahim Uddin"
     *   },
     *   "message": "Successfully Created Customer"
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "data": {
     *     "mobile": ["The mobile has already been taken."],
     *     "password": ["The password field is required."],
     *     "customer_name": ["The customer name field is required."]
     *   },
     *   "message": "Validation failed"
     * }
     *
     * @param Request $request The request object containing customer registration details.
     *
     * @return JsonResponse A JSON response containing either the authentication token and customer details (200),
     *                      or validation errors if registration fails (404).
     */
    public function register(Request $request): object
    {
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
     * Customer login
     *
     * This endpoint authenticates a customer using their mobile number and password.
     * If the credentials are valid, it issues a new API token and returns customer details.
     *
     * @bodyParam mobile string required The customer's registered mobile number.
     * @bodyParam password string required The customer's password (SHA1 hashed for comparison).
     *
     * @response 200 {
     *   "success": true,
     *   "data": {
     *     "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     *     "customer_name": "Rahim Uddin"
     *   },
     *   "message": "Successfully logged In",
     *   "tokenableID": 15
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "data": "Unauthorized",
     *   "message": "You are unauthorized"
     * }
     *
     * @param Request $request The request object containing login credentials (`mobile`, `password`).
     *
     * @return JsonResponse A JSON response containing either the authentication token and customer details (200),
     *                      or an unauthorized error message (404).
     */

    public function login(Request $request): object
    { {
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
