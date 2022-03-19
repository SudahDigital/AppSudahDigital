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
        $user = \App\User::findOrfail(\Auth::user()->id);

        $month = $this->month;
        $year = $this->year;
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
        }   
        
        return collect($notOrder);
    }

    public function map($notOrder) : array {
        //user check
        if($notOrder->user_id){
            $salesName = $notOrder->users->name;
        }else{
            $salesName = '';
        }

        //pareto check
        if($notOrder->pareto_id){
            $pareto = $notOrder->pareto->pareto_code;
        }else{
            $pareto = '';
        }

        //store target
        $target = \App\Store_Targets::where('customer_id',$notOrder->id)
                    ->whereMonth('period', '=', $this->month)
                    ->whereYear('period', '=', $this->year)
                    ->first();
        if($target){
            $trgNml = number_format($target->TotalNominal/1.1);
            $trgQty = number_format($target->TotalQty);
        }else{
            $trgNml = '';
            $trgQty = '';
        }

        //haven't ordered (Days)
        $thisMonth = date('m');
        $thisYear = date('Y');
        $thisYM = $thisYear.'-'.$thisMonth;
        $selectYM = $this->year.'-'.$this->month;
        if($thisYM == $selectYM){
            $date_now = date('Y-m-d');
        }else{
            $jumHari = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
            $date_now =  $this->year.'-'.$this->month.'-'.$jumHari;
        }
        $last_odr = \App\Http\Controllers\DashboardController::lastOrder($notOrder->id,$date_now);

        return[
            $notOrder->store_code,
            $notOrder->store_name,
            $notOrder->address,
            $pareto,
            $trgNml,
            $trgQty,
            $last_odr,
            $salesName,
        ];
    }

    public function headings() : array {
        return [
            'Customer Code',
            'Customer Name',
            'Address',
            'Pareto',
            'Max Nml Target (Non PPN)',
            'Qty Target',
            'Haven\'t Ordered (Days)',
            'Sales Representative',
        ] ;
    }
}
