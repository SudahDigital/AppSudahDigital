<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxDetailPesananSales extends Controller
{
    public function search_order(Request $request){
        
        //$output = '';
        $user_id = \Auth::user()->id;
        $query = $request->get('query');
        $datefrom = date('2021-06-01');
        if($query != '' ){
            $orders = \DB::select("SELECT orders.* ,order_product.deliveryQty, order_product.preorder,
                                   order_product.quantity, 
                                 customers.id as cs_id, customers.store_name, customers.status as cs
                                FROM orders 
                                INNER JOIN customers ON orders.customer_id=customers.id
                                JOIN order_product ON orders.id = order_product.order_id
                                WHERE orders.user_id='$user_id' 
                                AND orders.created_at >= $datefrom 
                                AND (customers.store_name LIKE '%$query%'
                                    OR orders.status LIKE '%$query%' 
                                    OR orders.created_at LIKE '%$query%')
                                GROUP BY orders.id 
                                ORDER BY orders.created_at DESC");
            
        }
        else{
            $orders = \App\Order::with('products')
                    ->with('customers')->whereNotNull('customer_id')
                    ->where('user_id','=',"$user_id")
                    ->where('created_at','>=',$datefrom)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }

        if($orders != null ){
            $total_row = count($orders);
        }
        else{
            $total_row = 0;
        }
        if($total_row > 0){
            foreach($orders as $order){
                $imageUpld = \App\OrderFile::where('order_id',$order->id)->get();
                if($query != '' ){
                    $total_delivery_sum = \App\order_product::where('order_id',$order->id)
                                        ->groupBy('order_id')
                                        ->selectRaw('sum(deliveryQty) as sum')
                                        ->pluck('sum');
                    $total_delivery_arr = json_decode($total_delivery_sum,JSON_NUMERIC_CHECK); 
                    $total_delivery =  $total_delivery_arr[0];
                                      
                    $total_preorder_sum = \App\order_product::where('order_id',$order->id)
                                        ->groupBy('order_id')
                                        ->selectRaw('sum(preorder) as sum')
                                        ->pluck('sum');
                    $total_preorder_arr = json_decode($total_preorder_sum,JSON_NUMERIC_CHECK); 
                    $total_preorder =  $total_preorder_arr[0];

                    $total_quantity_sum = \App\order_product::where('order_id',$order->id)
                                    ->groupBy('order_id')
                                    ->selectRaw('sum(quantity) as sum')
                                    ->pluck('sum');
                    $total_quantity_arr = json_decode($total_quantity_sum,JSON_NUMERIC_CHECK); 
                    $total_quantity =  $total_quantity_arr[0];

                    $cekpartial = \App\order_product::where('order_id',$order->id)
                                  ->whereNotNull('deliveryQty')->count();
                     
                }else{
                    $cekpartial = $order->products()->whereNotNull('deliveryQty')->count();
                    $total_delivery = 0;
                    $total_preorder = 0;
                    $total_quantity = 0;
                    foreach($order->products as $p){
                        $total_delivery += $p->pivot->deliveryQty;
                        $total_preorder += $p->pivot->preorder;
                        $total_quantity += $p->pivot->quantity;
                    }
                }

                if($query != ''){
                    $customer_store = $order->store_name;
                    if($order->cs == 'NEW'){
                        $c_bdge_new = '<span class="badge bg-primarry">New</span>';
                    }else{
                        $c_bdge_new='';
                    }
                }else{
                    $customer_store = $order->customers->store_name;
                    if($order->customers->status == 'NEW'){
                        $c_bdge_new = '<span class="badge bg-primarry">New</span>';
                    }else{
                        $c_bdge_new='';
                    }
                }

                if($order->status == "SUBMIT"){
                    $color_badge = 'bg-warning';
                }
                else if($order->status == "PROCESS"){
                    $color_badge = 'bg-info';
                }
                else if($order->status == "PARTIAL-SHIPMENT"){
                    $color_badge = 'bg-info';
                }
                else if($order->status == "FINISH"){
                    $color_badge = 'bg-success';
                }
                else if($order->status == "CANCEL"){
                    $color_badge = 'bg-danger';
                }
                else if($order->status == "NO-ORDER"){
                    $color_badge = 'bg-dark';
                }

                $PriceTotal = \App\Http\Controllers\TransaksiSalesController::cekDiscountVolume($order->id);

                echo'
                <tr>
                    <!--
                    <td width="20%" style="padding-left:7px;">
                        <span class="style-badge badge '.$color_badge.' text-white status-order">'.$order->status.'</span>
                    </td>-->
                    <td width="60%">
                        <span class="data-list-order"><p class="mb-n1">Nmr. Order</p></span>
                        <b class="data-list-order">'.$order->invoice_number.'</b><br>
                        <span class="data-list-order"><p class="mb-n1 mt-2">Status</p></span>
                        <span class="status-style badge '.$color_badge.' text-white status-order">';
                            if(($order->status == "PARTIAL-SHIPMENT") && ($total_delivery <= 0)){
                                echo 'PENDING-SHIPMENT';
                            }else{
                                echo $order->status;
                            }
                        echo'</span>
                        <span class="data-list-order"><p class="mb-n1">Tanggal Order</p></span>
                        <b class="data-list-order mb-4">'.$order->created_at.'</b><br>

                        <!--<span class="data-list-order"><p class="mb-n1 mt-2">Total Quantity</p></span>
                        <b class="data-list-order"></b><br>-->

                        <span class="data-list-order"><p class="mb-n1 mt-2">Total Harga</p></span>
                        <b class="data-list-order"> Rp. '.number_format($PriceTotal, 2, ',', '.').'</b><br>
                        
                        <a onclick="open_detail_list('.$order->id.')" style="cursor: pointer;">
                            <span class="style-badge badge text-light mt-2"
                                style="padding:5px 10px;background:#1A4066">
                                <small><b>Detail Pesanan</b></small>
                            </span>
                        </a>
                    </td>
                    <td width="40%">
                        <span class="data-list-order">'.$customer_store.'</span>
                        '.$c_bdge_new;
                        if(($total_preorder > 0) && ($order->status == "PARTIAL-SHIPMENT")){
                            echo'<br>
                            <span class="badge badge-warning">Outstanding :'. ($total_quantity - $total_delivery).'</span><br>
                            <span class="badge badge-info">Delivered : '.$total_delivery.'</span>';
                        }elseif(($cekpartial > 0) && ($order->status == "PARTIAL-SHIPMENT")){
                            echo'<br>
                            <span class="badge badge-warning">Outstanding : '.($total_quantity - $total_delivery).'</span><br>
                            <span class="badge badge-info">Delivered : '.$total_delivery.'</span>';
                        }
                        if($order->po_file || $imageUpld){
                            echo'<br>
                            <div class="aniimated-thumbnials list-unstyled row clearfix">';
                                if($order->po_file){
                                    echo'<a href="'.asset('storage/'.$order->po_file).'" data-sub-html="PO-DOC-'.$order->invoice_number.'">
                                        <img  src="'.asset('storage/'.$order->po_file).'" width="50px" height="50px" style="margin-left:15px;margin-top:10px;">
                                    </a>';
                                }
                                foreach($imageUpld as $oFile){
                                    echo'<a href="'.asset('storage/'.$oFile->order_file).'" data-sub-html="PO-DOC-'.$order->invoice_number.'">
                                        <img  src="'.asset('storage/'.$oFile->order_file).'" width="50px" height="50px" style="margin-left:15px;margin-top:10px;">
                                    </a>';
                                }
                            echo'</div>';
                        }
                    echo'</td>';
                    echo "<script>
                            $(document).ready(function() {
                            $('.aniimated-thumbnials').lightGallery({
                                thumbnail: true,
                                selector: 'a'
                            });
                        });
                    </script>";
                echo '</tr>';
            }
        }
        else{
            echo '<tr>
                            <td align="center" colspan="3">Data tidak ditemukan</td>
                       </tr>';
        }
        /*$orders = array(
        'table_data'  => $output
        );
     
        echo json_encode($orders);*/
    
    }

    public function detail(Request $request)
    {
        $id = $request->get('order_id');
        $order = \App\Order::findOrFail($id);
        if($order->canceled_by != null){
            $order_cancel = \App\User::findOrFail($order->canceled_by);
        }else{
            $order_cancel = null;        
        }
        //$order_cancel = \App\User::findOrFail($order->canceled_by);
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
        if($order->status == 'SUBMIT'){
            $bg_badge = 'bg-warning';
            $txt = 'SUBMIT';
        }else if($order->status == 'PROCESS'){
            $bg_badge = 'bg-info';
            $txt= 'PROCESS';
        }
        else if($order->status == 'PARTIAL-SHIPMENT'){
            $bg_badge = 'bg-blue-grey';
            if($order->TotalDelivery <= 0){
                $txt= 'PENDING-SHIPMENT';
            }else{
                $txt= 'PARTIAL-SHIPMENT';
            }
        }
        else if($order->status == 'FINISH'){
            $bg_badge = 'bg-success';
            $txt= 'FINISH';
        }
        else if($order->status == 'CANCEL'){
            $bg_badge = 'bg-danger';
            $txt= 'CANCEL';
        }
        else if($order->status == 'NO-ORDER'){
            $bg_badge = 'bg-dark';
            $txt= 'NO-ORDER';
        }
                //dd($paket_list);
        //return view('orders.detail', ['order' => $order, 'paket_list'=>$paket_list]);
        echo'
        <div id="DataListOrder">
            <small style="color:#1A4066;"><b>Detail Order  &nbsp;#'.$order->invoice_number.'</b></small>
            <hr>
            <ul class="list-group">
                <li class="list-group-item disabled py-0">
                    <small><b>Tanggal Order</b> <br>
                    <p class="mt-n1">'.$order->created_at.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small class="mb-n3"><b >Status Order</b><br></small>
                    <span class="mt-n2 badge '.$bg_badge.'" 
                        style="color:#ffffff;
                            margin-top:-20px;
                            border-top-right-radius:0;
                            border-top-left-radius:0;
                            border-bottom-right-radius:0;
                            border-bottom-left-radius:0;">
                        '.$txt.'
                    </span>';
                    if($order->status == 'PARTIAL-SHIPMENT'){
                        echo '<br><small class="mb-n3 text-danger">'
                            .$order->NotesPartialShip.'
                        </small>';
                    }
                echo '</li>
                <li class="list-group-item disabled py-0">
                    <small class="mt-n1"><b>Nama Toko</b><br>
                    <p class="mt-n1">'.$order->customers->store_name.'</p></small>';
                    /*if($order->customers->status == 'NEW'){
                        echo '<span class="badge bg-pink">New</span>';
                    }*/
                echo '</li>
                <li class="list-group-item disabled py-0">
                    <small><b>Contact Person</b><br> 
                    <p class="mt-n1">'.$order->customers->name.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>Email</b><br>';
                    if($order->customers->email){
                        echo'<p class="mt-n1">'.$order->customers->email.'</p></small>';
                    }else{
                        echo'<p class="mt-n1">-</p></small>';
                    }
                echo'</li>
                <li class="list-group-item disabled py-0">
                    <small><b>Alamat Toko</b><br>
                    <p class="mt-n1">'.$order->customers->address.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>No. Hp</b><br>
                    <p class="mt-n1">'.$order->customers->phone.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>No. Telp. Toko :</b><br>';
                    if($order->customers->phone_store){
                        echo'<p class="mt-n1">'.$order->customers->phone_store.'</p></small>';
                    }else{
                        echo'<p class="mt-n1">-</p></small>';
                    }
                echo'</li>
                <li class="list-group-item disabled py-0">
                    <small><b>No. Telp. Pemilik Toko</b><br>';
                    if($order->customers->phone_owner){
                        echo'<p class="mt-n1">'.$order->customers->phone_owner.'</p></small>';
                    }else{
                        echo'<p class="mt-n1">-</p></small>';
                    } 
                echo'</li>
                <li class="list-group-item disabled py-0">
                    <small><b>Nama Sales</b><br>
                    <p class="mt-n1">'.$order->users->name.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>ON/Off Lokasi Sales</b><br>
                    <p class="mt-n1">'.$order->user_loc.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>Jenis Pembayaran</b><br> 
                    <p class="mt-n1">'.$order->payment_method.'</p></small>
                </li>
                <li class="list-group-item disabled py-0">
                    <small><b>Keterangan Order</b> <br>';
                    if($order->notes){
                        echo'<p class="mt-n1">'.$order->notes.'</p></small>';
                    }else{
                        echo'<p class="mt-n1">-</p></small>';
                    }
                echo '</li>';
                if($order->status == 'CANCEL'){
                    echo'
                    <li class="list-group-item disabled py-0">
                        <small><b>Keterangan Pembatalan</b><br>
                        <p class="mt-n1">'.$order->notes_cancel.'</p></small>
                    
                    <small><b>Dibatalkan Oleh</b><br>
                    <p class="mt-n1">'.$order_cancel->name.'</p></small>
                    </li>';
                }
            echo'</ul>
           
            <div class="mb-2 mt-2">
                <small style="color:#1A4066;"><b>Detail Produk</b></small>
            </div>';
            
            if(count($order->products_nonpaket) > 0){
                echo'
                    <table width="100%" class="table table-hover" style="">
                        <thead class="thead-dark">
                            <th width="50%" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Produk (NonPaket)</p></b></small>
                            </th>
                            <th width="" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Jumlah </p></b></small> 
                            </th>
                            <th width="40%" style="padding-bottom:0;" class="text-right">
                                <small><b><p style="line-height:1.2;">Sub Total</p></b></small>
                            </th>
                        </thead>
                        <tbody>';
                            foreach($order->products_nonpaket as $p){
                                echo'<tr>
                                    <td width="50%" style="padding-bottom:0;">
                                        <small>
                                            <p style="line-height:1.2;">'.$p->Product_name.'</p>';
                                         echo'</small>';
                                        
                                            if(($p->pivot->preorder > 0) && (($order->status == 'SUBMIT') || ($order->status == 'PROCESS') || ($order->status == 'CANCEL')))
                                            {
                                                echo'
                                                <small>
                                                    <span class="badge badge-info">Tersedia : '.$p->pivot->available.'</span>
                                                    <span class="badge badge-warning">Pre-Order : '.$p->pivot->preorder.'</span>
                                                </small>';
                                            }else if($order->status == 'PARTIAL-SHIPMENT'){
                                                
                                                    echo'<small>
                                                        <span class="badge badge-warning">Outstanding : '.($p->pivot->quantity - $p->pivot->deliveryQty).'</span>
                                                        <span class="badge badge-info">Delivered : '.$p->pivot->deliveryQty.'</span>
                                                    </small>';
                                                
                                            }
                                        
                                        if($p->pivot->vol_disc_price > 0){
                                            echo'<br>
                                            <span>
                                                <small>
                                                    <small><b>@Rp. '.number_format($p->pivot->vol_disc_price, 2, ',', '.').'</b></small>
                                                </small>
                                            </span>';
                                        }
                                    echo'</td>
                                    <td style="padding-bottom:0;">
                                        <small>
                                            <p style="line-height:1.2;">'.$p->pivot->quantity.'</p>
                                        </small>
                                    </td>
                                    <td width="40%" align="right" style="padding-bottom:0;">';
                                    if($p->pivot->vol_disc_price > 0){
                                        echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->pivot->vol_disc_price * $p->pivot->quantity, 2, ',', '.').'</p></small>';
                                    }else{
                                        if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0)){
                                        echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->pivot->price_item_promo * $p->pivot->quantity, 2, ',', '.').'</p></small>';
                                        }else{
                                        echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->pivot->price_item * $p->pivot->quantity, 2, ',', '.').'</p></small>';
                                        }
                                    }
                                    echo'</td>
                                </tr>';
                            }
                            echo '<tr>';
                                /*$pirce_r = \App\order_product::where('order_id',$order->id)
                                    ->whereNull('group_id')
                                    ->whereNull('paket_id')
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));*/
                                
                                echo'<td align="right" style="padding-right:0;" >
                                    <small>
                                        <p style="line-height:1.2;">
                                            <b>Total Harga :</b>
                                        </p>
                                    </small>
                                </td>
                                <td  colspan="2" width="60%" align="right">
                                    <small>
                                        <p style="line-height:1.2;">';
                                            $PriceNoPktTotal = \App\Http\Controllers\TransaksiSalesController::PriceNoPktTotal($order->id);
                                            echo '<b>Rp. '.number_format($PriceNoPktTotal, 2, ',', '.').'</b>
                                        </p>
                                    </small>
                                </td>
                            </tr>

                            <tr>
                            </tr>
                        </tbody>
                    </table>';
            }
            
            if(count( $paket_list) > 0){
                foreach($paket_list as $paket){
                        $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    echo '<table width="100%" class="table table-hover ">
                        <thead class="thead-dark">
                            <th width="50%" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Product '.$paket_name->display_name.' - '.$group_name->display_name.'</p></b></small>
                            </th>
                            <th width="" style="padding-bottom:0;">
                                <small><b><p style="line-height:1.2;">Jumlah </p></b></small> 
                            </th>
                            <th width="40%" style="padding-bottom:0;" class="text-right">
                                <small><b><p style="line-height:1.2;">Sub Total</p></b></small>
                            </th>
                            </thead>
                        <tbody>';
                                $cek_paket=\DB::table('order_product')
                                            ->join('products','products.id','=','order_product.product_id')
                                            ->where('order_id',$order->id)
                                            ->where('paket_id',$paket->paket_id)
                                            ->where('group_id',$paket->group_id)
                                            ->orderBy('bonus_cat','ASC')
                                            ->get();
                            foreach($cek_paket as $p){
                            echo'<tr>
                                <td width="50%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        echo '<small><p style="line-height:1.2;">'.$p->Product_name.'</p></small>';
                                    }else{
                                        echo '<small><p style="line-height:1.2;">'.$p->Product_name.'&nbsp;(<small><b>BONUS</b></small>)</p></small>';
                                    }

                                    if(($p->preorder > 0) && (($order->status == 'SUBMIT') || ($order->status == 'PROCESS') || ($order->status == 'CANCEL')))
                                    {
                                        echo'
                                        <br>
                                        <small>
                                            <span class="badge badge-info">Tersedia : '.$p->available.'</span>
                                            <span class="badge badge-warning">Pre-Order : '.$p->preorder.'</span>
                                        </small>';
                                    }else if($order->status == 'PARTIAL-SHIPMENT'){
                                        echo'<br>
                                        <small>
                                            <span class="badge badge-warning">Outstanding : '.($p->quantity - $p->deliveryQty).'</span>
                                            <span class="badge badge-info">Delivered : '.$p->deliveryQty.'</span>
                                        </small>';
                                        
                                    }
                                echo 
                                '</td>
                                <td style="padding-bottom:0;">
                                    <small><p style="line-height:1.2;">'.$p->quantity.'</p></small>
                                </td>
                                <td align="right" width="40%" style="padding-bottom:0;">';
                                    if($p->bonus_cat == NULL){
                                        if(($p->discount_item != NULL) && ($p->discount_item > 0)){
                                            echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->price_item_promo * $p->quantity, 2, ',', '.').'</p></samall>';
                                        }else{
                                            echo '<small><p style="line-height:1.2;">Rp. '.number_format($p->price_item * $p->quantity, 2, ',', '.').'</p></small>';
                                        }
                                    }
                                echo '</td>
                            </tr>';
                            }
                            
                            echo '<tr>
                                <td align="right" style="padding-right:0;">
                                    <small>
                                        <p style="line-height:1.2;">
                                            <b>';if($paket->discount_pkt){
                                                    echo 'Harga :';
                                                }else{
                                                    echo 'Total Harga :';
                                                }
                                            echo'</b>
                                        </p>
                                    </small>';
                                    if($paket->discount_pkt){
                                        echo'<small>
                                            <p style="line-height:1.2;">
                                                <b>Diskon :</b>
                                            </p>
                                        </small>
                                        <small>
                                            <p style="line-height:1.2;">
                                                <b>Total Harga :</b>
                                            </p>
                                        </small>';
                                    }
                                echo'</td>';
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                            ->where('group_id',$paket->group_id)
                                            ->where('paket_id',$paket->paket_id)
                                            ->whereNull('bonus_cat')
                                            ->sum(\DB::raw('price_item * quantity'));
                                echo'<td colspan="2" width="60%" align="right">
                                    <small>
                                        <p style="line-height:1.2;">
                                            <b>Rp. '.number_format($pkt_pirce, 2, ',', '.').'</b>
                                        </p>
                                    </small>';
                                    if($paket->discount_pkt){
                                        //discount
                                        echo'<small>
                                            <p style="line-height:1.2;">
                                                <b>';
                                                    if($paket->discount_pkt_type == 'PERCENT'){
                                                        echo $paket->discount_pkt. ' %';
                                                    }else{
                                                        echo'Rp. '.number_format($paket->discount_pkt, 2, ',', '.');
                                                    }
                                                echo'</b>
                                            </p>
                                        </small>
                                        
                                        <small>
                                            <p style="line-height:1.2;">
                                                <b>';
                                                    if($paket->discount_pkt_type == 'PERCENT'){
                                                       $jmlDiscPkt = ($paket->discount_pkt/100) * $pkt_pirce;
                                                       $afterDiscPkt = $pkt_pirce - $jmlDiscPkt;
                                                    }else{
                                                        $afterDiscPkt = $pkt_pirce - $paket->discount_pkt;
                                                    }
                                                    echo'Rp. '.number_format( $afterDiscPkt, 2, ',', '.');
                                                echo'</b>
                                            </p>
                                        </small>';
                                    }
                                echo'</td>
                            </tr>
                        </tbody>
                    </table>';
                }
            }
            $PriceTotal = \App\Http\Controllers\TransaksiSalesController::cekDiscountVolume($order->id);
            echo '<div class="grand-total" style="">
                
                    <table width="100%" class="table table-hover">
                        <tbody class="thead-light">
                            <tr>
                                <td style="border-bottom:none;padding-right:0;" width="" align="right"><small><p style="line-height:1.2;"><b>Grand Total :</p></small></td>
                                <td style="border-bottom:none;" width="60%" class="text-right"><small><p style="line-height:1.2;">
                                    <b>Rp. '.number_format($PriceTotal, 2, ',', '.').'</b></small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                
            </div>';
            if($order->status == 'SUBMIT'){
                echo'
                <div class="p-btn-detil">
                    <button type="submit" onclick="cancel_status('.$order->id.')" class="bt-dtl-pesan btn btn-danger py-1 px-3 mb-5 float-right mt-4"
                        style="background-color: #FF0000 !important;
                                border-top-right-radius:20px;
                                border-top-left-radius:20px;
                                border-bottom-right-radius:0;
                                border-bottom-left-radius:0;">
                        <i class="fa fa-times fa-1x" aria-hidden="true" style="color:#fff;font-weight:900;">
                        </i>&nbsp;<b>Batalkan Pesanan</b>
                    </button>
                </div>   
                ';
                
            }
        echo'
        </div>';

        
    }

    public function cancel_success(){
        $client_id = \Auth::user()->client_id;
        $vendor_cek= \App\B2b_client::findorFail($client_id);
        $vendor = $vendor_cek->client_slug;
        
        return redirect()->route('pesanan', [$vendor]);
    }

    public static function countAchTarget($csId, $period){
        $storeTarget = \App\Store_Targets::where('customer_id',$csId)
                      ->where('period',$period)
                      ->first();
        if($storeTarget){
            $detailItem = \App\ProductTarget::where('storeTargetId',$storeTarget->id)
                        ->get();
            $totalItem = 0 ;
            foreach($detailItem as $dtl){
                $_this = new self;
                $itemOrder = $_this->getItemOrder($csId,$dtl->productId);
                $totalItem += $itemOrder < $dtl->quantityValues;
            }
            
        }else{
            $totalItem = 'noTarget';
        }

        return $totalItem;
    }

    public function detailItemTarget(Request $request){
        $csId = $request->get('csId');
        $period = $request->get('period');

        $storeTarget = \App\Store_Targets::where('customer_id',$csId)
                      ->where('period',$period)
                      ->first();

        if($storeTarget){
            $detailItem = \App\ProductTarget::where('storeTargetId',$storeTarget->id)
                        ->get();
            $count = $detailItem->count();
            if($count > 0){
                echo '<ul class="list-group">';
                    //$numb = 0;
                    foreach($detailItem as $dtl){
                        $itemOrder = $this->getItemOrder($csId,$dtl->productId);
                        //$numb += $itemOrder < $dtl->quantityValues;
                        
                        /*if($numb <= 0){
                            echo
                            '<li class="list-group-item" style="color:#1A4066">
                                <p style="line-height:1.2;font-weight:600;">Tidak ada item belum capai </p>
                            </li>';
                        }*/

                        if($itemOrder < $dtl->quantityValues){
                            $badgePs = 'badge-danger';
                        }else{
                            $badgePs = 'badge-success';
                        }
                        
                        //if($itemOrder < $dtl->quantityValues){
                            echo
                            '<li class="list-group-item" style="color:#1A4066">
                                <p style="line-height:1.2;font-weight:600;">'.$dtl->products->Product_name.'</p>

                                <small>Total Pesanan</small>
                                <span class="badge '.$badgePs.' badge-pill" style="float:right;">'.$itemOrder.'</span>
                                
                                <br><small>Jumlah Target</small>
                                <span class="badge badge-primary badge-pill" style="float:right;">'.$dtl->quantityValues.'</span>
                            </li>';
                        //}
                    }
                echo '</ul>';
            }else{
                echo '<ul class="list-group">
                    <li class="list-group-item" style="color:#1A4066">
                        <p style="line-height:1.2;font-weight:600;">Tidak ada target item</p>
                    </li>
                </ul>';
            }
        }else{
            echo '<ul class="list-group">
                    <li class="list-group-item" style="color:#1A4066">
                        <p style="line-height:1.2;font-weight:600;">Tidak ada target item</p>
                    </li>
                </ul>';
        }
    }

    function getItemOrder($csId,$productId){
        $month = date('m');
        $year = date('Y');
        /*$sumItem = \App\Order::whereHas('products', function ($q) use ($productId){
                    $q->where('product_id',$productId);
                })
                ->where('customer_id',$csId)
                ->where('status','!=','CANCEL')
                ->where('status','!=','NO-ORDER')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->get();*/
        $sumItem = \DB::select("SELECT op.id, op.product_id, op.quantity, 
                                    o.customer_id, o.created_at, o.status
                                FROM `order_product` as op
                                JOIN orders as o ON op.order_id = o.id
                                WHERE o.customer_id = '$csId' 
                                AND MONTH(o.created_at) = '$month'
                                AND YEAR(o.created_at) = '$year'
                                AND o.status != 'CANCEL'
                                AND o.status != 'NO-ORDER'
                                AND op.product_id = '$productId'");
        
        //$sumQty = $sumItem->sum('TotalQuantity');
        $sumQty = 0;
         foreach($sumItem as $si){
            $sumQty += $si->quantity;
         }     
        return $sumQty;

    }
}
