<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PointThisPeriodExport;
use App\Exports\PointFilterPeriodExport;

class CustomerPointOrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            $param = \Route::current()->parameter('vendor');
            $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
            if($client->client_slug == $param){
                if(session()->get('client_sess')== null){
                    \Request::session()->put('client_sess',
                    ['client_name' => $client->client_name,'client_image' => $client->client_image]);
                }
                if(Gate::allows('point-order-customers')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }

    public function index($vendor){
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        if($period){
            $periodId = $period->id;
            $customers = \App\Customer::whereHas('custPoints', function($q) use ($periodId){
                            $q->where('period_id',$periodId);
                        })
                        ->where('client_id',$client_id)
                        ->get();
            //dd($customers);
            return view ('customer_point_order.index',
                        ['customers'=>$customers,
                        'vendor'=>$vendor,
                        'period_list'=>$period_list,
                        'period_start'=>$period->starts_at,
                        'period_name'=>$period->name,
                        'period'=>$period]);
        }else{
            return view ('customer_point_order.index',
                ['vendor'=>$vendor,
                 'period'=>$period,
                 'period_list'=>$period_list]);
        }
        
    }

    public static function getPoints($period_start,$csid)
    {   
        
        //dd($period_start);
        $client_id = \Auth::user()->client_id;

        $period = \App\PointPeriod::where('client_id',$client_id)
                ->where('starts_at', $period_start)
                ->first();
        $dateSt =date('Y-m-15', strtotime($period->starts_at));
        
        $points =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total,
                                        points.potencyPoint as potency
            FROM
            (SELECT o.id as oid, pr.created_at, o.customer_id csid,
                    
                        /*cp.id,*/ 
                        sum(case when(
                                        (   date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                            AND  
                                            date(o.finish_time) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                        )
                                        OR
                                        (
                                        date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                        )
                                    )
                                then 
                                (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end
                            ) totalpoint,
                        
                        sum(case when date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                AND (o.status = 'SUBMIT' OR o.status = 'PROCESS' OR o.status = 'PARTIAL-SHIPMENT')
                            then
                                (pr.prod_point_val/pr.quantity_rule) * (op.quantity - IFNULL(op.deliveryQty,0)) else 0 end
                            ) potencyPoint
                        
                        FROM orders as o 
                        JOIN order_product as op ON op.order_id = o.id  
                        JOIN products on products.id = op.product_id 
                        JOIN product_rewards as pr on pr.product_id = products.id
                        WHERE
                        o.customer_id = '$csid' AND
                        pr.created_at = (SELECT MAX(created_at) FROM 
                                        product_rewards GROUP BY product_id HAVING 
                                        product_id = pr.product_id) 
                        AND  
                        (
                        date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                            OR
                         date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                        )
                         AND
                        o.status != 'CANCEL' AND o.status != 'NO-ORDER'
                        
            ) as points
            LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                            when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                        else 0 end) Pointreward 
                    from point_claims as pc 
                    JOIN point_rewards as prpc on pc.reward_id = prpc.id
                    JOIN point_periods as pprd on prpc.period_id = pprd.id
                    WHERE prpc.period_id = '$period->id'
                    Group by pc.custpoint_id) pointsRewards
            on points.csid = pointsRewards.custpoint_id;");
        //dd($points);
        $point = $points[0]->grand_total;
        $potencyPoint = $points[0]->potency;
        return [$point,$potencyPoint];
            
    }

    public function filter_period($vendor, $period_name, $period_id)
    {   
        $periodId = (\Crypt::decrypt($period_id));
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::findOrFail($periodId);
        
        //dd($period);
        $customers = \App\Customer::whereHas('custPoints', function($q) use ($periodId){
                        $q->where('period_id',$periodId);
                    })
        ->where('client_id',$client_id)
        ->get();
        //dd($customers);
        
        
        
        return view ('customer_point_order.index',['customers'=>$customers,
                                            'vendor'=>$vendor,
                                            'period_list'=>$period_list,
                                            'period'=>$period->id,
                                            'period_start'=>$period->starts_at,
                                            'period_name'=>$period->name]);
    }

    public static function starting_point($period, $customer){
        $date =date('Y-m-d', strtotime($period));
        $yPeriodPrev = date('Y',strtotime($period));
        $PrevPeriodCheck = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                            ->whereDate('expires_at', '<', $date)
                            ->whereYear('expires_at',$yPeriodPrev)
                            ->orderBy('expires_at','DESC')
                            ->first();
        if($PrevPeriodCheck){
            //$Year =date('Y', strtotime($PrevPeriodCheck->starts_at));
            $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$yPeriodPrev)
                    ->orderBy('expires_at','DESC')
                    ->get();
            if($prd_cek){
                $total_start_point = 0;
                $totalPotency = 0;
                foreach($prd_cek as $key => $period_cek){
                    $dateSt = date('Y-m-15', strtotime($period_cek->starts_at));
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                    WHERE period_id = $period_cek->id AND
                                    customer_points.customer_id = '$customer'");
                    if(!$cust_exists){
                        break;
                    }
                    $customers_cek =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                                FROM
                                (SELECT o.id as oid, o.customer_id csid,  pr.created_at,
                                            sum(case when(
                                                            (
                                                                date(o.created_at) between '$period_cek->starts_at' and '$period_cek->expires_at'
                                                                AND  
                                                                date(o.finish_time) between '$period_cek->starts_at' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                                            )
                                                            OR
                                                            (date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY))
                                                        )
                                                    then 
                                                    (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end
                                                ) totalpoint,
                                                sum(case when date(o.created_at) between '$period_cek->starts_at' and '$period_cek->expires_at'
                                                        AND (o.status = 'SUBMIT' OR o.status = 'PROCESS' OR o.status = 'PARTIAL-SHIPMENT')
                                                    then
                                                        (pr.prod_point_val/pr.quantity_rule) * (op.quantity - IFNULL(op.deliveryQty,0)) else 0 end
                                                    ) potentcyPoint
                                            
                                            FROM orders as o 
                                            JOIN order_product as op ON o.id = op.order_id 
                                            JOIN products on products.id = op.product_id 
                                            JOIN product_rewards as pr on pr.product_id = products.id
                                            WHERE
                                            
                                            
                                            pr.created_at = (SELECT MAX(created_at) FROM 
                                                            product_rewards GROUP BY product_id HAVING 
                                                            product_id = pr.product_id) 
                                            AND
                                                              
                                            (
                                                date(o.created_at) between '$period_cek->starts_at' and '$period_cek->expires_at' 
                                                OR
                                                date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                            )
                                            AND 
                                            o.status != 'CANCEL' AND o.status != 'NO-ORDER' AND
                                            o.customer_id = '$customer'
                                ) as points
                                LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                                                when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                                            else 0 end) Pointreward 
                                        from point_claims as pc 
                                        JOIN point_rewards as prpc on pc.reward_id = prpc.id
                                        JOIN point_periods as pprd on prpc.period_id = pprd.id
                                        WHERE prpc.period_id = '$period_cek->id'
                                        AND pc.custpoint_id = '$customer') pointsRewards
                                on points.csid = pointsRewards.custpoint_id;");
                            $_this = new self;
                            $partPoint[$key] = $_this->pointPartial($period_cek->starts_at,$customer);
                            $startPartPoint[$key] = $_this->startPointPartial($period_cek->starts_at,$customer);
                            $partPrevPoint[$key] = $_this->pointPrevPartial($period_cek->starts_at,$customer);
                            $restpoints[$key] = ($customers_cek[0]->grand_total - $partPrevPoint[$key]) + $startPartPoint[$key] + $partPoint[$key];
                                
                            if($restpoints[$key] == null){
                                $pointstart[$key] = 0;
                                $potencyPoint[$key] = 0;
                            }else{
                                $pointstart[$key] = $restpoints[$key];
                                $potencyPoint[$key] = $customers_cek[0]->potentcyPoint;
                            }
                            
                            $total_start_point += $pointstart[$key]; 
                            $totalPotency += $potencyPoint[$key];
                }
            }else{
                $total_start_point = 0;
                $totalPotency = 0;
            }

        }
        else{
            $total_start_point = 0;
            $totalPotency = 0; 
        }
       
        return [$total_start_point,$totalPotency];
    }

    public function exportThisPeriod($vendor){
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        return Excel::download(new PointThisPeriodExport(), $period->name.'.xlsx');
    }

    public function exportFilterPeriod($vendor, $period_id){
        $period = \App\PointPeriod::findOrFail($period_id);
        //dd($period);
        return Excel::download(new PointFilterPeriodExport($period_id), $period->name.'.xlsx');
    }

    public static function pointsClaim($periodStart,$customerId){
        $client_id = \Auth::user()->client_id;
        $period = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('starts_at',$periodStart)
                    ->first();

        $claim = \DB::select("SELECT pc.id, pc.custpoint_id, pc.reward_id, pc.type,
                                pc.created_at, pr.point_rule, pr.bonus_amount, 
                                cs.store_name, cs.client_id
                                FROM point_claims as pc 
                                JOIN point_rewards as pr ON pc.reward_id = pr.id
                                JOIN customers as cs ON cs.id = pc.custpoint_id
                                WHERE cs.client_id = '$client_id'
                                AND pr.period_id = '$period->id'
                                AND pc.custpoint_id = '$customerId'
                                AND pc.type = 1;"
                            );
        
        $total_claim = 0;
        foreach($claim as $cm){
            $total_claim += $cm->point_rule;
        }

        return $total_claim;
    }

    public static function pointPartial($period_start,$csid){
        $period = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->where('starts_at', $period_start)
                    ->first();
        $dateSt =date('Y-m-15', strtotime($period->starts_at));
        $customers =\DB::select("SELECT o.id as oid, o.created_at, pr.created_at, pr.prod_point_val, pr.quantity_rule, pr.product_id,
                                        
                                            sum(case when date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                                    then
                                                    (pr.prod_point_val/pr.quantity_rule) * (IFNULL(pd.partial_qty,0)) else 0 end
                                                ) totalpoint
                                            
                                            FROM orders as o 
                                            JOIN order_product as op ON op.order_id = o.id  
                                            JOIN product_rewards as pr on pr.product_id = op.product_id
                                            JOIN partial_deliveries as pd on op.id = pd.op_id
                                            WHERE
                                            o.status = 'PARTIAL-SHIPMENT' AND
                                            ( (date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                               AND  
                                               date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                              )
                                              OR
                                              date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                            )
                                            AND
                                            o.customer_id = $csid AND
                                            pr.created_at = (SELECT MAX(created_at) FROM 
                                                            product_rewards GROUP BY product_id HAVING 
                                                            product_id = pr.product_id)"
                                );

        return $customers[0]->totalpoint;
    }

    public static function startPointPartial($period_start,$csid){
        $period = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->where('starts_at', $period_start)
                    ->first();
        $afterPeriod = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                ->whereDate('starts_at', '>', $period->expires_at)
                //->whereYear('expires_at',$yPeriodPrev)
                ->orderBy('starts_at','ASC')
                ->first();
        
        if($afterPeriod){
            $startTime = date('Y-m-15', strtotime($afterPeriod->starts_at));
            $dateSt =date('Y-m-15', strtotime($period->starts_at));
            $customers =\DB::select("SELECT o.id as oid, o.created_at, pr.created_at, pr.prod_point_val, pr.quantity_rule, pr.product_id,
                                            
                                                sum(case when date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                                        then
                                                        (pr.prod_point_val/pr.quantity_rule) * (IFNULL(pd.partial_qty,0)) else 0 end
                                                    ) totalpoint
                                                
                                                FROM orders as o 
                                                JOIN order_product as op ON op.order_id = o.id  
                                                JOIN product_rewards as pr on pr.product_id = op.product_id
                                                JOIN partial_deliveries as pd on op.id = pd.op_id
                                                WHERE
                                                o.status = 'FINISH' AND
                                                date(o.finish_time) between '$startTime' AND DATE_ADD(date('$afterPeriod->expires_at'), INTERVAL 14 DAY) 
                                                AND 
                                                (   (
                                                    date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                                    AND  
                                                    date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                                    )
                                                    OR
                                                    date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                                )
                                                AND
                                                o.customer_id = $csid AND
                                                pr.created_at = (SELECT MAX(created_at) FROM 
                                                                product_rewards GROUP BY product_id HAVING 
                                                                product_id = pr.product_id)"
                                    );

            return $customers[0]->totalpoint;
        }else{
            return 0;
        }
    }

    public static function pointPrevPartial($period_start,$csid){
        $date = date('Y-m-d', strtotime($period_start));
        $period = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('starts_at', $period_start)
                    ->first();
        $startTime = date('Y-m-15', strtotime($period_start));
        $yPeriodPrev = date('Y',strtotime($period_start));
        $PrevPeriodCheck = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                            ->whereDate('expires_at', '<', $date)
                            //->whereYear('expires_at',$yPeriodPrev)
                            ->orderBy('expires_at','DESC')
                            ->first();

        if($PrevPeriodCheck){
            $dateSt =date('Y-m-15', strtotime($PrevPeriodCheck->starts_at));
            $customers =\DB::select("SELECT o.id as oid, o.created_at, pr.created_at, pr.prod_point_val, pr.quantity_rule, pr.product_id,
                                        
                                        sum(case when date(pd.created_at) between '$PrevPeriodCheck->starts_at' AND DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)
                                                then
                                                (pr.prod_point_val/pr.quantity_rule) * (IFNULL(pd.partial_qty,0)) else 0 end
                                            ) totalpoint
                                        FROM orders as o 
                                        JOIN order_product as op ON op.order_id = o.id  
                                        JOIN product_rewards as pr on pr.product_id = op.product_id
                                        INNER JOIN partial_deliveries as pd on op.id = pd.op_id
                                        WHERE
                                        o.status = 'FINISH' AND
                                        date(o.finish_time) between '$startTime' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY) 
                                        AND 
                                        ( (date(o.created_at) between '$PrevPeriodCheck->starts_at' and '$PrevPeriodCheck->expires_at'
                                            AND  
                                            date(pd.created_at) between '$PrevPeriodCheck->starts_at' AND DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)
                                            )
                                            OR
                                            date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)
                                        )
                                        AND
                                        o.customer_id = $csid AND
                                        pr.created_at = (SELECT MAX(created_at) FROM 
                                                        product_rewards GROUP BY product_id HAVING 
                                                        product_id = pr.product_id)"
                                    );
            $pointPrevPartial = $customers[0]->totalpoint;
            //return $customers[0]->totalpoint;
        }else{
            $pointPrevPartial = 0;
        }

        return $pointPrevPartial;
    }
}