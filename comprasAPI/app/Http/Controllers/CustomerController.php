<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use Validator;

class CustomerController extends Controller
{
    public function index(Request $request){
        //creating a custom query
        $customersQuery = Customer::query();
        $input = $request->input();
        if(isset($input['name'])){
            // transforming the string in something more "likeable"
            $name = str_replace(" ", "%", $input['name']);
            $customersQuery->where('name', 'like', "%{$name}%");
        }
        if(isset($input['identification_code'])){
            $customersQuery->where('identification_code', 'like', "%{$input['identification_code']}%");
        }
        if(isset($input['customer_type_id'])){
            $customersQuery->where('customer_type_id', $input['customer_type_id']);
        }

        $customers = $customersQuery->get();

        return response()->json([
            'sucess' => true,
            'customers' => $customers
        ], 200);
    }

    public function store(CustomerRequest $request){
        $input = $request->all();

        // retrieving an existing customer in database or creating a new one, based on identification code
        //this does not exclude an update action, tho
        $customer = Customer::firstOrNew([
            'identification_code' => $input['identification_code']
        ]);

        $customer = $customer->fill($input);
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => "Customer successfully stored"
        ], 200);
    }

    public function update(CustomerRequest $request){
        // checking if we have a customer
        $customer = Customer::find($request->input('customer_id'));
        if(!$customer){
            return response()->json([
                'success' => false,
                'message' => 'Invalid customer'
            ], 400);            
        }

        // if we do, update
        $input = $request->all();
        $customer = $customer->fill($input);
        $customer->update();

        return response()->json([
            'success' => true,
            'message' => 'Customer successfully updated'
        ], 200);
    }

    public function destroy(Request $request){
        //checking, again, if we have a customer
        $customer = Customer::find($request->input('customer_id'));
        if(!$customer){
            return response()->json([
                'success' => false,
                'message' => 'Invalid customer'
            ], 400);            
        }

        //if we do, delete
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer successfully deleted'
        ], 200);
    }

}
