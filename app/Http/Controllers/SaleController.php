<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleItemRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index() {

        $sales = Sale::all();

        return response()->json([
            'res' => true,
            'sales' => $sales
        ]);
    }

    public function show($id) {

        $sale = Sale::findOrFail($id);

        return response()->json([
           'res' => true,
           'sale' => $sale
        ]);
    }

    public function store(SaleItemRequest $request) {

        try{

            DB::beginTransaction();

            $input = $request->only([
                    'sale_id',
                    'product_id',
                    'price_per_unit',
                    'product_amount',
                ]);

            $product = Product::where('id', $input['product_id'])->first();

            if(!array_key_exists('sale_id', $input)) {

                $pendingStatus = SaleStatus::where('status_name', 'pending')->first();

                $sale = Sale::create([
                    'user_id' => auth()->user()->id,
                    'sale_amount' => 0,
                    'sale_status_id' => $pendingStatus->id
                ]);

            }else{

                $sale = Sale::where('id', $input['sale_id'])->first();
            }

            if(!array_key_exists('price_per_unit', $input)) {
                $input['price_per_unit'] = $product->price;
            }

            $saleItem = new SaleItem;

            $saleItem->sale_id = $sale->id;
            $saleItem->product_id = $input['product_id'];
            $saleItem->price_per_unit = $input['price_per_unit'];
            $saleItem->product_amount = $input['product_amount'];

            $saleItem->subtotal = $saleItem->price_per_unit * $saleItem->product_amount;

            $saleItem->save();

            $sale->updateSaleAmount();

            DB::commit();

            return response()->json([
               'res' => true,
               'msg' => 'Item added to sale successfully'
            ]);

        }catch(\Exception $e) {

            DB::rollback();

            return [$e->getMessage(), $e->getLine()];

            return response()->json([
              'res' => false,
              'msg' => 'An error occurred while adding item to sale',
              'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(SaleItem $saleItem) {

        try{

            $saleItem->delete();

            $saleItem->sale->updateSaleAmount();

            return response()->json([
                'res' => true,
                'msg' => 'Sale item deleted successfully'
            ]);

        }catch(\Exception $e){

            return response()->json([
                'res' => false,
                'msg' => 'An error occurred while deleting the sale item',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }
}
