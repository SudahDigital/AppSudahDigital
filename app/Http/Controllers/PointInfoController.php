<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PointInfoController extends Controller
{
    public static function StoreInfo($id){
        $customer = \App\Customer::findOrfail($id);
        return $customer->store_name;
        //return $ses_order->store_name
    }

    public static function PointInfo($customer_id)
    {   
        //$total_point = 0;
        
        $date = date('Y-m-d');
        $currentYear = date('Y');
        $client_id = \Auth::user()->client_id;

        /*$curr_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();*/
        $last_period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->orderBy('starts_at','DESC')->first();
        
        if($last_period){
            $cust_exists = \DB::select("SELECT * FROM customer_points 
                        WHERE period_id = $last_period->id AND
                        customer_points.customer_id = '$customer_id'");
            if($cust_exists){
                $dateSt =date('Y-m-15', strtotime($last_period->starts_at));
                $yearPeriod = date('Y', strtotime($last_period->starts_at));
                $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                FROM
                (SELECT o.id as oid, o.customer_id csid, pr.created_at,
                            
                            sum(case when(
                                    (   date(o.created_at) between '$last_period->starts_at' and '$last_period->expires_at'
                                        AND  
                                        date(o.finish_time) between '$last_period->starts_at' AND DATE_ADD(date('$last_period->expires_at'), INTERVAL 14 DAY)
                                    )
                                    OR
                                    (
                                        (date(o.created_at) <= '$last_period->expires_at' AND YEAR(o.created_at) = '$yearPeriod') 
                                            AND
                                        date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$last_period->expires_at'), INTERVAL 14 DAY)
                                    )
                                )
                            then 
                            (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end
                            ) totalpoint,
                            
                            sum(case when date(o.created_at) between '$last_period->starts_at' and '$last_period->expires_at'
                                    AND (o.status = 'SUBMIT' OR o.status = 'PROCESS' OR o.status = 'PARTIAL-SHIPMENT')
                                then
                                    (pr.prod_point_val/pr.quantity_rule) * (op.quantity - IFNULL(op.deliveryQty,0)) else 0 end
                                ) potentcyPoint
                            FROM orders as o 
                            JOIN order_product as op ON o.id = op.order_id 
                            JOIN products on products.id = op.product_id 
                            JOIN product_rewards as pr on pr.product_id = products.id
                            /*JOIN customers as cs on cs.id = o.customer_id*/
                            /*JOIN users as u on u.id = cs.user_id*/
                            /*LEFT JOIN partial_deliveries as pd on op.id = pd.op_id
                            /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                            WHERE
                            /*EXISTS ( SELECT * FROM customer_points WHERE period_id = $last_period->id AND
                                    customer_points.customer_id = o.customer_id) AND*/
                            o.customer_id = '$customer_id' AND
                            pr.created_at = (SELECT MAX(created_at) FROM 
                                            product_rewards GROUP BY product_id HAVING 
                                            product_id = op.product_id) 
                            AND
                            (
                            date(o.created_at) between '$last_period->starts_at' and '$last_period->expires_at'
                                OR
                            date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$last_period->expires_at'), INTERVAL 14 DAY)
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
                        WHERE prpc.period_id = '$last_period->id'
                        AND pc.custpoint_id = '$customer_id') pointsRewards
                on points.csid = pointsRewards.custpoint_id;");
                

                $_this = new self;
                $partPoint = $_this->pointPartial($last_period->starts_at,$customer_id);
                $startPartPoint = $_this->startPointPartial($last_period->starts_at,$customer_id);
                $pointPrevPartial = $_this->pointPrevPartial($last_period->starts_at,$customer_id);
                $claim = $_this->pointsClaim($last_period->starts_at,$customer_id);
                if($customers[0]->totalpoint){
                    $c_point = ($customers[0]->grand_total - $pointPrevPartial) + $startPartPoint + $partPoint;
                }else{
                    $c_point = (($customers[0]->grand_total - $pointPrevPartial) + $startPartPoint + $partPoint)-$claim;
                } 
                //$c_point = ($customers[0]->grand_total - $pointPrevPartial) + $startPartPoint + $partPoint;
                
                if($c_point == null){
                    $total = 0;
                    $pPoints = 0;
                }else{
                    $total = $c_point;
                    $pPoints = $customers[0]->potentcyPoint;
                }

                
                [$Year,$periodExpires,$total_start_point,$totalPotency] = $_this->starting_point($last_period->starts_at,$customer_id);
                if($Year != null){
                    $y = date('Y', strtotime($last_period->starts_at));
                    if($Year == $y){
                        if($y == $currentYear){
                            $total_point = $total + $total_start_point;
                            $totalPotencyPoints = $pPoints + $totalPotency;
                            $period = $last_period->starts_at; 
                        }else{
                            $dateExpired =  strtotime("+14 day", $last_period->expires_at);
                            if($date <= $dateExpired) {
                                $total_point = $total + $total_start_point;
                                $totalPotencyPoints = $pPoints + $totalPotency;
                                $period = $last_period->starts_at;
                            }else{
                                $total_point = 0;
                                $totalPotencyPoints = 0;
                            }
                        }
                    }else{
                        if($periodExpires != null){
                            //dd($periodExpires);
                            $prExp = \Carbon\Carbon::parse($periodExpires)->format('Y-m-d');
                            $dateExpired =  date('Y-m-d', strtotime("+14 day", strtotime($prExp)));
                            //dd($dateExpired);
                            if($date <= $dateExpired) {
                                $total_point = $total + $total_start_point;
                                $totalPotencyPoints = $pPoints + $totalPotency;
                                $period = $last_period->starts_at;
                            }else{
                                $total_point = $total;
                                $totalPotencyPoints = $pPoints;
                                $period = $last_period->starts_at;
                            }
                        }else{
                            $total_point = $total + $total_start_point;
                                $totalPotencyPoints = $pPoints + $totalPotency;
                                $period = $last_period->starts_at;
                            }
                        }
                        
                }else{
                    $total_point = $total + $total_start_point;
                    $totalPotencyPoints = $pPoints + $totalPotency;
                    $period = $last_period->starts_at;
                }
            }else{
                $month = date('m', strtotime($last_period->starts_at));
                $year = date('Y', strtotime($last_period->starts_at));
                if($month == '1'){
                    $prev_month = '12';
                    $year = $year - 1; 
                }else{
                    $prev_month = $month - 1;
                }
                
                $prev_period = \App\PointPeriod::where('client_id',$client_id)
                            ->whereMonth('expires_at',$prev_month)
                            ->whereYear('expires_at', $year)->first();

                if($prev_period){
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                WHERE period_id = $prev_period->id AND
                                customer_points.customer_id = '$customer_id'");
                    if($cust_exists){
                        $dateSt =date('Y-m-15', strtotime($prev_period->starts_at));
                        $yearPeriod = date('Y', strtotime($prev_period->starts_at));
                        $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                        FROM
                        (SELECT o.id as oid, cs.id csid, pr.created_at,
                            sum(case when(
                                (   date(o.created_at) between '$prev_period->starts_at' and '$prev_period->expires_at'
                                    AND  
                                    date(o.finish_time) between '$prev_period->starts_at' AND DATE_ADD(date('$prev_period->expires_at'), INTERVAL 14 DAY)
                                )
                                OR
                                (
                                    (date(o.created_at) <= '$prev_period->expires_at' AND YEAR(o.created_at) = '$yearPeriod') 
                                        AND
                                    date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$prev_period->expires_at'), INTERVAL 14 DAY)
                                )
                            )
                            then 
                            (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end
                            ) totalpoint,
                            
                            sum(case when date(o.created_at) between '$prev_period->starts_at' and '$prev_period->expires_at'
                                    AND (o.status = 'SUBMIT' OR o.status = 'PROCESS' OR o.status = 'PARTIAL-SHIPMENT')
                                then
                                    (pr.prod_point_val/pr.quantity_rule) * (op.quantity - IFNULL(op.deliveryQty,0)) else 0 end
                                ) potentcyPoint
                            FROM orders as o 
                            JOIN order_product as op ON o.id = op.order_id 
                            JOIN products on products.id = op.product_id 
                            JOIN product_rewards as pr on pr.product_id = products.id
                            JOIN customers as cs on cs.id = o.customer_id
                            JOIN users as u on u.id = cs.user_id
                            /*LEFT JOIN partial_deliveries as pd on op.id = pd.op_id
                            /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                            WHERE
                            /*EXISTS ( SELECT * FROM customer_points WHERE period_id = $prev_period->id AND
                                    customer_points.customer_id = o.customer_id) AND*/
                            pr.created_at = (SELECT MAX(created_at) FROM 
                                            product_rewards GROUP BY product_id HAVING 
                                            product_id = op.product_id) 
                            AND
                            (
                            date(o.created_at) between '$prev_period->starts_at' and '$prev_period->expires_at'
                                OR
                            date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$prev_period->expires_at'), INTERVAL 14 DAY)
                            )  
                            AND
                            o.status != 'CANCEL' AND o.status != 'NO-ORDER'AND
                            o.customer_id = '$customer_id'
                        ) as points
                        LEFT JOIN (SELECT pc.custpoint_id, prpc.period_id as ppid, sum(case when pc.Type = 1 then -(ifnull(pc.override_points, prpc.point_rule)) 
                                        when pc.Type = 2 then ifnull(pc.override_points,prpc.point_rule)
                                    else 0 end) Pointreward 
                                from point_claims as pc 
                                JOIN point_rewards as prpc on pc.reward_id = prpc.id
                                JOIN point_periods as pprd on prpc.period_id = pprd.id
                                WHERE prpc.period_id = '$prev_period->id'
                                AND pc.custpoint_id = '$customer_id') pointsRewards
                        on points.csid = pointsRewards.custpoint_id;");
                        
                        $_this = new self;
                        $partPoint = $_this->pointPartial($prev_period->starts_at,$customer_id);
                        $startPartPoint = $_this->startPointPartial($prev_period->starts_at,$customer_id);
                        $pointPrevPartial = $_this->pointPrevPartial($prev_period->starts_at,$customer_id);
                       
                        $claim = $_this->pointsClaim($prev_period->starts_at,$customer_id);
                        if($customers[0]->totalpoint){
                            $c_point = ($customers[0]->grand_total - $pointPrevPartial) + $startPartPoint + $partPoint;
                        }else{
                            $c_point = (($customers[0]->grand_total - $pointPrevPartial) + $startPartPoint + $partPoint)-$claim;
                        } 
                        
                        if($c_point == null){
                            $total = 0;
                            $pPoints = 0;
                        }else{
                            $total = $c_point;
                            $pPoints = $customers[0]->potentcyPoint;
                        }

                        //$_this = new self;
                        [$Year,$periodExpires,$total_start_point,$totalPotency] = $_this->starting_point($prev_period->starts_at,$customer_id);
                        if($Year != null){
                            $y = date('Y', strtotime($prev_period->starts_at));
                            if($Year == $y){
                                if($y == $currentYear){
                                    $total_point = $total + $total_start_point;
                                    $totalPotencyPoints = $pPoints + $totalPotency;
                                    $period = $last_period->starts_at; 
                                }else{
                                    $dateExpired =  strtotime("+14 day", $prev_period->expires_at);
                                    if($date <= $dateExpired) {
                                        $total_point = $total + $total_start_point;
                                        $totalPotencyPoints = $pPoints + $totalPotency;
                                        $period = $last_period->starts_at;
                                    }else{
                                        $total_point = 0;
                                        $totalPotencyPoints = 0;
                                    }
                                }
                            }else{
                                if($periodExpires != null){
                                    $prExp = \Carbon\Carbon::parse($periodExpires)->format('Y-m-d');
                                    $dateExpired =  date('Y-m-d', strtotime("+14 day", strtotime($prExp)));
                                    if($date <= $dateExpired) {
                                        $total_point = $total + $total_start_point;
                                        $totalPotencyPoints = $pPoints + $totalPotency;
                                        $period = $last_period->starts_at;
                                    }else{
                                        $total_point = $total;
                                        $totalPotencyPoints = $pPoints;
                                        $period = $last_period->starts_at;
                                    }
                                }else{
                                    $total_point = $total + $total_start_point;
                                    $totalPotencyPoints = $pPoints + $totalPotency;
                                    $period = $last_period->starts_at;
                                }
                                
                            }
                        }else{
                            $total_point = $total + $total_start_point;
                            $totalPotencyPoints = $pPoints + $totalPotency;
                            $period = $last_period->starts_at;
                        }
                    }
                    else{
                        $total_point = 0;
                        $totalPotencyPoints = 0;
                    }
                }else{
                    $total_point = 0;
                    $totalPotencyPoints = 0;
                }
                    
            }
        }
        else{
            $total_point = 0;
            $totalPotencyPoints = 0;
        }
        //dd($customers[0]->totalpoint);
        return [$total_point,$totalPotencyPoints];
        
    }

    public static function starting_point($period, $customer){
        
        $date =date('Y-m-d', strtotime($period));
        $PrevPeriodCheck = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                            ->whereDate('expires_at', '<', $date)
                            ->orderBy('expires_at','DESC')
                            ->first();

        if($PrevPeriodCheck){
            $Year =date('Y', strtotime($PrevPeriodCheck->starts_at));
            $periodExpires = date('Y-m-d', strtotime($PrevPeriodCheck->expires_at));
            $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$Year)
                    ->orderBy('expires_at','DESC')
                    ->get();
            if($prd_cek){
                $total_start_point = 0;
                $totalPotency = 0;
                foreach($prd_cek as $key => $period_cek){
                    
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                    WHERE period_id = $period_cek->id AND
                                    customer_points.customer_id = '$customer'");
                    if(!$cust_exists){
                        break;
                    }
                    $dateSt = date('Y-m-15', strtotime($period_cek->starts_at));
                    $yearPeriod = date('Y', strtotime($period_cek->starts_at));
                    $customers_cek =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                                FROM
                                (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                                            /*cp.id,*/ 
                                                sum(case when(
                                                            (
                                                                date(o.created_at) between '$period_cek->starts_at' and '$period_cek->expires_at'
                                                                AND  
                                                                date(o.finish_time) between '$period_cek->starts_at' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                                            )
                                                            OR
                                                            (
                                                                (date(o.created_at) <= '$period_cek->expires_at' AND YEAR(o.created_at) = '$yearPeriod') 
                                                                    AND
                                                                date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                                            )
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
                                            JOIN customers as cs on cs.id = o.customer_id
                                            JOIN users as u on u.id = cs.user_id
                                            /*LEFT JOIN partial_deliveries as pd on op.id = pd.op_id
                                            /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                                            WHERE
                                            
                                            
                                            pr.created_at = (SELECT MAX(created_at) FROM 
                                                            product_rewards GROUP BY product_id HAVING 
                                                            product_id = op.product_id) 
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
                    $pointPrevPartial[$key] = $_this->pointPrevPartial($period_cek->starts_at,$customer); 
                    $claim[$key] = $_this->pointsClaim($period_cek->starts_at,$customer);
                    if($customers_cek[0]->totalpoint){
                        $restpoints[$key] = ($customers_cek[0]->grand_total-$pointPrevPartial[$key]) + $startPartPoint[$key] + $partPoint[$key];
                    }else{
                        $restpoints[$key] = (($customers_cek[0]->grand_total-$pointPrevPartial[$key]) + $startPartPoint[$key] + $partPoint[$key])-$claim[$key];
                    }           
                    
                    
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
            $Year = null;
            $periodExpires = null;
        }
        return [$Year,$periodExpires,$total_start_point,$totalPotency];
    }

    public static function amountClaim($customer){
        $date = date('Y-m-d');
        $thisYear = date('Y');
        $checkPeriod = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                                ->whereDate('expires_at', '<', $date)
                                ->orderBy('expires_at','DESC')
                                ->first();
        $paramPeriod = null;                       
        if($checkPeriod){
            $paramPeriod = $checkPeriod->id;
            $Year =date('Y', strtotime($checkPeriod->starts_at));
            $lastExpPeriod = date('Y-m-d',strtotime($checkPeriod->expires_at));
            $prd_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '<', $date)
                    ->whereYear('expires_at',$Year)
                    ->orderBy('expires_at','DESC')
                    ->get();
            if($prd_cek){
                $total_start_point = 0;
                foreach($prd_cek as $key => $period_cek){
                    
                    $cust_exists = \DB::select("SELECT * FROM customer_points 
                                    WHERE period_id = $period_cek->id AND
                                    customer_points.customer_id = '$customer'");
                    // if(!$cust_exists){
                    //     break;
                    // }
                    if($cust_exists){
                        $dateSt = date('Y-m-15', strtotime($period_cek->starts_at));
                        $yearPeriod = date('Y', strtotime($period_cek->starts_at));
                        $customers_cek=\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                                FROM
                                (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                                            /*cp.id,*/ 
                                            sum(case when(
                                                        (
                                                            date(o.created_at) between '$period_cek->starts_at' and '$period_cek->expires_at'
                                                            AND  
                                                            date(o.finish_time) between '$period_cek->starts_at' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                                        )
                                                        OR
                                                        (
                                                            (date(o.created_at) <= '$period_cek->expires_at' AND YEAR(o.created_at) = '$yearPeriod') 
                                                                AND
                                                            date(o.finish_time) between '$dateSt' AND DATE_ADD(date('$period_cek->expires_at'), INTERVAL 14 DAY)
                                                        )
                                                    )
                                                then 
                                                (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end
                                            ) totalpoint
                                            FROM orders as o 
                                            JOIN order_product as op ON o.id = op.order_id 
                                            JOIN products on products.id = op.product_id 
                                            JOIN product_rewards as pr on pr.product_id = products.id
                                            JOIN customers as cs on cs.id = o.customer_id
                                            JOIN users as u on u.id = cs.user_id
                                            /*LEFT JOIN partial_deliveries as pd on op.id = pd.op_id
                                            /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                                            WHERE
                                            
                                            
                                            pr.created_at = (SELECT MAX(created_at) FROM 
                                                            product_rewards GROUP BY product_id HAVING 
                                                            product_id = op.product_id) 
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
                        //$restpoints = $customers_cek[0]->grand_total;
                        //dd($customers_cek[0]->totalpoint);
                        $_this = new self;
                        $claim[$key] = $_this->pointsClaim($period_cek->starts_at,$customer);
                        $partPoint[$key] = $_this->pointPartial($period_cek->starts_at,$customer);
                        $startPartPoint[$key] = $_this->startPointPartial($period_cek->starts_at,$customer);
                        $pointPrevPartial[$key] = $_this->pointPrevPartial($period_cek->starts_at,$customer);
                        if($customers_cek[0]->totalpoint){
                            $pointstart[$key] = ($customers_cek[0]->grand_total - $pointPrevPartial[$key]) + $startPartPoint[$key] + $partPoint[$key];
                        }else{
                            $pointstart[$key] = (($customers_cek[0]->grand_total - $pointPrevPartial[$key]) + $startPartPoint[$key] + $partPoint[$key])-$claim[$key];
                        }
                        
                    }else{
                        $pointstart[$key] = 0;
                    }
                    $total_start_point += $pointstart[$key];
                    //dd($pointstart[$key]);
                }
                
                //if($thisYear != $Year){
                    $dateExpired =  date('Y-m-d', strtotime("+19 day", strtotime($lastExpPeriod)));
                    //dd($dateExpired);
                    if($date <= $dateExpired){
                        $total_start_point = $total_start_point;
                    }else{
                        $total_start_point = 0;
                    }
                //}else{

                //    $total_start_point = $total_start_point;
                // }
            }else{
                $total_start_point = 0;
            }

        }
        else{
            $total_start_point = 0; 
        }

        return [$paramPeriod,$total_start_point];
    }

    public static function pointPartial($period_start,$csid){
        $period = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('starts_at', $period_start)
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
                                            ( date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                               AND  
                                               date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                              
                                              /*OR
                                              date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)*/
                                            )
                                            AND
                                            o.customer_id = $csid AND
                                            pr.created_at = (SELECT MAX(created_at) FROM 
                                                            product_rewards GROUP BY product_id HAVING 
                                                            product_id = op.product_id)"
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
                                                (   
                                                    date(o.created_at) between '$period->starts_at' and '$period->expires_at'
                                                    AND  
                                                    date(pd.created_at) between '$period->starts_at' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)
                                                    
                                                    /*OR
                                                    date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$period->expires_at'), INTERVAL 14 DAY)*/
                                                )
                                                AND
                                                o.customer_id = $csid AND
                                                pr.created_at = (SELECT MAX(created_at) FROM 
                                                                product_rewards GROUP BY product_id HAVING 
                                                                product_id = op.product_id)"
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
                            ->whereYear('expires_at',$yPeriodPrev)
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
                                        (   
                                            date(o.created_at) <= '$PrevPeriodCheck->expires_at'
                                                AND  
                                            date(pd.created_at) <= DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)

                                            /*date(o.created_at) between '$PrevPeriodCheck->starts_at' and '$PrevPeriodCheck->expires_at'
                                            AND  
                                            date(pd.created_at) between '$PrevPeriodCheck->starts_at' AND DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)
                                            /*OR
                                            date(pd.created_at) between '$dateSt' AND DATE_ADD(date('$PrevPeriodCheck->expires_at'), INTERVAL 14 DAY)*/
                                        )
                                        AND 
                                        o.customer_id = $csid AND
                                        pr.created_at = (SELECT MAX(created_at) FROM 
                                                        product_rewards GROUP BY product_id HAVING 
                                                        product_id = op.product_id)");
            $pointPrevPartial = $customers[0]->totalpoint; 
            
        }else{
            $pointPrevPartial = 0 ; 
        }

        return $pointPrevPartial;
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

}
