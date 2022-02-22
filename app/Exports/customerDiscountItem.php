<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class customerDiscountItem implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $cItem = \App\CustomerDiscProd::where('cust_disc_id', $this->id)
                ->get();
        return collect($cItem);
       
    }

    public function map($cItem) : array {
       
        $item = \App\product::findOrfail($cItem->product_id);
        
        return[
            $item->product_code,
            $cItem->discount_price,
        ];
    }

    public function headings() : array {
        return [
           'ProductCode',
           'NettoPrice',
        ] ;
    }
}
