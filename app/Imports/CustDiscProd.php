<?php

namespace App\Imports;

use App\CustomerDiscProd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class CustDiscProd implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(int $id)
    {
        //$this->type = $type;
        $this->id = $id;
    }

    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.productcode' => 'required',
             '*.nettoprice' => 'required',
         ])->validate();
         

         foreach ($rows as $row) {
            $productCode = $row['productcode'];

            $cekProduct = \App\product::where('client_id','=',auth()->user()->client_id)
                        ->where('product_code',$productCode)->count();
            if($cekProduct > 0){
                $cp = \App\product::where('client_id','=',auth()->user()->client_id)
                        ->where('product_code',$productCode)->first();
                $cekDiscountProduct = CustomerDiscProd::where('product_id',$cp->id)
                                        ->where('cust_disc_id',$this->id)
                                        ->first();
                if($cekDiscountProduct){
                    $cekDiscountProduct->discount_price = $row['nettoprice'];
                    $cekDiscountProduct->save();
                }else{
                    $discountProduct = new CustomerDiscProd();
                    $discountProduct->cust_disc_id = $this->id;
                    $discountProduct->product_id = $cp->id;
                    $discountProduct->discount_price = $row['nettoprice'];
                    $discountProduct->save();
                }
            }
        }
    }
}
