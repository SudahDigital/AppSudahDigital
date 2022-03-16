<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class CustomerNotOrderExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $year, int $month)
    {
        //$this->type = $type;
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        $month = $this->month;
        $year = $this->year;
        $notOrder = \App\Customer::whereNotExists(function($q) use($month,$year)
                {
                    $q->select(\DB::raw(1))
                            ->from('orders')
                            ->whereRaw('orders.customer_id = customers.id')
                            ->whereMonth('created_at', '=', $month)
                            ->whereYear('created_at', '=', $year)
                            ->where('status','!=','CANCEL')
                            ->where('status','!=','NO-ORDER');
                            
                })
                ->where('client_id',\Auth::user()->client_id)
                ->get();
        return collect($notOrder);
    }

    public function map($notOrder) : array {
        if($notOrder->user_id != null){
            $sales = \App\User::findOrfail($notOrder->user_id);
            $salesName = $sales->name;
        }else{
            $salesName = '';
        }
        return[
            $notOrder->store_code.' - '.$notOrder->store_name,
            $salesName,
        ];
    }

    public function headings() : array {
        return [
           'Customer',
           'Sales Representative',
        ] ;
    }
}
