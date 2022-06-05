<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CustomerExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::where('status','=','ACTIVE')
        ->where('client_id','=',auth()->user()->client_id)
        ->orderBy('created_at','DESC')
        ->get();
        
    }

    public function map($customer) : array {
        if($customer->lat == NULL || $customer->lng == NULL ){
            $latalang = '';
        }else{
            $latalang = $customer->lat.', '.$customer->lng;
        }
        return[
                $customer->store_key,
                $customer->store_code,
                $customer->store_name,
                $customer->group_code,
                $customer->email,
                $customer->city_id,
                $customer->address,
                $latalang,
                $customer->cust_type,
                $customer->pricelist_id,
                $customer->phone,
                $customer->phone_owner,
                $customer->phone_store,
                $customer->name,
                $customer->payment_term,
                $customer->pareto_id,
                $customer->user_id,
            ];
    }

    public function headings() : array {

        return [
           'Cust_Key',
           'Cust_Code',
           'Name',
           'Group_Code',
           'Email',
           'City_ID',
           'Address',
           'Coordinate',
           'Customer_Type',
           'Customer_Price_ID',
           'Whatsapp',
           'Owner_Phone',
           'Office_Phone',
           'Contact',
           'Term_Of_Payment',
           'Pareto_ID',
           'Sales_Rep'
        ] ;
    }

    public function columnFormats(): array
    {
        return [
            'F' =>'0',
            'G' =>'0',
            'I' =>'0',
        ];
        
    }
}
