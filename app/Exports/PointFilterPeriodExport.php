<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PointFilterPeriodExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $period_id)
    {
        $this->period_id = $period_id;
    }
    
    public function collection()
    {
        $periodId = $this->period_id;
        $client_id = \Auth::user()->client_id;
        $pn = \App\Customer::whereHas('custPoints', function($q) use ($periodId){
                        $q->where('period_id',$periodId);
                    })
            ->where('client_id',$client_id)
            ->get();

        return collect($pn); 
    }

    public function map($pn) : array {
       
        $period = \App\PointPeriod::where('id',$this->period_id)->first();
        [$point,$potencyPoint] = \App\Http\Controllers\CustomerPointOrderController::getPoints($period->starts_at,$pn->id);
        $claim = \App\Http\Controllers\CustomerPointOrderController::pointsClaim($period->starts_at,$pn->id);
        [$rest,$totalPotency] = \App\Http\Controllers\CustomerPointOrderController::starting_point($period->starts_at,$pn->id);
        $pointPartial = \App\Http\Controllers\CustomerPointOrderController::pointPartial($period->starts_at,$pn->id);
		$pointPrevPartial = \App\Http\Controllers\CustomerPointOrderController::pointPrevPartial($period->starts_at,$pn->id);
        $afterPointPartial = \App\Http\Controllers\CustomerPointOrderController::startPointPartial($period->starts_at,$pn->id);
        
        $start_point = number_format($rest,2);
        $pointInPeriod = number_format(($point-$pointPrevPartial) + $afterPointPartial + $pointPartial + $claim,2);
        $potencyPoints = number_format(($potencyPoint)+($totalPotency),2);
        $pointClaim = number_format($claim,2);
        $pointTotal = number_format(($point-$pointPrevPartial) + $afterPointPartial + $pointPartial + $rest ,2);
        if($pn->user_id){
            $salesName = $pn->users->name;
        }
        else{
            $salesName = '';
        }
        return[
            $pn->store_key,
            $pn->store_code,
            $pn->store_name,
            $pn->group_id,
            $salesName,
            $start_point,
            $pointInPeriod,
            $potencyPoints,
            $pointClaim,
            $pointTotal,
        ];
    }

    public function headings() : array {
        return [
           'Cust. Key',
           'Cust. Code',
           'Cust. Name',
           'Cust. Group Id',
           'Sales',
           'Starting Points',
           'Points In Periods',
           '(+) Potential Points',
           'Points Claim',
           'Total Points',
        ] ;
    }
}
