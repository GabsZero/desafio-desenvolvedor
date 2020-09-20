<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{

    public function index(Request $request){
        //creating a custom query
        $productsQuery = Product::query();
        $input = $request->input();
        if(isset($input['name'])){
            // transforming the string in something more "likeable"
            $name = str_replace(" ", "%", $input['name']);
            $productsQuery->where('name', 'like', "%{$name}%");
        }
        if(isset($input['description'])){
            $description = str_replace(" ", "%", $input['description']);
            $productsQuery->where('description', 'like', "%{$description}%");
        }
        if(isset($input['price']) && isset($input['operator'])){
            $productsQuery->where('price', $input['operator'], $input['price']);
        }

        $products = $productsQuery->get();

        return response()->json([
            'sucess' => true,
            'products' => $products
        ], 200);
    }

    public function show(Request $request){
        // checking for necessary parameters
        if(!$request->input('product_id')){
            return response()->json([
                'success' => false,
                'message' => 'Missing parameters'
            ], 400);
        } 
        // now, we can proceed to retrieve a product
        $product = Product::find($request->input('product_id'));

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function store(ProductRequest $request){
        $input = $request->all();

        $product = Product::create($input);

        return response()->json([
            'success' => true,
            'message' => "Product successfully stored"
        ], 200);
    }

    public function update(ProductRequest $request){
         // checking if we have a product
         $product = Product::find($request->input('product_id'));
         if(!$product){
             return response()->json([
                 'success' => false,
                 'message' => 'Invalid product'
             ], 400);            
         }
 
         // if we do, update
         $input = $request->all();
         $product = $product->fill($input);
         $product->update();
 
         return response()->json([
             'success' => true,
             'message' => 'Product successfully updated'
         ], 200);
    }

    public function destroy(Request $request){
        //checking, again, if we have a product
        $product = Product::find($request->input('product_id'));
        if(!$product){
            return response()->json([
                'success' => false,
                'message' => 'Invalid product'
            ], 400);            
        }

        //if we do, delete
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product successfully deleted'
        ], 200);
    }
}
