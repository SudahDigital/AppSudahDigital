<?php

namespace App\Http\Controllers;

use App\order_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaketController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /*public function index($vendor){   
        $id_user = \Auth::user()->id;
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        $banner = \App\Banner::where('client_id','=',$client_id)
                ->orderBy('position', 'ASC')->limit(5)->get();
        $categories = \App\Category::all();//paginate(10);
        $paket = \App\Paket::all()->first();//paginate(10);
        //$paket_id = \App\Paket::findOrfail($id);//paginate(10);
        $cat_count = $categories->count();
        $stock_status= DB::table('product_stock_status')->first();
        $all_product = \App\product::where('status','=','PUBLISH')->get();
        $product = \App\Group::with('item_active')->where('status','ACTIVE')
                    ->get();//->paginate(10);
        $count_data = $product->count();
        $keranjang = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id 
                    FROM order_product, products, orders WHERE order_product.group_id IS NULL
                    AND orders.id = order_product.order_id AND 
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");
       /*$krj_paket = DB::select("SELECT orders.user_id, orders.status,orders.customer_id, 
                    products.Product_name, products.image, products.price, products.discount,
                    products.price_promo, order_product.id, order_product.order_id,
                    order_product.product_id,order_product.quantity,order_product.group_id,order_product.bonus_cat  
                    FROM order_product, products, orders WHERE order_product.group_id IS NOT NULL
                    AND orders.id = order_product.order_id AND order_product.bonus_cat IS NULL AND
                    order_product.product_id = products.id AND orders.status = 'SUBMIT' 
                    AND orders.user_id = '$id_user' AND orders.customer_id IS NULL ");*/
        /*$item = DB::table('orders')
                    ->where('user_id','=',"$id_user")
                    ->where('orders.status','=','SUBMIT')
                    ->whereNull('orders.customer_id')
                    ->first();
        $item_name = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNotNull('orders.customer_id')
                    ->first();
        
        $total_item = DB::table('orders')
                    ->join('order_product','order_product.order_id','=','orders.id')
                    ->where('user_id','=',"$id_user")
                    ->whereNull('orders.customer_id')
                    ->distinct('order_product.product_id')
                    /*->whereNull('order_product.group_id')*/
                    //->count();
        /*$data=['total_item'=> $total_item, 
                'keranjang'=>$keranjang,
                'all_product'=>$all_product,
                'product'=>$product,
                'item'=>$item,
                'item_name'=>$item_name,
                'count_data'=>$count_data,
                'paket'=>$paket,
                'categories'=>$categories,
                'cat_count'=>$cat_count,
                'banner'=>$banner,
                //'banner_active'=>$banner_active,
                //'paket_id'=>$paket_id,
                'stock_status'=>$stock_status
            ];
       
        return view('customer.paket',$data);
             
    }*/

    public function simpan(Request $request){ 
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id;
        $client_id = \Auth::user()->client_id; 
        //$id = $request->header('User-Agent');
        $stock_status= \DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first(); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $group_id=$request->get('group_id');
        //$paket_id=$request->get('paket_id');
        $cek_promo = \App\product::findOrFail($id_product);
        
        $stockValue = \App\Http\Controllers\CustomerKeranjangController::stockInfo($id_product);
        $OrderFinish= \App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($id_product);
        $qtyOrder = $quantity;
        $readyStock = $cek_promo->stock - ($stockValue-$OrderFinish);
        if($readyStock < 0){
            $readyStock = 0 ;
        }else{
            $readyStock = $readyStock;
        }
        $left = $readyStock - $qtyOrder;
        if($left < 0){
            $preOrder = abs($left);
            $avail = $qtyOrder + $left;
        }else{
            $preOrder = 0;
            $avail = $qtyOrder;
        }
        

        $cek_order = \App\Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        if($cek_order != null){
            $order_product = \App\Order_paket_temp::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)
            ->whereNull('bonus_cat')->first();
            if($order_product != null){
                
                $qtyOrder = $quantity;
                $readyStock = $cek_promo->stock - $stockValue;
                $prevstock = $readyStock + $order_product->quantity;
                if($prevstock <= 0){
                    $preOrder = $qtyOrder;
                    $avail = 0;
                }else{
                    $avail = $prevstock;
                    $preOrder = $qtyOrder - $prevstock;
                }

                $order_product->price_item = $price;
                $order_product->price_item_promo = $price;
                $order_product->discount_item = $cek_promo->discount;
                $order_product->quantity = $quantity;

                if($stock_status->stock_status == 'ON'){
                    $order_product->available = $avail;
                    $order_product->preorder = $preOrder;
                }else{
                    $order_product->available = 0;
                    $order_product->preorder = 0;
                }

                $order_product->group_id = $group_id;
                //$order_product->paket_id = $paket_id;
                $order_product->save();
                //$cek_order->total_price += $price * $quantity;
                //$cek_order->save();
                return response()->json($cek_order->id);
                }else{
                        
                        $new_order_product = new \App\Order_paket_temp;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $price;
                        $new_order_product->price_item_promo = $price;
                        $new_order_product->discount_item = $cek_promo->discount;

                        if($stock_status->stock_status == 'ON'){
                            $new_order_product->available = $avail;
                            $new_order_product->preorder = $preOrder;
                        }else{
                            $new_order_product->available = 0;
                            $new_order_product->preorder = 0;
                        }

                        $new_order_product->quantity = $quantity;
                        $new_order_product->group_id = $group_id;
                        //$new_order_product->paket_id = $paket_id;
                        $new_order_product->save();
                        //$cek_order->total_price += $price * $quantity;
                        //$cek_order->save();
                        return response()->json($cek_order->id);
                }
        }
        else{

            $order = new \App\Order;
            $order->user_id = $id_user;
            $order->client_id = $client_id;
            //$order->quantity = $quantity;
            $order->invoice_number = 'SO-'.date('YmdHis');
            //$order->total_price = 0;
            $order->status = 'SUBMIT';
            $order->save();
            if($order->save()){
                $order_product = new \App\Order_paket_temp;
                $order_product->order_id = $order->id;
                $order_product->product_id = $request->get('Product_id');
                $order_product->price_item = $price;
                $order_product->price_item_promo = $price;
                $order_product->discount_item = $cek_promo->discount;

                if($stock_status->stock_status == 'ON'){
                    $order_product->available = $avail;
                    $order_product->preorder = $preOrder;
                }else{
                    $order_product->available = 0;
                    $order_product->preorder = 0;
                }
                $order_product->quantity = $request->get('quantity');
                $order_product->group_id = $group_id;
                //$order_product->paket_id = $paket_id;
                $order_product->save();
                return response()->json($order->id);
            }

        }
        //return response()->json(['return' => 'some data']);    
        //$order->products()->attach($request->get('Product_id'));
        
        return redirect()->back()->with('status','Product berhasil dimasukan kekeranjang');
    }

    public function simpan_bonus(Request $request){ 
        /*$ses_id = $request->header('User-Agent');
        $clientIP = \Request::getClientIp(true);
        $id = $ses_id.$clientIP;*/
        $id_user = \Auth::user()->id;
        $client_id = \Auth::user()->client_id;
        //$id = $request->header('User-Agent');
        $stock_status= \DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first(); 
        $id_product = $request->get('Product_id');
        $quantity=$request->get('quantity');
        $price=$request->get('price');
        $group_id=$request->get('group_id');
        $paket_id=$request->get('paket_id');
        $cek_promo = \App\product::findOrFail($id_product);

        $stockValue = \App\Http\Controllers\CustomerKeranjangController::stockInfo($id_product);
        $OrderFinish= \App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($id_product);
        $qtyOrder = $quantity;
        $readyStock = $cek_promo->stock - ($stockValue-$OrderFinish);
        if($readyStock < 0){
            $readyStock = 0 ;
        }else{
            $readyStock = $readyStock;
        }
        $left = $readyStock - $qtyOrder;
        if($left < 0){
            $preOrder = abs($left);
            $avail = $qtyOrder + $left;
        }else{
            $preOrder = 0;
            $avail = $qtyOrder;
        }
        

        $cek_order = \App\Order::where('user_id','=',"$id_user")
        ->where('status','=','SUBMIT')->whereNull('customer_id')->first();
        if($cek_order !== null){
            $order_product = \App\Order_paket_temp::where('order_id','=',$cek_order->id)
            ->where('product_id','=',$id_product)
            ->whereNotNull('bonus_cat')->first();
            if($order_product!== null){

                $qtyOrder = $quantity;
                $readyStock = $cek_promo->stock - $stockValue;
                $prevstock = $readyStock + $order_product->quantity;
                if($prevstock <= 0){
                    $preOrder = $qtyOrder;
                    $avail = 0;
                }else{
                    $avail = $prevstock;
                    $preOrder = $qtyOrder - $prevstock;
                }
                
                $order_product->price_item = $price;
                $order_product->price_item_promo = $price;
                $order_product->discount_item = $cek_promo->discount;

                if($stock_status->stock_status == 'ON'){
                    $order_product->available = $avail;
                    $order_product->preorder = $preOrder;
                }else{
                    $order_product->available = 0;
                    $order_product->preorder = 0;
                }
                
                $order_product->quantity = $quantity;
                $order_product->group_id = $group_id;
                $order_product->paket_id = $paket_id;
                //$order_product->bonus_cat = "BONUS";
                $order_product->save();
                //$cek_order->total_price += $price * $quantity;
                //$cek_order->save();
                return response()->json($cek_order->id);
                }else{
                        $new_order_product = new \App\Order_paket_temp;
                        $new_order_product->order_id =  $cek_order->id;
                        $new_order_product->product_id = $id_product;
                        $new_order_product->price_item = $price;
                        $new_order_product->price_item_promo = $price;
                        $new_order_product->discount_item = $cek_promo->discount;
                        
                        if($stock_status->stock_status == 'ON'){
                            $new_order_product->available = $avail;
                            $new_order_product->preorder = $preOrder;
                        }else{
                            $new_order_product->available =0;
                            $new_order_product->preorder = 0;
                        }
                        
                        $new_order_product->quantity = $quantity;
                        $new_order_product->group_id = $group_id;
                        $new_order_product->paket_id = $paket_id;
                        $new_order_product->bonus_cat = "BONUS";
                        $new_order_product->save();
                        //$cek_order->total_price += $price * $quantity;
                        //$cek_order->save();
                        return response()->json($cek_order->id);
                }
        }
    }

    public function get_total_qty(Request $request){
        $order_id = $request->get('order_id');
        $group_id = $request->get('group_id');
        //$paket_id = $request->get('paket_id');
        $paket = \App\Order_paket_temp::where('order_id',$order_id)
                ->where('group_id',$group_id)
                //->where('paket_id',$paket_id)
                ->whereNull('bonus_cat')
                ->sum('quantity');
        
        //return $total_quantity;
        return response()->json($paket);
        
    }

    public function cek_max_qty(Request $request){
        $client_id = \Auth::user()->client_id;
        $total_qty = $request->get('total_qty');
        $max_tmp = \App\Paket::where('status','=','ACTIVE')
                 ->where('client_id','=',$client_id)
                 ->whereRaw("purchase_quantity = (select max(purchase_quantity) FROM pakets WHERE client_id = $client_id AND purchase_quantity <= '$total_qty')")
                 ->orderBy('updated_at','DESC')
                 ->first();
        
        $cekData['data'] = $max_tmp;
        echo json_encode($cekData);
        exit;
    }

    public function get_total_qty_bns(Request $request){
        $order_id = $request->get('order_id');
        $group_id = $request->get('group_id');
        $paket_id = $request->get('paket_id');
        $bonus = \App\Order_paket_temp::where('order_id',$order_id)
                ->where('group_id',$group_id)
                ->where('paket_id',$paket_id)
                ->whereNotNull('bonus_cat')
                ->sum('quantity');
        
        //return $total_quantity;
        return response()->json($bonus);
        
    }

    public function delete_paket(Request $request){
        
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        //$paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $order_paket = \App\Order_paket_temp::where('order_id','=',$order_id)
                        ->where('product_id','=',$product_id)
                        //->where('paket_id','=',$paket_id)
                        ->where('group_id','=',$group_id)
                        ->whereNull('bonus_cat')->delete();
    }

    public function delete_bonus(Request $request){
        
        $order_id = $request->get('order_id');
        $product_id = $request->get('product_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $order_bonus = \App\Order_paket_temp::where('order_id','=',$order_id)
                        ->where('product_id','=',$product_id)
                        ->where('paket_id','=',$paket_id)
                        ->where('group_id','=',$group_id)
                        ->whereNotNull('bonus_cat')->delete();
    }

    public function simpan_all_tocart(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        //$inserts[];
        $paket_tmp = \App\Order_paket_temp::where('order_id',$order_id)
                    //->where('paket_id',$paket_id)
                    ->where('group_id',$group_id)
                    ->get();
        
        $dateNow = date('Y-m-d H:i:s');
        foreach($paket_tmp as $tmp){
            $cek_harga = \App\product::findOrFail($tmp->product_id);
            
            if(session()->has('ses_order')){
                $store_name = session()->get('ses_order');
                if($store_name->customer_id != null){
                    $Price = \App\Http\Controllers\CustomerKeranjangController::priceListCustomer($tmp->product_id,$store_name->customer_id);
                }else{
                    $Price = $cek_harga->price;
                }
            }else{
                $Price = $cek_harga->price;
            }
            $order_product = \App\order_product::where('order_id', $tmp->order_id)
                ->where('product_id',$tmp->product_id)
                ->where('group_id',$tmp->group_id)
                ->where('paket_id',$paket_id)
                ->where('bonus_cat',$tmp->bonus_cat)->first();
                if($order_product != null){
                    DB::table('order_product')->where('id', $order_product->id)->update([
                        'order_id' => $tmp->order_id, 
                        'product_id'=>$tmp->product_id,
                        'price_item'=>$Price,
                        'price_item_promo'=>$Price,
                        'discount_item'=>$cek_harga->discount,
                        'quantity'=>$tmp->quantity + $order_product->quantity,
                        'created_at'=>$tmp->created_at,
                        'updated_at'=>$dateNow,
                        'group_id'=>$tmp->group_id,
                        'paket_id'=>$paket_id,
                        'bonus_cat'=>$tmp->bonus_cat,
                        'available'=>$tmp->available,
                        'preorder'=>$tmp->preorder,
                    ]);
                }else{
                    DB::table('order_product')->insert([
                        'order_id' => $tmp->order_id, 
                        'product_id'=>$tmp->product_id,
                        'price_item'=>$Price,
                        'price_item_promo'=>$Price,
                        'discount_item'=>$cek_harga->discount,
                        'quantity'=>$tmp->quantity,
                        'created_at'=>$tmp->created_at,
                        'updated_at'=>$dateNow,
                        'group_id'=>$tmp->group_id,
                        'paket_id'=>$paket_id,
                        'bonus_cat'=>$tmp->bonus_cat,
                        'available'=>$tmp->available,
                        'preorder'=>$tmp->preorder,
                    ]);
                }
        }
    }

    public function delete_tmp(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        //$inserts[];
        $paket_tmp = \App\Order_paket_temp::where('order_id',$order_id)
                    //->where('paket_id',$paket_id)
                    ->where('group_id',$group_id)
                    ->delete();
        if($paket_tmp){
            $orders = \App\Order::findOrfail($order_id);
            $order_product = \App\order_product::where('order_id',$order_id)
                            ->whereNull('bonus_cat')->get();
            $total_price= 0;
            foreach($order_product as $or){
                $price = $or->price_item;
                $total_price += $price * $or->quantity;
            }
            //return $total_price;
            $orders->total_price = $total_price;
            $orders->save();
        }
    }

    public function cek_detail_pkt(Request $request){
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $cek_paket = DB::select("SELECT order_product.order_id, order_product.product_id, order_product.price_item, 
                    order_product.quantity, order_product.paket_id, order_product.group_id, order_product.bonus_cat,
                    products.Product_name FROM products,order_product WHERE order_product.product_id = products.id AND 
                    order_product.paket_id ='$paket_id' AND order_product.group_id = '$group_id' AND 
                    order_product.order_id = '$order_id' AND order_product.bonus_cat IS NULL");
        $cekData['data'] = $cek_paket;
        echo json_encode($cekData);
        exit;
    }

    public function delete_kr_pkt(Request $request){
        
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        
        $order_product = \App\order_product::where('order_id',$order_id)
                        ->where('paket_id',$paket_id)
                        ->where('group_id',$group_id)
                        ->whereNull('bonus_cat')->get();

        $total_price = 0;
        foreach($order_product as $or){
            //$price = $or->price_item;
            $total_price += ($or->price_item * $or->quantity);
        }
        $orders = \App\Order::where('id',$order_id)->first();
        $orders->total_price -= $total_price;
        $orders->save();

        $data_orderpkt = \App\order_product::where('order_id',$order_id)
                        ->where('paket_id',$paket_id)
                        ->where('group_id',$group_id)
                        ->get();
        
        $cekData['data'] = $data_orderpkt;
        echo json_encode($cekData);
        exit;
    }

    public function deleteCartPkt(Request $request){
        
        $order_id = $request->get('order_id');
        $paket_id = $request->get('paket_id');
        $group_id = $request->get('group_id');
        $order_product = \App\order_product::where('order_id',$order_id)
                        ->where('paket_id',$paket_id)
                        ->where('group_id',$group_id)
                        ->delete();
        if($order_product){
            $odr_prd = \App\order_product::where('order_id',$order_id)
                      ->count();
            if($odr_prd < 1){
                $orders = \App\Order::findOrFail($order_id);
                $orders->forceDelete();
            }
        }
        
    }

    public function search_paket(Request $request){
        
            //$output = '';
            $client_id = \Auth::user()->client_id;
            $stock_status= DB::table('product_stock_status')
                            ->where('client_id','=',$client_id)
                            ->first();
            $info_stock='';
            $dsbld_btn ='';
            $group_id = $request->get('group_id');
            if($request->get('gr_cat') != ''){
                $gr_cat = $request->get('gr_cat');
            }else{
                $gr_cat = '';
            }
            
            $order_id = $request->get('order_id');
            $query = $request->get('query');
            if($query != '' ){
                if($gr_cat != ''){
                    $product = \App\product::where('status','=','PUBLISH')
                    ->where('client_id','=',$client_id)
                    ->where('Product_name','LIKE',"%$query%")
                    //->orWhere('product_','LIKE',"%$query%")
                    ->get();
                }
                else{
                    $product = DB::select("SELECT * FROM products WHERE client_id = $client_id 
                                AND products.status = 'PUBLISH'
                                AND Product_name LIKE '%$query%' 
                                AND EXISTS (SELECT group_id,status,product_id 
                                FROM group_product WHERE group_product.product_id = products.id AND 
                                status='ACTIVE' AND group_id='$group_id')");
                }
            }
            else{
                if($gr_cat != ''){
                    $product = \App\product::where('status','=','PUBLISH')
                    ->where('client_id','=',$client_id)
                    ->get();
                }else{
                    $product = DB::select("SELECT * FROM products WHERE client_id = $client_id 
                                AND products.status = 'PUBLISH'
                                AND EXISTS 
                                (SELECT group_id,status,product_id FROM group_product WHERE 
                                group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
                }
            }
            if($product != null ){
                $total_row = count($product);
            }
            else{
                $total_row = 0;
            }
            if($total_row > 0){
                foreach($product as $p_group){
                    if($order_id != NULL){
                        $qty_on_paket = \App\Order_paket_temp::where('order_id',$order_id)
                                    ->where('product_id',$p_group->id)
                                    //->where('paket_id',$paket_id->id)
                                    ->where('group_id',$group_id)
                                    ->whereNull('bonus_cat')->first();
                        if($qty_on_paket){
                            $harga_on_paket = $qty_on_paket->price_item * $qty_on_paket->quantity; 
                        }
                    }
                    if(($order_id != NULL) && ($qty_on_paket != NULL)){
                        $c_orderid_delete =  $order_id;
                        $c_check = 'checked';
                        $c_price = $harga_on_paket;
                        $c_jml_val = $qty_on_paket->quantity;
                    }else{
                        $c_orderid_delete = '';
                        $c_check = 'checked disabled';
                        $c_price = $p_group->price;
                        $c_jml_val = 0;
                    }
                    
                    if(($stock_status->stock_status == 'ON')&&($p_group->stock == 0)){
                        $dsbld_btn .= 'disabled';
                        $info_stock = '<span class="badge badge-warning ">Sisa stok 0</span>';
                    }else{
                        $info_stock ='';
                    }

                    echo '<div id="product_list"  class="col-6 col-md-4 mx-0 d-flex item_pop" style="">
                        <div class="card mx-auto  item_product_pop ">                        
                            <input type="hidden" id="orderid_delete_pkt'.$p_group->id.'_'.$group_id.'" value="'.$c_orderid_delete.'">
                                <div class="round">
                                <input type="checkbox" onclick="delete_pkt('.$p_group->id.','.$group_id.')" id="checkbox_pkt'.$p_group->id.'_'.$group_id.'" '.$c_check.'/>
                                <label for="checkbox_pkt'.$p_group->id.'_'.$group_id.'"></label>
                            </div>
                            <a>
                                <img style="" src="'.asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'').'" class="img-fluid h-100 w-100 img-responsive" alt="...">
                            </a>
                            
                            <div class="card-body crd-body-pkt d-flex flex-column mt-n3" style="">';
                                if($stock_status->stock_status == 'ON'){
                                    $stockValuePaket = \App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//total order
                                    $orderFinish = \App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                    echo'<span class="badge badge-stok py-1">';
                                        if(session()->has('ses_order')){
                                            $store_name = session()->get('ses_order');
                                            if($store_name->customer_id != null){
                                                echo'<input type="hidden" id="ses_order" value="'.$store_name->customer_id.'">';
                                                $target = \App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                [$totalQty,$totalNml]= \App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id);
                                                
                                                if($target != null){
                                                    if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3){
                                                        foreach ($target->product_target as $pt){
                                                            echo'<span class="float-left">';
                                                                if($p_group->id == $pt->productId){
                                                                    echo 'T :'.$pt->quantityValues .' / '. $totalQty;
                                                                }
                                                            echo'</span>';
                                                        }
                                                        echo'<span class="float-right">
                                                            STOK&nbsp; : <span class="stok_pkt'.$p_group->id.'" id="stok_pkt'.$p_group->id.'">';
                                                                            if(($p_group->stock+$orderFinish) - $stockValuePaket > 0){
                                                                                echo ($p_group->stock+$orderFinish) - $stockValuePaket;
                                                                            }else{
                                                                                echo 0;
                                                                            }
                                                                        echo'</span>
                                                        </span>';
                                                    }
                                                }else{
                                                    echo'<span class="float-left">
                                                        STOK&nbsp; : <span class="stok_pkt'.$p_group->id.'" id="stok_pkt'.$p_group->id.'">';
                                                                        if(($p_group->stock+$orderFinish) - $stockValuePaket > 0){
                                                                            echo ($p_group->stock+$orderFinish) - $stockValuePaket;
                                                                        }else{
                                                                            echo 0;
                                                                        }
                                                                    echo'</span>
                                                    </span>';
                                                }
                                            }else{
                                                echo '<input type="hidden" id="ses_order" value="">
                                                <span class="float-left">
                                                        STOK&nbsp; : <span class="stok_pkt'.$p_group->id.'" id="stok_pkt'.$p_group->id.'">';
                                                                        if(($p_group->stock+$orderFinish) - $stockValuePaket > 0){
                                                                            echo ($p_group->stock+$orderFinish) - $stockValuePaket;
                                                                        }else{
                                                                            echo 0;
                                                                        }
                                                                    echo'</span>
                                                    </span>';

                                            }
                                        }
                                    echo'</span>';
                                }else{
                                    if(session()->has('ses_order')){
                                        $store_name = session()->get('ses_order');
                                        if($store_name->customer_id != null){
                                            $target = \App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                            [$totalQty,$totalNml]= \App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id);
                                            if($target != null){
                                                if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3){
                                                    echo '<span class="badge badge-stok py-1" >';
                                                        foreach ($target->product_target as $pt){
                                                            
                                                            echo'<span class="float-left">';
                                                                if($p_group->id == $pt->productId){
                                                                    echo 'T : '.$pt->quantityValues .' / '. $totalQty;
                                                                }
                                                            echo'</span>';
                                                        }
                                                    echo'</span>';
                                                }
                                            }
                                        }
                                    }
                                }
                                if(session()->has('ses_order') && $store_name->customer_id != null){
                                   $pktPrice = \App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                                }else{
                                    $pktPrice = $p_group->price;
                                }
                               
                                echo'<div class="float-left px-1 py-2" style="width: 100%;">
                                    <p class="product-price-header_pop mb-0" style="">
                                        '.$p_group->Product_name.'
                                    </p>
                                </div>
                                <div class="float-left px-1 pb-0" style="">
                                    <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_pkt'.$p_group->id.'_'.$group_id.'" style="">Rp.  '.number_format($pktPrice, 0, ',', '.') .',-</p> 
                                </div>
                                <div class="justify-content-center input_item_pop mt-auto px-3">
                                    <input type="hidden" id="jumlah_val_pkt'.$p_group->id.'_'.$group_id.'" name="" value="'.$c_jml_val.'">
                                    <input type="hidden" id="jumlah_pkt'.$p_group->id.'_'.$group_id.'" name="quantity_pkt" value="'.$c_jml_val.'">
                                    <input type="hidden" id="harga_pkt'.$p_group->id.'_'.$group_id.'" name="price_pkt" value="'.$pktPrice.'">
                                    <input type="hidden" id="product_pkt'.$p_group->id.'_'.$group_id.'" name="Product_id_pkt" value="'.$p_group->id.'">
                                    <div class="input-group mb-0 mx-auto">
                                        <button class="input-group-text button_minus_pkt" id="button_minus_pkt'.$p_group->id.'_'.$group_id.'" 
                                                style="cursor: pointer;
                                                outline:none;
                                                border:none;
                                                border-top-right-radius:0;
                                                border-bottom-right-radius:0;
                                                border-right-style:none;
                                                font-weight:bold;
                                                padding-right:0;
                                                height:25px" onclick="button_minus_pkt('.$p_group->id.','.$group_id.')" 
                                                onMouseOver="this.style.color=#495057" >-</button>
                                        <input type="number" id="show_pkt'.$p_group->id.'_'.$group_id.'" onkeyup="input_qty_pkt('.$p_group->id.','.$group_id.')" class="form-control show_pkt" value="'.$c_jml_val.'" 
                                                style="background-color:#e9ecef !important;
                                                text-align:center;
                                                border:none;
                                                padding:0;
                                                none !important;
                                                font-weight:bold;
                                                height:25px;
                                                font-size:12px;
                                                font-weight:900;">
                                        <button class="input-group-text" 
                                                style="cursor: pointer;
                                                outline:none;
                                                border:none;
                                                border-top-left-radius:0;
                                                border-bottom-left-radius:0;
                                                border-left-style:none;
                                                font-weight:bold;
                                                padding-left:0;
                                                height:25px" onclick="button_plus_pkt('.$p_group->id.','.$group_id.')">+</button> 
                                    </div>
                                    <button class="btn bt-add-paket btn-block button_add_to_cart respon mt-1" onclick="add_tocart_pkt('.$p_group->id.','.$group_id.')">Simpan</button> 
                                </div>
                            </div>
                        </div>
                        
                    </div>';
                }
                
            }
            else{
                echo'<div id="product_list"  class="col-12  mx-0 d-flex item_pop mt-4" style="">
                                <div class="card mx-auto  item_product_pop py-5">
                                    <h5 class="head_pop_prod mb-3 mx-auto" style="">Data tidak ditemukan...</h5>
                                </div>
                            </div>';
            }
    }

    public function search_bonus(Request $request){
        
        //$output = '';
        $client_id = \Auth::user()->client_id;
        $stock_status= DB::table('product_stock_status')
                    ->where('client_id','=',$client_id)
                    ->first();
        $info_stock='';
        $dsbld_btn ='';
        $group_id = $request->get('group_id');
        if($request->get('gr_cat') != NULL){
            $gr_cat = $request->get('gr_cat');
        }else{
            $gr_cat = '';
        }
        
        $order_id = $request->get('order_id');
        $query = $request->get('query');
        if($query != NULL ){
            if($gr_cat != NULL){
                $product = \App\product::where('status','=','PUBLISH')
                ->where('client_id','=',$client_id)
                ->where('Product_name','LIKE',"%$query%")
                //->orWhere('product_','LIKE',"%$query%")
                ->get();
            }
            else{
                $product = DB::select("SELECT * FROM products WHERE client_id = '$client_id' AND Product_name LIKE '%$query%' AND 
                            EXISTS (SELECT group_id,status,product_id FROM group_product WHERE 
                            group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
            }
        }
        else{
            if($gr_cat != NULL){
                $product = \App\product::where('status','=','PUBLISH')
                        ->where('client_id','=',$client_id)
                        ->get();
            }else{
                $product = DB::select("SELECT * FROM products WHERE client_id = '$client_id' AND EXISTS 
                            (SELECT group_id,status,product_id FROM group_product WHERE 
                            group_product.product_id = products.id AND status='ACTIVE' AND group_id='$group_id')");
            }
        }
        if($product != null ){
            $total_row = count($product);
        }
        else{
            $total_row = 0;
        }
        if($total_row > 0){
            foreach($product as $p_group){
                if($order_id != ''){
                    $qty_on_bonus = \App\Order_paket_temp::where('order_id',$order_id)
                                    ->where('product_id',$p_group->id)
                                   //->where('paket_id',$paket_id->id)
                                    ->where('group_id',$group_id)
                                    ->whereNotNull('bonus_cat')->first();
                        if($qty_on_bonus){
                            $harga_on_bonus = $qty_on_bonus->price_item * $qty_on_bonus->quantity; 
                        }
                }
                if(($order_id != '') && ($qty_on_bonus)){
                    $c_orderid_delete =  $order_id;
                    $c_check = 'checked';
                    $c_price = $harga_on_bonus;
                    $c_jml_val = $qty_on_bonus->quantity;
                }else{
                    $c_orderid_delete = '';
                    $c_check = 'checked disabled';
                    $c_price = $p_group->price;
                    $c_jml_val = 0;
                }
                if(($stock_status->stock_status == 'ON')&&($p_group->stock == 0)){
                    $dsbld_btn = 'disabled';
                    $info_stock = '<span class="badge badge-warning ">Sisa stok 0</span>';
                }
                if(session()->has('ses_order')){
                $store_name = session()->get('ses_order');
                    if($store_name->customer_id != null){
                        $bnsPrice = \App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                       
                    }else{
                       $bnsPrice = $p_group->price;
                    }
                }else{
                    $bnsPrice = $p_group->price;
                    
                }
                echo' 
                <div class="col-12 col-md-6 d-flex item_pop_bonus pb-4" style="">
                <div class="card card_margin_bonus" style="border-radius: 20px;">
                    <div class="card-horizontal py-0">
                        
                    <input type="hidden" id="orderid_delete_bns'.$p_group->id.'_'.$group_id.'" value="'.$c_orderid_delete.'">
                        <div class="round_bns">
                            <input type="checkbox" onclick="delete_bns('.$p_group->id.','.$group_id.')" id="checkbox_bns'.$p_group->id.'_'.$group_id.'" '.$c_check.' style="display:none;"/>
                            <label for="checkbox_bns'.$p_group->id.'_'.$group_id.'"></label>
                        </div>
                        <a>
                            <img src="'.asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'').'" class="img-fluid img-responsive" alt="..." style="">
                        </a>
                        
                        <div class="card-body d-flex flex-column ml-n4" style="">
                            
                            <div class="float-left pl-0 py-0" style="width: 100%;">
                                <p class="product-price-header_pop mb-0" style="">
                                    '.$p_group->Product_name.'
                                </p>
                            </div>
                            <div class="float-left pl-0 pt-1 pb-0" style="">
                                <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_bns'.$p_group->id.'_'.$group_id.'" style="">Rp. '.number_format($bnsPrice, 0, ',', '.') .',-</p>
                            </div>';
                            
                                if($stock_status->stock_status == 'ON'){
                                    $stockValueBonus = \App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//total order
                                    $orderFinish = \App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                   
                                    echo'<span class="badge badge-stok py-1 badge-bonus mb-1" >';
                                        if(session()->has('ses_order')){
                                            $store_name = session()->get('ses_order');
                                            if($store_name->customer_id != null){
                                                $target = \App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                [$totalQty,$totalNml]= \App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id);
                                                if($target != null){
                                                    if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3){
                                                        foreach ($target->product_target as $pt){
                                                            echo '<span class="float-left">';
                                                               if($p_group->id == $pt->productId){
                                                                    echo 'T : '.$pt->quantityValues .' / '. $totalQty;
                                                               }
                                                            echo '</span>';
                                                        }
                                                        echo '<span class="float-right">
                                                            STOK&nbsp; : <span class="stok_bns'.$p_group->id.'" id="stok_bns'.$p_group->id.'">';
                                                            if(($p_group->stock+$orderFinish) - $stockValueBonus > 0){
                                                                echo ($p_group->stock+$orderFinish) - $stockValueBonus;
                                                            }else{
                                                                echo 0 ;
                                                            }
                                                            echo'</span>
                                                        </span>';
                                                    }
                                                }else{
                                                    echo'<span class="float-left">
                                                        STOK&nbsp; : <span class="stok_bns'.$p_group->id.'" id="stok_bns'.$p_group->id.'">';
                                                            if(($p_group->stock+$orderFinish) - $stockValueBonus > 0){
                                                                echo ($p_group->stock+$orderFinish) - $stockValueBonus;
                                                            }else{
                                                                echo 0;
                                                            }
                                                        echo '</span>
                                                    </span>';
                                                }
                                            }else{
                                                echo'<span class="float-left">
                                                        STOK&nbsp; : <span class="stok_bns'.$p_group->id.'" id="stok_bns'.$p_group->id.'">';
                                                            if(($p_group->stock+$orderFinish) - $stockValueBonus > 0){
                                                                echo ($p_group->stock+$orderFinish) - $stockValueBonus;
                                                            }else{
                                                                echo 0;
                                                            }
                                                        echo '</span>
                                                    </span>';
                                            }
                                        }
                                    echo'</span>';
                                }else{
                                    if(session()->has('ses_order')){
                                        $store_name = session()->get('ses_order');
                                        if($store_name->customer_id != null){
                                            $target = \App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                            [$totalQty,$totalNml]= \App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id);
                                            if($target != null){
                                                if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3){
                                                    echo'<span class="badge badge-stok py-1 badge-bonus mb-1" >';
                                                        foreach ($target->product_target as $pt){
                                                            
                                                            echo'<span class="float-left">';
                                                                if($p_group->id == $pt->productId){
                                                                    echo 'T : '.$pt->quantityValues .' / '. $totalQty;
                                                                }
                                                            echo '</span>';
                                                        }
                                                    echo'</span>';
                                                }
                                            }
                                        }
                                    }
                                }

                            echo'<div class="float-left pl-0 mt-auto">
                                <div class="input-group mb-0">
                                    <input type="hidden" id="jumlah_val_bns'.$p_group->id.'_'.$group_id.'" name="" value="'.$c_jml_val.'">
                                    <input type="hidden" id="jumlah_bns'.$p_group->id.'_'.$group_id.'" name="quantity_bns" value="'.$c_jml_val.'">
                                    <input type="hidden" id="harga_bns'.$p_group->id.'_'.$group_id.'" name="price" value="'.$bnsPrice.'">
                                    <input type="hidden" id="product_bns'.$p_group->id.'_'.$group_id.'" name="Product_id" value="'.$p_group->id.'">
                                    <button class="input-group-text button_minus_bns" id="button_minus_bns'.$p_group->id.'_'.$group_id.'" 
                                            style="cursor: pointer;
                                            outline:none;
                                            border:none;
                                            border-top-right-radius:0;
                                            border-bottom-right-radius:0;
                                            border-right-style:none;
                                            font-weight:bold;
                                            padding-right:0;
                                            height:25px" onclick="button_minus_bns('.$p_group->id.','.$group_id.')" 
                                            onMouseOver="this.style.color=#495057" >-</button>
                                    <input type="number" id="show_bns'.$p_group->id.'_'.$group_id.'" onkeyup="input_qty_bns('.$p_group->id.','.$group_id.')" class="form-control show_pkt" value="'.$c_jml_val.'" 
                                            style="background-color:#e9ecef !important;
                                            text-align:center;
                                            border:none;
                                            padding:0;
                                            none !important;
                                            font-weight:bold;
                                            height:25px;
                                            font-size:12px;
                                            font-weight:900;">
                                    <button class="input-group-text" 
                                            style="cursor: pointer;
                                            outline:none;
                                            border:none;
                                            border-top-left-radius:0;
                                            border-bottom-left-radius:0;
                                            border-left-style:none;
                                            font-weight:bold;
                                            padding-left:0;
                                            height:25px" onclick="button_plus_bns('.$p_group->id.','.$group_id.')">+</button>
                                </div> 
                            </div>
                            <div class="float-right mt-2">
                                <!--
                                <div id="product_list_bns">
                                    <button class="btn btn-block button_add_to_cart respon"
                                    id="disabled_button_bonus'.$p_group->id.'_'.$group_id.'" 
                                    onclick="add_tocart_bns('.$p_group->id.','.$group_id.')" 
                                    style=""';
                                    if($stock_status->stock_status == 'ON') 
                                        if(($p_group->stock+$orderFinish) - $stockValueBonus <= 0){
                                            echo 'disabled';
                                        }
                                    echo'>Simpan</button>
                                </div>
                                -->
                                <div id="product_list_bns">
                                    <button class="btn btn-block button_add_to_cart respon"
                                    id="disabled_button_bonus'.$p_group->id.'_'.$group_id.'" 
                                    onclick="add_tocart_bns('.$p_group->id.','.$group_id.')" 
                                    style="">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
            
        }
        else{
            echo'<div id="product_list"  class="col-12  mx-0 d-flex item_pop mt-4" style="">
                            <div class="card mx-auto  item_product_pop py-5">
                                <h5 class="head_pop_prod mb-3 mx-auto" style="">Data tidak ditemukan...</h5>
                            </div>
                        </div>';
        }
    }

    public function cekBeforeSave_tmp(Request $request){
        $order_id = $request->get('order_id');
        
        $cek_paket = \App\Order::where('id',$order_id)->first();
        if($cek_paket){
            $cekData = 1;
        }
        else{
            $cekData = 0;
        }
        echo json_encode($cekData);
        exit;
    }
}