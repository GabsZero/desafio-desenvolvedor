<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\PurchaseProduct;
use DB;

class PurchaseController extends Controller
{
    public function index(Request $request){
         //creating a custom query
         $purchasesQuery = Purchase::query();
         $input = $request->input();

        if(isset($input['purchase_id'])){
            $purchasesQuery->where('id', $input['purchase_id']);
        }
        if(isset($input['user_id'])){
            $purchasesQuery->where('user_id', $input['user_id']);
        }
        if(isset($input['customer_id'])){
            $purchasesQuery->where('customer_id', $input['customer_id']);
        }
        if(isset($input['status_id'])){
            $purchasesQuery->where('status_id', $input['status_id']);
        }
        if(isset($input['product_id'])){
            $purchasesQuery->whereHas('products', function($q) use($input){
                $q->where('product_id', $input['product_id']);
            });
        }

        $purchases = $purchasesQuery->get();

        return response()->json([
            'sucess' => true,
            'purchases' => $purchases
        ], 200);
    }

    public function show(Request $request){
        // checking for necessary parameters
        if(!$request->input('purchase_id')){
            return response()->json([
                'success' => false,
                'message' => 'Missing parameters'
            ], 400);
        } 
        // now, we can proceed to retrieve a product
        $purchase = Purchase::find($request->input('purchase_id'));

        return response()->json([
            'success' => true,
            'purchase' => $purchase
        ]);
    }

    public function store(PurchaseRequest $request){
        $input = $request->all();
        $input['total_amount'] = 0; //initializing the total amount for future update

        $purchase = Purchase::create($input);

        foreach($input['products'] as $product){
            $p = Product::find($product['product_id']);
            if(!$p) continue; // if we don't have a valid product, just move on

            $purchase->total_amount += $p->price * $product['quantity'];
            PurchaseProduct::create([
                'purchase_id' => $purchase->id,
                'product_id' => $p->id,
                'quantity' => $product['quantity']
            ]);
        }

        $purchase->save();

        return response()->json([
            'success' => true,
            'message' => "Product successfully stored"
        ], 200);
    }

    public function update(PurchaseRequest $request){
        $input = $request->all();
        $input['total_amount'] = 0; //initializing the total amount for future update

        // checking for mandatory parameter
        if(!$request->input('purchase_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Missing parameters'
            ]);
        }
        
        $purchase = Purchase::find($input['purchase_id']);

        // checking if id is valid
        if(!$purchase){
            return response()->json([
                'success' => false,
                'message' => 'Invalid Purchase'
            ]);
        }

        // deleting old products
        $purchase->products()->delete();

        // creating new instances of purchase_products
        foreach($input['products'] as $product){
            $p = Product::find($product['product_id']);
            if(!$p) continue; // if we don't have a valid product, just move on

            $purchase->total_amount += $p->price * $product['quantity'];
            PurchaseProduct::create([
                'purchase_id' => $purchase->id,
                'product_id' => $p->id,
                'quantity' => $product['quantity']
            ]);
        }

        $purchase->save();

        return response()->json([
            'success' => true,
            'message' => "Product successfully updated"
        ], 200);
    }

    public function destroy(Request $request){
        // checking if we have the mandatory parameter
        if(!$request->input('purchase_id')){
            return response()->json([
                'success' => false,
                'message' => 'Missing parameters'
            ]);
        }
        //checking if we have a purchase
        $purchase = Purchase::find($request->input('purchase_id'));
        if(!$purchase){
            return response()->json([
                'success' => false,
                'message' => 'Invalid purchase'
            ], 400);            
        }

        //if we do, delete the relationships
        $purchase->products()->delete();
        // and then, delete de purchase
        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase successfully deleted'
        ], 200);
    }
}
