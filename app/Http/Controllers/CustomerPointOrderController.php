<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function index($vendor)
    {   
        $date = date('Y-m-d');
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::where('client_id',$client_id)
                    ->whereDate('starts_at', '<=', $date)
                    ->whereDate('expires_at', '>=', $date)->first();
        //dd($period->starts_at);
        if($period){
            $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
            FROM
            (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                        /*cp.id,*/ 
                        sum(case when o.finish_time between '$period->starts_at' and '$period->expires_at' 
                        then 
                        (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
                        FROM orders as o 
                        JOIN order_product as op ON o.id = op.order_id 
                        JOIN products on products.id = op.product_id 
                        JOIN product_rewards as pr on pr.product_id = products.id
                        JOIN customers as cs on cs.id = o.customer_id
                        JOIN users as u on u.id = cs.user_id
                        /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                        WHERE
                        EXISTS ( SELECT * FROM customer_points WHERE period_id = $period->id AND
                                customer_points.customer_id = o.customer_id) AND
                        pr.created_at = (SELECT MAX(created_at) FROM 
                                        product_rewards GROUP BY product_id HAVING 
                                        product_id = pr.product_id) AND  
                        o.created_at between '$period->starts_at' and '$period->expires_at' AND
                        o.status != 'CANCEL' AND o.status != 'NO-ORDER'
                        GROUP by o.customer_id 
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

    public function filter_period($vendor, $period_name, $period_id)
    {   
        //dd(\Crypt::decrypt($period_id));
        $client_id = \Auth::user()->client_id;

        $period_list = \App\PointPeriod::where('client_id',$client_id)->get();

        $period = \App\PointPeriod::findOrFail(\Crypt::decrypt($period_id));
        
        //dd($period);
        $customers =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
        FROM
        (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                    /*cp.id,*/ 
                    sum(case when o.finish_time between '$period->starts_at' and '$period->expires_at' 
                     then 
                    (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
                    FROM orders as o 
                    JOIN order_product as op ON o.id = op.order_id 
                    JOIN products on products.id = op.product_id 
                    JOIN product_rewards as pr on pr.product_id = products.id
                    JOIN customers as cs on cs.id = o.customer_id
                    JOIN users as u on u.id = cs.user_id
                    /*JOIN customer_points as cp on cp.customer_id = cs.id*/
                    WHERE
                    EXISTS ( SELECT * FROM customer_points WHERE period_id = $period->id AND
                                customer_points.customer_id = o.customer_id) AND
                    pr.created_at = (SELECT MAX(created_at) FROM 
                                    product_rewards GROUP BY product_id HAVING 
                                    product_id = pr.product_id) AND  
                    o.created_at between '$period->starts_at' and '$period->expires_at' AND
                    o.status != 'CANCEL' AND o.status != 'NO-ORDER'
                    GROUP by o.customer_id 
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
        $period_cek = \App\PointPeriod::where('client_id',\Auth::user()->client_id)
                    ->whereDate('expires_at', '>', $date)
                    ->orderBy('expires_at','DESC')
                    ->first();
        $customers_cek =\DB::select("SELECT *, points.totalpoint +ifnull( pointsRewards.Pointreward,0) as grand_total
                    FROM
                    (SELECT o.id as oid, cs.id csid,  cs.store_name, cs.user_id , u.name as sales_name, pr.created_at,
                                cp.id, 
                                sum(case when o.finish_time between '$period_cek->starts_at' and '$period_cek->expires_at' 
                                 then 
                                (pr.prod_point_val/pr.quantity_rule) * op.quantity  else 0 end) totalpoint
                                FROM orders as o 
                                JOIN order_product as op ON o.id = op.order_id 
                                JOIN products on products.id = op.product_id 
                                JOIN product_rewards as pr on pr.product_id = products.id
                                JOIN customers as cs on cs.id = o.customer_id
                                JOIN users as u on u.id = cs.user_id
                                JOIN customer_points as cp on cp.customer_id = cs.id
                                WHERE
                                
                                pr.created_at = (SELECT MAX(created_at) FROM 
                                                product_rewards GROUP BY product_id HAVING 
                                                product_id = pr.product_id) AND  
                                o.created_at between '$period_cek->starts_at' and '$period_cek->expires_at' AND
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
        $restpoints = $customers_cek[0]->grand_total;
        if($restpoints == null){
            $pointstart = 0;
        }else{
            $pointstart = $restpoints;
        }

        return $pointstart;
        //dd($customers_cek[0]->grand_total);
        //return $customers_cek->grand_total;
    }
}
