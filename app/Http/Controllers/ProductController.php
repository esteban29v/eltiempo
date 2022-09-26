<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index() {

        $products = Product::all();

        return response()->json([
            'res' => true,
            'products' => $products
        ]);
    }

    public function show($id) {

        $product = Product::findOrFail($id);

        return response()->json([
           'res' => true,
           'product' => $product
        ]);
    }

    public function store(ProductRequest $request) {

        try{

            $input = $request->only([
                    'name', 
                    'description',
                    'price',
                    'in_stock',
                    'active_for_sale'
                ]);

            Product::create($input);

            return response()->json([
               'res' => true,
               'msg' => 'Product created successfully'
            ]);

        }catch(\Exception $e) {

            return $e->getMessage();

            return response()->json([
              'res' => false,
              'msg' => 'An error occurred while creating the product',
              'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(ProductRequest $request, Product $product) {

        try {

            $input = $request->only([
                'name', 
                'description',
                'price',
                'in_stock',
                'active_for_sale'
            ]);

            $product->name = $input['name'] ?? $product->name;
            $product->description = $input['description'] ?? $product->description;
            $product->price = $input['price'] ?? $product->price;
            $product->in_stock = $input['in_stock'] ?? $product->in_stock;
            $product->active_for_sale = $input['in_stock'] ?? $product->active_for_sale;

            $product->save();

            return response()->json([
                'res' => true,
                'msg' => 'Product updated successfully',
                'product' => $product
            ]);

        }catch(\Exception $e){

            return response()->json([
                'res' => false,
                'msg' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function destroy(Product $product) {

        try{

            $product->delete();

            return response()->json([
                'res' => true,
                'msg' => 'Product deleted successfully'
            ]);

        }catch(\Exception $e){

            return response()->json([
                'res' => false,
                'msg' => 'An error occurred while updating the product',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
