<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExportMapping;
use App\Exports\CustomerNotOrderExport;
use App\Exports\CustNotOrderThisPeriod;
use App\Exports\OrdersThisPeriod;
use Illuminate\Http\Request;


class OrderController extends Controller
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
                if(Gate::allows('manage-orders')) return $next($request);
                abort(403, 'Anda tidak memiliki cukup hak akses');
            }else{
                abort(404, 'Tidak ditemukan');
            }
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $vendor, $periodFilter = null) 
    {
        $user =\Auth::user()->roles;
        $id_user =\Auth::user()->id;
        $client_id = \Auth::user()->client_id;
        $datefrom = date('2021-06-01');
        if($periodFilter != null){
            //dd($periodFilter);
            $period_explode = explode('-',$periodFilter);
            
            $year = $period_explode[0];
            $month = $period_explode[1];
            
            $thisMonth = $month;
            $thisYear = $year;
            
        }else{
            $thisMonth = date('m');
            $thisYear = date('Y');
        }
        
        $orderAttach = \App\OrderAttachment::where('client_id', $client_id)
                            ->where('attach_status','SUBMIT')
                            ->first();
        $noOrderAttach = \App\OrderAttachment::where('client_id', $client_id)
                            ->where('attach_status','NO-ORDER')
                            ->first();
        //dd($client_id);
        if($user == 'SUPERVISOR'){
            $status = $request->get('status');
            if($status){
            $stts = strtoupper($status);
            $orders = \DB::select("SELECT * FROM orders WHERE 
                        client_id = $client_id 
                        AND customer_id IS NOT NULL 
                        AND status='$stts' 
                        AND MONTH(created_at) = '$thisMonth'
                        AND YEAR(created_at) = '$thisYear' /*created_at >= $datefrom*/ 
                        AND EXISTS 
                        (SELECT spv_id,sls_id FROM spv_sales WHERE 
                        spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
            }
            else{
                $orders = \DB::select("SELECT * FROM orders WHERE 
                        client_id = $client_id 
                        AND customer_id IS NOT NULL 
                        AND MONTH(created_at) = '$thisMonth'
                        AND YEAR(created_at) = '$thisYear' /*created_at >= $datefrom*/
                        AND EXISTS 
                        (SELECT spv_id,sls_id FROM spv_sales WHERE 
                        spv_sales.sls_id = orders.user_id AND spv_id='$id_user') ORDER BY created_at DESC");
                //dd($orders);
            }
        }
        else{
            $status = $request->get('status');
            if($status){
            $orders = \App\Order::with('products')
                    ->where('client_id','=',$client_id)
                    ->whereNotNull('customer_id')
                    ->where('status',strtoupper($status))
                    //->where('created_at','>=',$datefrom)
                    ->whereMonth('created_at',$thisMonth)
                    ->whereYear('created_at',$thisYear)
                    ->orderBy('created_at', 'desc')
                    ->get();//paginate(10);
            }
            else{
                $orders = \App\Order::with('products')
                    ->with('customers')
                    ->where('client_id','=',$client_id)
                    ->whereNotNull('customer_id')
                    //->where('created_at','>=',$datefrom)
                    ->whereMonth('created_at',$thisMonth)
                    ->whereYear('created_at',$thisYear)
                    ->orderBy('created_at', 'desc')
                    ->get();
            //dd($orders);
            }
        }
        
        return view('orders.index',[
                        'orders' => $orders,
                        'orderAttach'=>$orderAttach,
                        'noOrderAttach'=>$noOrderAttach,
                        'vendor'=>$vendor,
                        'thisMonth'=>$thisMonth,
                        'thisYear'=>$thisYear,
                        'periodFilter'=>$periodFilter
                    ]);
    }

    public function filter(Request $request, $vendor){
        $periodFilter = $request->get('listFilter');
        //dd( $periodFilter);
        //$year = $period_explode[0];
        //$month =$period_explode[1];

        return redirect()->route('orders.index', [$vendor,$periodFilter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor, $id)
    {
        $order = \App\Order::findOrFail($id);
        $dateNow = date('Y-m-d H:i:s');
        $status = $request->get('status');
        $prevStatus = $request->get('prevStatus');
        if($status == 'PROCESS'){
            $order->status = $status;
            $order->process_time = $dateNow;
            //$order->save();
        }else if($status == 'FINISH'){
            $order->status = $status;
            $order->finish_time = $dateNow;
            if($prevStatus !== 'PARTIAL-SHIPMENT'){
                $stock_status= \DB::table('product_stock_status')
                        ->where('client_id',\Auth::user()->client_id)->first();
                if($stock_status->stock_status == 'ON'){
                        $cek_quantity = \App\Order::with('products')->where('id',$id)->get();
                        foreach($cek_quantity as $q){
                            foreach($q->products as $p){
                                $up_product = \App\product::findOrfail($p->pivot->product_id);
                                $up_product->stock -= $p->pivot->quantity;
                                $up_product->save();
                            }
                        }
                }

                $podNumber = new \App\PodNumber();
                $podNumber->order_id = $order->id;
                $podNumber->pod_number = $request->get('pod_number');
                $podNumber->save();
            }
            
            //$order->save();
        }else if($status == 'CANCEL'){
            if($request->get('notes_cancel') != ''){
                $order->status = $status;
                $order->cancel_time = $dateNow;
                $order->notes_cancel = $request->get('notes_cancel');
                $order->canceled_by = \Auth::user()->id;
            }else{
                return redirect()->route('orders.detail', [$vendor,\Crypt::encrypt($order->id)])->with('error', 'Order status unsuccesfully updated');
            }
                
        }else if($status == 'PARTIAL-SHIPMENT'){
            if($request->get('partialDeliveryNotes') != ''){
                $order->status = $status;
                $order->NotesPartialShip = $request->get('partialDeliveryNotes');
                foreach ($request->order_productId as $i => $v){
                    /*$detail_order=array(
                        'deliveryQty'=>$request->deliveryQty[$v],
                    );*/
                    $new_dtl = \App\order_product::where('id',$request->order_productId[$i])->first();
                    $new_dtl->deliveryQty += $request->deliveryQty[$v];
                    $new_dtl->save();

                    if($new_dtl->save()){
                        $prd = \App\product::findOrfail($request->productId[$i]);
                        $prd->stock -= $request->deliveryQty[$v];
                        $prd->save();

                        $qtyPartDelv = $request->deliveryQty[$v];
                        if($qtyPartDelv > 0){
                            $partDel = new \App\PartialDelivery();
                            /*$partDel->orderProduct()->associate($)*/
                            $partDel->op_id = $new_dtl->id;
                            $partDel->partial_qty = $request->deliveryQty[$v];
                            $partDel->save();

                            $podNumber = new \App\PodNumber();
                            $podNumber->partialDelivery()->associate($partDel);
                            $podNumber->order_id = $order->id;
                            $podNumber->pod_number = $request->get('pod_number');
                            $podNumber->save();
                        }
                    }
                }
            }else{
                return redirect()->route('orders.detail', [$vendor,\Crypt::encrypt($order->id)])->with('error', 'Order status unsuccesfully updated');
            }
            
        }
        else{
            $order->status = $status;
        }
        $order->save();
        
        return redirect()->route('orders.detail', [$vendor,\Crypt::encrypt($order->id)])->with('status', 'Order status succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($vendor,$id)
    {
        $id = \Crypt::decrypt($id);
        $order = \App\Order::findOrFail($id);
        if($order->canceled_by != null){
            $order_cancel = \App\User::findOrFail($order->canceled_by);
        }else{
            $order_cancel = null;        
        }
        
        $paket_list = \DB::table('order_product')
                ->join('pakets','pakets.id','=','order_product.paket_id')
                ->join('groups','groups.id','=','order_product.group_id')
                ->where('order_id',$id)
                ->whereNotNull('paket_id')
                ->whereNotNull('group_id')
                ->whereNull('bonus_cat')
                ->distinct()
                ->get(['paket_id','group_id','discount_pkt','discount_pkt_type']);
                //dd($paket_list);
        return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list, 'vendor'=>$vendor,'order_cancel'=>$order_cancel]);
    }

    /*public function export_mapping($vendor) {
        return Excel::download( new OrdersExportMapping(), 'Orders.xlsx') ;
    }*/

    public function export_mapping(Request $request, $vendor){
        $period = $request->get('period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        //$type = $request->get('target_type');
        $selectType = $request->get('dataExport');
        if($selectType == 1){
            return Excel::download(new OrdersExportMapping($year,$month), 'Orders '.$month.'-'.$year.'.xlsx');
        }else{
            return Excel::download(new CustomerNotOrderExport($year,$month), 'CustomerNotOrders '.$month.'-'.$year.'.xlsx');
        }
        
    } 
    
    /*
    public function exportThisPeriod(Request $request, $vendor){
        $year = date('Y');
        $month = date('m');
        $selectType = $request->get('dataExport');
        $day = date('d');
        if($day <= 5){
            if($month == 1){
                $prevYear = $year-1;
                $prevMonth = 12;
                $dateS = $prevYear.'-'.$prevMonth.'-01';
                $dateE = $year.'-'.$month.'-'.$day;
            }else{
                $prevMonth = $month-1;
                $dateS = $year.'-'.$prevMonth.'-01';
                $dateE = $year.'-'.$month.'-'.$day;
            }
        }else{
            $dateS = $year.'-'.$month.'-01';
            $dateE = $year.'-'.$month.'-'.$day;
        }

        $period = $request->get('period');
        $date_explode = explode('-',$period);
        $year = $date_explode[0];
        $month = $date_explode[1];
        $selectType = $request->get('dataExport');
        if($selectType == 1){
            return Excel::download(new OrdersThisPeriod($year,$month), 'Orders '.$dateS.' to '.$dateE.'.xlsx');
        }else{
            return Excel::download(new CustNotOrderThisPeriod($year,$month), 'CustomerNotOrders '.$dateS.' to '.$dateE.'.xlsx');
        }
    }*/
      

    public function new_customer($vendor, $id, $payment = null){
        if(Gate::check('isSuperadmin') || Gate::check('isAdmin')){
            $id = \Crypt::decrypt($id);
            $cust = \App\Customer::findOrFail($id);
            $sls = \App\User::findOrFail($cust->user_id);
            return view('orders.edit_cust',['cust' => $cust,'vendor'=>$vendor, 'sls'=>$sls, 'payment'=>$payment]);
        }
        else{
            abort(403, 'Anda tidak memiliki cukup hak akses');
        } 
    }

    public function save_new_customer(Request $request, $vendor,$id)
    {
        \Validator::make($request->all(),[
            "city" => "required"
        ])->validate();

        $cust =\App\Customer::findOrFail($id);
        $cust->store_code = $request->get('store_code');
        $cust->name = $request->get('name');
        $cust->email = $request->get('email');
        $cust->phone = $request->get('phone');
        $cust->phone_owner = $request->get('phone_owner');
        $cust->phone_store = $request->get('phone_store');
        $cust->store_name = $request->get('store_name');
        $cust->city_id = $request->get('city');
        $cust->address = $request->get('address');
        $cust->client_id = $request->get('client_id');
        $pay_term = $request->get('payment_term');
        if($pay_term == 'TOP'){
            $cust->payment_term = $request->get('pay_cust').' Days';
        }else{
            $cust->payment_term = $pay_term;
        }
        $cust->status = 'ACTIVE';
        
        $cust->save();
        return redirect()->route('orders.addnew_customer',[$vendor,\Crypt::encrypt($id),$pay_term])->with('status','Customer Succsessfully Update');
    }

    public static function cekDiscountVolume($order_id){
        $amountVdisc = \App\order_product::where('order_id',$order_id)->get();
        $amountNodisc = \App\order_product::where('order_id',$order_id)
                      ->where('vol_disc_price',0)
                      ->whereNull('bonus_cat')
                      ->get();
        $totalPriceDisc = 0;
        $totalPriceNoDisc = 0;

        foreach($amountVdisc as $amount){
            $totalPriceDisc += $amount->quantity * $amount->vol_disc_price; 
        }

        foreach($amountNodisc as $amNoDisc){
            $totalPriceNoDisc += $amNoDisc->quantity * $amNoDisc->price_item;
        }


        //cekdiscount pkt
        $totalDiscPkt = 0;
        $selectDiscPaket = \DB::select("SELECT paket_id,discount_pkt,discount_pkt_type, 
                                        SUM(price_item * quantity) AS sumPrice 
                                        FROM order_product 
                                        WHERE order_id = '$order_id'
                                        AND discount_pkt IS NOT NULL
                                        GROUP BY paket_id
                                      ");
        
        foreach($selectDiscPaket as $opPkt){
            if($opPkt->discount_pkt_type == 'PERCENT'){
                $disc = ($opPkt->discount_pkt/100) * $opPkt->sumPrice;
                //$sumPrice = $opPkt->sumPrice - $disc; 
            }else{
                $disc = $opPkt->discount_pkt;
                //$sumPrice = $opPkt->sumPrice - $opPkt->discount_pkt;
            }

            $totalDiscPkt +=  $disc;
        }

        return ($totalPriceNoDisc + $totalPriceDisc) - $totalDiscPkt;
    }

    public static function PriceNoPktTotal($order_id){
        $amountVdisc = \App\order_product::where('order_id',$order_id)
                     ->get();

        $amountNodisc = \App\order_product::where('order_id',$order_id)
                      ->where('vol_disc_price',0)
                      ->whereNull('group_id')
                      ->get();

        $totalPriceDisc = 0;
        $totalPriceNoDisc = 0;

        foreach($amountVdisc as $amount){
            $totalPriceDisc += $amount->quantity * $amount->vol_disc_price; 
        }

        foreach($amountNodisc as $amNoDisc){
            $totalPriceNoDisc += $amNoDisc->quantity * $amNoDisc->price_item_promo;
        }


        return $totalPriceNoDisc + $totalPriceDisc;
    }

    public static function checkCountPartShip($order_id){
        $order = \DB::select("SELECT COUNT(id) AS jml  FROM order_product WHERE order_id = '$order_id' 
                                AND (deliveryQty < quantity OR (preorder > 0 AND deliveryQty is NULL));");
        
        $odr = 0;
        foreach($order as $o){
            $odr = $o->jml;
        }
        
        return $odr;       
    }

    public static function checkCountDelivQty($order_id){
        $order = \DB::select("SELECT COUNT(id) AS jml  FROM order_product WHERE order_id = '$order_id' 
                                AND deliveryQty IS NOT NULL AND deliveryQty > 0;");
        $odr = 0;
        foreach($order as $o){
            $odr = $o->jml;
        }
        
        return $odr; 
    }

    public static function getPodNumber($order_id,$opId){

        $cekExists = \App\PodNumber::where('order_id',$order_id)
                    ->whereNull('partial_id')->count();
        if($cekExists > 0){
            $partial = \DB::select("SELECT pod.order_id, pod.partial_id, pod.pod_number,
                                        pd.id as pdid, pd.op_id, pd.partial_qty, pd.created_at as pdCreate,
                                        o.id as orderid, o.finish_time , op.id as opid, op.quantity
                                FROM pod_numbers as pod
                                JOIN orders as o ON o.id = pod.order_id
                                LEFT JOIN partial_deliveries as pd ON pd.id = pod.partial_id
                                LEFT JOIN order_product as op ON op.id = pd.op_id
                                WHERE op.id = '$opId' OR pod.order_id = '$order_id'");
        }else{
            $partial = \DB::select("SELECT pod.order_id, pod.partial_id, pod.pod_number,
                                        pd.id as pdid, pd.op_id, pd.partial_qty, pd.created_at as pdCreate,
                                        o.id as orderid, o.finish_time , op.id as opid, op.quantity
                                FROM pod_numbers as pod
                                JOIN orders as o ON o.id = pod.order_id
                                LEFT JOIN partial_deliveries as pd ON pd.id = pod.partial_id
                                JOIN order_product as op ON op.id = pd.op_id
                                WHERE op.id = '$opId'");
        }
        
        return $partial;

    }

    public static function imageOrder($orderId){
        $imageUpld = \App\OrderFile::where('order_id',$orderId)->get();

        return $imageUpld;
    }

}
