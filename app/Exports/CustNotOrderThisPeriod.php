<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustNotOrderThisPeriod implements FromCollection, WithMapping, WithHeadings
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
        $user = \App\User::findOrfail(\Auth::user()->id);
        
        $day = date('d');
        if($day <= 5){
            if($this->month == 1){
                $prevYear = $this->year-1;
                $prevMonth = 12;
                $dateS = $prevYear.'-'.$prevMonth.'-01';
                $dateE = $this->year.'-'.$this->month.'-'.$day;
                if($user->roles == 'SUPERVISOR'){
                    $idSpv = $user->id;
                    $notOrder = \App\Customer::whereHas('spv_sales',function($q)use($idSpv){
                            $q->where('spv_id',$idSpv);
                        })
                        ->whereNotExists(function($q) use($dateS,$dateE)
                        {
                            $q->select(\DB::raw(1))
                                    ->from('orders')
                                    ->whereRaw('orders.customer_id = customers.id')
                                    ->whereBetween('created_at',[$dateS,$dateE])
                                    ->where('status','!=','CANCEL')
                                    ->where('status','!=','NO-ORDER');
                                    
                        })
                        ->where('client_id',\Auth::user()->client_id)
                        ->get();
                }else{
                    $notOrder = \App\Customer::whereNotExists(function($q) use($dateS,$dateE)
                        {
                            $q->select(\DB::raw(1))
                                    ->from('orders')
                                    ->whereRaw('orders.customer_id = customers.id')
                                    ->whereBetween('created_at',[$dateS,$dateE])
                                    ->where('status','!=','CANCEL')
                                    ->where('status','!=','NO-ORDER');
                                    
                        })
                        ->where('client_id',\Auth::user()->client_id)
                        ->get();
                }
                
            }else{

                $prevMonth = $this->month-1;
                $dateS = $this->year.'-'.$prevMonth.'-01';
                $dateE = $this->year.'-'.$this->month.'-'.$day;
                
                if($user->roles == 'SUPERVISOR'){
                    $idSpv = $user->id;
                    $notOrder = \App\Customer::whereHas('spv_sales',function($q)use($idSpv){
                            $q->where('spv_id',$idSpv);
                        })
                        ->whereNotExists(function($q) use($dateS,$dateE)
                        {
                            $q->select(\DB::raw(1))
                                    ->from('orders')
                                    ->whereRaw('orders.customer_id = customers.id')
                                    ->whereBetween('created_at',[$dateS,$dateE])
                                    ->where('status','!=','CANCEL')
                                    ->where('status','!=','NO-ORDER');
                                    
                        })
                        ->where('client_id',\Auth::user()->client_id)
                        ->get();
                }else{
                    $notOrder = \App\Customer::whereNotExists(function($q) use($dateS,$dateE)
                        {
                            $q->select(\DB::raw(1))
                                    ->from('orders')
                                    ->whereRaw('orders.customer_id = customers.id')
                                    ->whereBetween('created_at',[$dateS,$dateE])
                                    ->where('status','!=','CANCEL')
                                    ->where('status','!=','NO-ORDER');
                                    
                        })
                        ->where('client_id',\Auth::user()->client_id)
                        ->get();
                }    
            }
        }else{
            
            $year = $this->year;
            $month = $this->month;
            if($user->roles == 'SUPERVISOR'){
                $idSpv = $user->id;
                
                $notOrder = \App\Customer::whereHas('spv_sales',function($q)use($idSpv){
                        $q->where('spv_id',$idSpv);
                        })
                    ->whereNotExists(function($q) use($year,$month)
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
            }else{
                $notOrder = \App\Customer::whereNotExists(function($q) use($year,$month)
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
            }    
        }

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
            $notOrder->store_key,
            $notOrder->store_code,
            $notOrder->store_name,
            $notOrder->address,
            $salesName,
        ];
    }

    public function headings() : array {
        return [
            'Customer Code',
            'Customer Name',
            'Address',
            'Max Nominal Target',
            ''
            'Sales Representative',
        ] ;
    }
    
}
