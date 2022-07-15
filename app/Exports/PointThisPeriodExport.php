<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PointThisPeriodExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        $periodId = $period->id;
        $pn =   \App\Customer::whereHas('custPoints', function($q) use ($periodId){
                    $q->where('period_id',$periodId);
                })
                ->where('client_id',$client_id)
                ->get();

        return collect($pn);
    }

    public function map($pn) : array {
       
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;
        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();

            [$pointPeriod,$point,$potencyPoint] = \App\Http\Controllers\CustomerPointOrderController::getPoints($period->starts_at,$pn->id);
            $claim = \App\Http\Controllers\CustomerPointOrderController::pointsClaim($period->starts_at,$pn->id);
            [$rest,$totalPotency] = \App\Http\Controllers\CustomerPointOrderController::starting_point($period->starts_at,$pn->id);
            $pointPartial = \App\Http\Controllers\CustomerPointOrderController::pointPartial($period->starts_at,$pn->id);
			$pointPrevPartial = \App\Http\Controllers\CustomerPointOrderController::pointPrevPartial($period->starts_at,$pn->id);
            $afterPointPartial = \App\Http\Controllers\CustomerPointOrderController::startPointPartial($period->starts_at,$pn->id);

            $start_point = number_format($rest,2);
            if($pointPeriod){
                $pointInPeriod = number_format(($point-$pointPrevPartial) + $afterPointPartial + $pointPartial + $claim,2);
                $pointTotal = number_format(($point-$pointPrevPartial) + $afterPointPartial + $pointPartial + $rest ,2);
            }else{
                $pointInPeriod = number_format(0,2);
                $pointTotal = number_format(((($point-$pointPrevPartial) + $afterPointPartial + $pointPartial + $rest ) - $claim) ,2);
            }
            $potencyPoints = number_format(($potencyPoint)+($totalPotency),2);
            $pointClaim = number_format($claim,2);
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
                $pn->group_code,
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
            'Group Code',
            'Sales',
            'Starting Points',
            'Points In Periods',
            '(+) Potential Points',
            'Points Claim',
            'Total Points',
        ] ;
    }
}
