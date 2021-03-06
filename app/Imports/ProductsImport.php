<?php

namespace App\Imports;

use App\product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        $stock_status= \DB::table('product_stock_status')
        ->where('client_id','=',auth()->user()->client_id)
        ->first();
        if($stock_status->stock_status == 'ON'){
            return [
                'product_code' => 'required',
                'stock' => 'max:999999999|numeric',
            ];
        }else{
            return [
                'product_code' => 'required',
                //'stock' => 'max:999999999|numeric',
                
            ];
        }
    }

    public function customValidationMessages()
    {
        $stock_status= \DB::table('product_stock_status')
        ->where('client_id','=',auth()->user()->client_id)
        ->first();
        if($stock_status->stock_status == 'ON'){
            return [
                'product_code.required' => 'Product_code is required.',
                'stock' => 'stock is max 9 digits.',
            ];
        }else{
            return [
                'product_code.required' => 'Product_code is required.',
                //'stock' => 'stock is max 9 digits.',
            ];
        }
    }

    public function model(array $rows)
    {
            //dd($rows);
            $code = $rows['product_code'];
            $cek = product::withTrashed()
                  ->where('client_id','=',auth()->user()->client_id)
                  ->where('product_code',$code)->count();
            //$cek = \DB::select("SELECT COUNT (product_code) FROM products WHERE product_code = (select
            //product_code from products where )");
            //dd($cek);
            $stock_status= \DB::table('product_stock_status')
            ->where('client_id','=',auth()->user()->client_id)
            ->first();
            //dd($cek);
            
            if($cek > 0){
                //$code = $rows['product_code'];
                $product = product::withTrashed()
                         ->where('client_id','=',auth()->user()->client_id)
                         ->where('product_code','=',"$code")->first();
                //$product = \DB::select("SELECT * FROM products WHERE product_code = '$code' LIMIT 1");
                $product->client_id = $stock_status->client_id;
                $product->product_code = $rows['product_code'];
                $product->Product_name = $rows['product_name'];
                $product->slug = \Str::slug($rows['product_name']);
                $product->description = $rows['description'];
                $product->price = $rows['price'];
                $product->price_promo = $rows['price'];
                $product->discount = 0.00;
                $product->updated_by = \Auth::user()->id;
                if($stock_status->stock_status == 'ON'){
                    $stock = $rows['stock'];
                    $low_stock = $rows['low_stock_treshold'];
                    if( $stock !== null){
                        $stock = (int)$stock;
                        $product->stock = $stock;
                    }
                    if($low_stock !== null){
                        $low_stock = (int)$low_stock;
                        $product->low_stock_treshold = $low_stock;
                    }
                }
                //$product->low_stock_treshold = $rows['low_stock_treshold']== NULL ? null : $rows['low_stock_treshold'];
                $product->status = $rows['status'];
                $product->save();
                $product->categories()->sync($rows['category_id']);
                
                if($product->save()){
                    $period = date('Y-m-01');
                    //$year = date('Y');
                    $store_target = \App\Store_Targets::where('client_id',\Auth::user()->client_id)
                                    ->where('period','>=',$period)
                                    ->get();
                    //dd($store_target);
                    if($store_target){
                        foreach($store_target as $st){
                            $productsTarget = \App\ProductTarget::where('storeTargetId',$st->id)
                                            ->where('productId',$product->id)->first();
                            if($productsTarget){
                                $nml_values = $rows['price'];
                                $productsTarget->nominalValues = $nml_values * $productsTarget->quantityValues;
                                $productsTarget->save();
                            }
                        } 
                    }
                    
                }
            }else{
                $product = new product;
                $product->client_id = $stock_status->client_id;
                $product->product_code = $rows['product_code'];
                $product->Product_name = $rows['product_name'];
                $product->slug = \Str::slug($rows['product_name']);
                $product->description = $rows['description'];
                $product->price = $rows['price'];
                $product->price_promo = $rows['price'];
                $product->discount = 0.00;
                $product->created_by = \Auth::user()->id;
                if($stock_status->stock_status == 'ON'){
                    $stock = $rows['stock'];
                    $low_stock = $rows['low_stock_treshold'];
                    if( $stock !== null){
                        $stock = (int)$stock;
                        $product->stock = $stock;
                    }
                    if($low_stock !== null){
                        $low_stock = (int)$low_stock;
                        $product->low_stock_treshold = $low_stock;
                    }
                }
                //$product->low_stock_treshold = $rows['low_stock_treshold']== NULL ? null : $rows['low_stock_treshold'];
                $product->status = $rows['status'];
                $product->save();
                $product->categories()->attach($rows['category_id']);
            }
            
        
    }

}