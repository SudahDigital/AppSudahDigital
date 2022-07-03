@extends('customer.layouts.template')
@section('title')
Paket   
@endsection
@section('content')
<style>
    .modal-dialog-full-width {
        position:absolute;
        right:0;
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width:none !important;
    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

    .image-logo-confirm img{
            width:100px;
            height:auto;
    }

    .badge-stok{
        background-color: #FF0000;
        color: #fff;
        font-size: 11px;
        font-weight: 500;
    }

    @media only screen and (max-width:1920px){
        .image-logo-confirm img{
            width:90px;
            height:auto;
            margin-left:9.5rem;
            top:0;
        }
    }

    @media only screen and (max-width:1366px){
        .image-logo-confirm img{
            width:70px;
            height:auto;
            margin-left:10rem;
            top:0;
        }
    }

    @media only screen and (max-width:1024px){
        .image-logo-confirm img{
            width:60px;
            height:auto;
            margin-left:11rem;
            top:0;
        }
    }
    
    @media only screen and (max-width:768px){
        .image-logo-confirm img{
            width:50px;
            height:auto;
            margin-left:0rem;
        }
    }

    @media only screen and (max-width:600px){
        .image-logo-confirm img{
            width:43px;
            height:auto;
            margin-left:-1.3rem;
        }

        .login-label h3{
            font-size:20px;
        }
    }
</style>

    @if(session('sukses_peesan'))
    <div class="alert alert-success">
        {{session('sukses_pesan')}}
    </div>
    @endif
    
    
    <div style="background:#ffff">
        <img src="{{ asset('assets/image/dot-topproduct.png') }}" class="dot-content-top-right" style="" alt="dot-topproduct">
        <img src="{{ asset('assets/image/shape-content.jpg') }}" class="shape-content-bottom-right" style="" alt="shape-content">
        <img src="{{ asset('assets/image/dot-bottom-left-content.jpg') }}" class="dot-content-bottom-left" style="" alt="dot-bottom-left-content">
        <div class="container mb-n4" style="">
            <div class="row">
                <div class="col-8">
                    <nav aria-label="breadcrumb" class="" >
                        <ol class="breadcrumb pt-4 mt-3" style="background-color:#fff !important;">
                            <h2 class="breadcrumb-item">Our</h2>
                            <h2 class="breadcrumb-item active" aria-current="page">Package</h2>
                        </ol>
                    </nav>
                </div>
                <!--
                <div class="col-4 ">
                    <div id="dropfilter" class="dropfilter dropdown pt-4 mt-3 float-right">
                        <button class="btn filter_category" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Filter</b>
                            <i class="fas fa-caret-down fa-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="height: auto;max-height: 200px;overflow-x: hidden; border-bottom-left-radius:1rem;border-bottom-right-radius:1rem;">
                            <a class="dropdown-item" href="{{ url('/') }}" style="color: #1A4066;"><b>Semua Produk</b></a>
                            @foreach($categories as $key => $value)
                                <a class="dropdown-item" href="{{route('home_customer', [$vendor,'cat'=>$value->slug] )}}" style="color: #000;"><b>{{$value->name}}</b></a>
                            @endforeach
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
        
        
        <div class="container list-product" style="">
            <div class="row mt-0">
                <div class="col-md-12 mt-4">
                    <div class="row section_content">
                    @foreach($product as $key => $value)
                        <div id="product_list"  class="col-6 col-md-4 d-flex mx-0" style="z-index: 1">
                            <div class="card mx-auto d-flex item_product">
                                <a class="" data-toggle="modal" href="#modalGroup{{$value->id}}">
                                    <img style="" src="{{ asset('storage/'.(($value->group_image!='') ? $value->group_image : 'no_image_availabl.png').'') }}" class="img-fluid h-100 w-100 img-responsive" alt="...">
                                </a>
                                <div class="card-body h-100" style="background-color:#1A4066;">
                                    <a class="" data-toggle="modal" href="#modalGroup{{$value->id}}">
                                        <div class="px-auto py-2 text-center" style="width: 100%;">
                                            <p class="product-price-header mb-0" style="float:none;">
                                                {{$value->display_name}}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal -->
                        <div class="modal fade modal-paket" id="modalGroup{{$value->id}}" 
                            tabindex="-1" role="dialog" aria-hidden="true"  style="overflow-y: auto !important;">
                            <div class="modal-dialog modal-dialog-paket modal-lg" role="document">
                                <div class="modal-content modal-content-paket">
                                    <div class="modal-body pb-0">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <!--paket-->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm mt-4 margin_paket_pop_head-1 pl-5">
                                                    <h5 class="head_pop_prod mb-3" style="">Paket {{$value->display_name}}</h5>
                                                </div>
                                                <div class="col-sm mt-4 pr-5 margin_paket_pop_head-2">
                                                    <div class="input-group mb-n2 justify-content-end">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" style="height:30px"><i class="fa fa-search"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="src_pkt{{$value->id}}" onkeyup="search_paket('{{$value->id}}')" placeholder="Cari produk paket" style="height:30px;outline:none;"/>
                                                        <input type="hidden" class="form-control" id="src_groupcat{{$value->id}}" value="{{$value->group_cat}}" />
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="container list-product" style="">
                                            <div class="row mt-0">
                                                <div class="col-md-12 mt-4 px-auto menu-wrapper_pop margin_paket_pop px-5">
                                                    <div id="paket_cari{{$value->id}}" class="row section_content flex-row flex-nowrap menu_pop" style="overflow-x:auto;overflow-y:hidden;z-index:2222; ">
                                                        @if($value->group_cat == NULL)
                                                            @foreach($value->item_active as $p_group)
                                                                <div id="product_list"  class="col-6 col-md-4 mx-0 d-flex item_pop" style="">
                                                                    <div class="card mx-auto  item_product_pop ">
                                                                        @php
                                                                            if($item){
                                                                                $qty_on_paket = \App\Order_paket_temp::where('order_id',$item->id)
                                                                                            ->where('product_id',$p_group->id)
                                                                                            //->where('paket_id',$paket_id->id)
                                                                                            ->where('group_id',$value->id)
                                                                                            ->whereNull('bonus_cat')->first();
                                                                                if($qty_on_paket){
                                                                                    $harga_on_paket = $qty_on_paket->price_item * $qty_on_paket->quantity; 
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        
                                                                        @if(($item) && ($qty_on_paket != NULL))
                                                                            <input type="hidden" id="orderid_delete_pkt{{$p_group->id}}_{{$value->id}}" value="{{$item->id}}">
                                                                        @else
                                                                            <input type="hidden" id="orderid_delete_pkt{{$p_group->id}}_{{$value->id}}" value="">
                                                                        @endif
                                                                        <div class="round">
                                                                            <input type="checkbox" onclick="delete_pkt('{{$p_group->id}}','{{$value->id}}')" id="checkbox_pkt{{$p_group->id}}_{{$value->id}}" {{($item && $qty_on_paket != NULL && $qty_on_paket->quantity > 0) ? 'checked' : 'checked disabled'}}/>
                                                                            <label for="checkbox_pkt{{$p_group->id}}_{{$value->id}}"></label>
                                                                        </div>
                                                                        <a>
                                                                            <img style="" src="{{ asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'') }}" class="img-fluid h-100 w-100 img-responsive" alt="...">
                                                                        </a>
                                                                        
                                                                        <div class="card-body crd-body-pkt d-flex flex-column mt-n3" style="">
                                                                            @if($stock_status->stock_status == 'ON')
                                                                                @php
                                                                                    $stockValuePaket = App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//total order
                                                                                    $orderFinish = App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                                                                @endphp
                                                                                <span class="badge badge-stok py-1" >
                                                                                    @if(session()->has('ses_order'))
                                                                                        <?php $store_name = session()->get('ses_order');?>
                                                                                        @if($store_name->customer_id != null)
                                                                                            <input type="hidden" id="ses_order" value="{{$store_name->customer_id}}">
                                                                                            <?php
                                                                                                $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                                [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                            ?>
                                                                                            @if($target != null)
                                                                                                @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                    @foreach ($target->product_target as $pt)
                                                                                                        <span class="float-left">
                                                                                                            <?php/*
                                                                                                                $leftT = $pt->quantityValues - $totalQty;
                                                                                                                $unsignedT = abs($leftT);
                                                                                                                if($leftT < 0){
                                                                                                                    $leftTr = '+'.$unsignedT;
                                                                                                                }else{
                                                                                                                    $leftTr = $leftT;
                                                                                                                }*/
                                                                                                            ?>
                                                                                                            {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                        </span>
                                                                                                    @endforeach
                                                                                                    <span class="float-right">
                                                                                                        STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                                    </span>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="float-left">
                                                                                                    STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                                </span>
                                                                                            @endif
                                                                                        @else
                                                                                            <span class="float-left">
                                                                                                STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                            </span>
                                                                                            <input type="hidden" id="ses_order" value="">
                                                                                        @endif
                                                                                    @endif
                                                                                </span>
                                                                            @else
                                                                                @if(session()->has('ses_order'))
                                                                                    <?php $store_name = session()->get('ses_order');?>
                                                                                    @if($store_name->customer_id != null)
                                                                                        <?php
                                                                                            $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                            [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                        ?>
                                                                                        @if($target != null)
                                                                                            @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                <span class="badge badge-stok py-1" >
                                                                                                    @foreach ($target->product_target as $pt)
                                                                                                        
                                                                                                        <span class="float-left">
                                                                                                            <?php
                                                                                                               /* $leftT = $pt->quantityValues - $totalQty;
                                                                                                                $unsignedT = abs($leftT);
                                                                                                                if($leftT < 0){
                                                                                                                    $leftTr = '+'.$unsignedT;
                                                                                                                }else{
                                                                                                                    $leftTr = $leftT;
                                                                                                                }*/
                                                                                                            ?>
                                                                                                            {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                        </span>
                                                                                                    @endforeach
                                                                                                </span>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                            @if(session()->has('ses_order') && $store_name->customer_id != null)
                                                                                @php
                                                                                    $pktPrice = App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                                                                                @endphp
                                                                            @else
                                                                                @php
                                                                                    $pktPrice = $p_group->price;
                                                                                @endphp
                                                                            @endif
                                                                            <div class="float-left px-1 py-2" style="width: 100%;">
                                                                                <p class="product-price-header_pop mb-0" style="">
                                                                                    {{$p_group->Product_name}}
                                                                                </p>
                                                                            </div>
                                                                            <div class="float-left px-1 pb-0" style="">
                                                                                
                                                                                <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_pkt{{$p_group->id}}_{{$value->id}}" style="">Rp.  {{ $item && $qty_on_paket != NULL ?  number_format($harga_on_paket, 0, ',', '.') : number_format($pktPrice, 0, ',', '.') }},-</p>
                                                                            </div>
                                                                            <div class="justify-content-center input_item_pop mt-auto px-3">
                                                                                <input type="hidden" id="jumlah_val_pkt{{$p_group->id}}_{{$value->id}}" name="" value="{{$item && $qty_on_paket != NULL ? "$qty_on_paket->quantity" : '0'}}">
                                                                                <input type="hidden" id="jumlah_pkt{{$p_group->id}}_{{$value->id}}" name="quantity_pkt" value="{{$item && $qty_on_paket != NULL ? "$qty_on_paket->quantity" : '0'}}">
                                                                                <input type="hidden" id="harga_pkt{{$p_group->id}}_{{$value->id}}" name="price_pkt" value="{{$pktPrice}}">
                                                                                <input type="hidden" id="product_pkt{{$p_group->id}}_{{$value->id}}" name="Product_id_pkt" value="{{$p_group->id}}">
                                                                                
                                                                                <div class="input-group mb-0 mx-auto">
                                                                                    <button class="input-group-text button_minus_pkt" id="button_minus_pkt{{$p_group->id}}_{{$value->id}}" 
                                                                                            style="cursor: pointer;
                                                                                            outline:none;
                                                                                            border:none;
                                                                                            border-top-right-radius:0;
                                                                                            border-bottom-right-radius:0;
                                                                                            border-right-style:none;
                                                                                            font-weight:bold;
                                                                                            padding-right:0;
                                                                                            height:25px" onclick="button_minus_pkt('{{$p_group->id}}','{{$value->id}}')" 
                                                                                            onMouseOver="this.style.color='#495057'" >-</button>
                                                                                            <input type="number" id="show_pkt{{$p_group->id}}_{{$value->id}}" onkeyup="input_qty_pkt('{{$p_group->id}}','{{$value->id}}')" class="form-control show_pkt" value="{{$item && $qty_on_paket !== NULL ? $qty_on_paket->quantity : '0'}}" 
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
                                                                                            height:25px" onclick="button_plus_pkt('{{$p_group->id}}','{{$value->id}}')">+</button> 
                                                                                </div>
                                                                                <button class="btn bt-add-paket btn-block button_add_to_cart respon mt-1" onclick="add_tocart_pkt('{{$p_group->id}}','{{$value->id}}')" >Simpan</button> 
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            @endforeach
                                                        @else
                                                        @foreach($all_product as $p_group)
                                                            <div id="product_list"  class="col-6 col-md-4 mx-0 d-flex item_pop" style="">
                                                                <div class="card mx-auto  item_product_pop ">
                                                                    @php
                                                                        if($item){
                                                                            $qty_on_paket = \App\Order_paket_temp::where('order_id',$item->id)
                                                                                        ->where('product_id',$p_group->id)
                                                                                        //->where('paket_id',$paket_id->id)
                                                                                        ->where('group_id',$value->id)
                                                                                        ->whereNull('bonus_cat')->first();
                                                                            if($qty_on_paket){
                                                                                $harga_on_paket = $qty_on_paket->price_item * $qty_on_paket->quantity; 
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    
                                                                    @if(($item) && ($qty_on_paket != NULL))
                                                                        <input type="hidden" id="orderid_delete_pkt{{$p_group->id}}_{{$value->id}}" value="{{$item->id}}">
                                                                    @else
                                                                        <input type="hidden" id="orderid_delete_pkt{{$p_group->id}}_{{$value->id}}" value="">
                                                                    @endif
                                                                    <div class="round">
                                                                        <input type="checkbox" onclick="delete_pkt('{{$p_group->id}}','{{$value->id}}')" id="checkbox_pkt{{$p_group->id}}_{{$value->id}}" {{($item && $qty_on_paket != NULL && $qty_on_paket->quantity > 0) ? 'checked' : 'checked disabled'}}/>
                                                                        <label for="checkbox_pkt{{$p_group->id}}_{{$value->id}}"></label>
                                                                    </div>
                                                                    <a>
                                                                        <img style="" src="{{ asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'') }}" class="img-fluid h-100 w-100 img-responsive" alt="...">
                                                                    </a>
                                                                    
                                                                    <div class="card-body crd-body-pkt d-flex flex-column mt-n3" style="">
                                                                        @if($stock_status->stock_status == 'ON')
                                                                            @php
                                                                                $stockValuePaket = App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//order product
                                                                                $orderFinish = App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                                                            @endphp
                                                                            <span class="badge badge-stok py-1" >
                                                                                @if(session()->has('ses_order'))
                                                                                    <?php $store_name = session()->get('ses_order');?>
                                                                                    @if($store_name->customer_id != null)
                                                                                        <?php
                                                                                            $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                            [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                        ?>
                                                                                        @if($target != null)
                                                                                            @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                @foreach ($target->product_target as $pt)
                                                                                                    <span class="float-left">
                                                                                                        <?php
                                                                                                            /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                            $unsignedT = abs($leftT);
                                                                                                            if($leftT < 0){
                                                                                                                $leftTr = '+'.$unsignedT;
                                                                                                            }else{
                                                                                                                $leftTr = $leftT;
                                                                                                            }*/
                                                                                                        ?>
                                                                                                        {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                    </span>
                                                                                                @endforeach
                                                                                                <span class="float-right">
                                                                                                    STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                                </span>
                                                                                            @endif
                                                                                        @else
                                                                                            <span class="float-left">
                                                                                                STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                            </span>
                                                                                        @endif
                                                                                    @else
                                                                                        <span class="float-left">
                                                                                            STOK&nbsp; : <span class="stok_pkt{{$p_group->id}}" id="stok_pkt{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValuePaket > 0 ? ($p_group->stock+$orderFinish) - $stockValuePaket : 0}}</span>
                                                                                        </span>
                                                                                    @endif
                                                                                @endif
                                                                            </span>
                                                                        @else
                                                                            @if(session()->has('ses_order'))
                                                                                <?php $store_name = session()->get('ses_order');?>
                                                                                @if($store_name->customer_id != null)
                                                                                    <?php
                                                                                        $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                        [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                    ?>
                                                                                    @if($target != null)
                                                                                        @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                            <span class="badge badge-stok py-1" >
                                                                                                @foreach ($target->product_target as $pt)
                                                                                                    
                                                                                                    <span class="float-left">
                                                                                                        <?php
                                                                                                            /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                            $unsignedT = abs($leftT);
                                                                                                            if($leftT < 0){
                                                                                                                $leftTr = '+'.$unsignedT;
                                                                                                            }else{
                                                                                                                $leftTr = $leftT;
                                                                                                            }*/
                                                                                                        ?>
                                                                                                        {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                    </span>
                                                                                                @endforeach
                                                                                            </span>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        @if(session()->has('ses_order') && $store_name->customer_id != null)
                                                                            @php
                                                                                $pktPrice = App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                                                                            @endphp
                                                                        @else
                                                                            @php
                                                                                $pktPrice = $p_group->price;
                                                                            @endphp
                                                                        @endif
                                                                        <div class="float-left px-1 py-2" style="width: 100%;">
                                                                            <p class="product-price-header_pop mb-0" style="">
                                                                                {{$p_group->Product_name}}
                                                                            </p>
                                                                        </div>
                                                                        <div class="float-left px-1 pb-0" style="">
                                                                            
                                                                            <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_pkt{{$p_group->id}}_{{$value->id}}" style="">Rp.  {{ $item && $qty_on_paket != NULL ?  number_format($harga_on_paket, 0, ',', '.') : number_format($pktPrice, 0, ',', '.') }},-</p>
                                                                        </div>
                                                                        <div class="justify-content-center input_item_pop mt-auto px-3">
                                                                            <input type="hidden" id="jumlah_val_pkt{{$p_group->id}}_{{$value->id}}" name="" value="{{$item && $qty_on_paket != NULL ? "$qty_on_paket->quantity" : '0'}}">
                                                                            <input type="hidden" id="jumlah_pkt{{$p_group->id}}_{{$value->id}}" name="quantity_pkt" value="{{$item && $qty_on_paket != NULL ? "$qty_on_paket->quantity" : '0'}}">
                                                                            <input type="hidden" id="harga_pkt{{$p_group->id}}_{{$value->id}}" name="price_pkt" value="{{$pktPrice}}">
                                                                            <input type="hidden" id="product_pkt{{$p_group->id}}_{{$value->id}}" name="Product_id_pkt" value="{{$p_group->id}}">
                                                                            
                                                                            <div class="input-group mb-0 mx-auto">
                                                                                <button class="input-group-text button_minus_pkt" id="button_minus_pkt{{$p_group->id}}_{{$value->id}}" 
                                                                                        style="cursor: pointer;
                                                                                        outline:none;
                                                                                        border:none;
                                                                                        border-top-right-radius:0;
                                                                                        border-bottom-right-radius:0;
                                                                                        border-right-style:none;
                                                                                        font-weight:bold;
                                                                                        padding-right:0;
                                                                                        height:25px" onclick="button_minus_pkt('{{$p_group->id}}','{{$value->id}}')" 
                                                                                        onMouseOver="this.style.color='#495057'" >-</button>
                                                                                        <input type="number" id="show_pkt{{$p_group->id}}_{{$value->id}}" onkeyup="input_qty_pkt('{{$p_group->id}}','{{$value->id}}')" class="form-control show_pkt" value="{{$item && $qty_on_paket !== NULL ? $qty_on_paket->quantity : '0'}}" 
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
                                                                                        height:25px" onclick="button_plus_pkt('{{$p_group->id}}','{{$value->id}}')">+</button> 
                                                                            </div>
                                                                            <button class="btn bt-add-paket btn-block button_add_to_cart respon mt-1" onclick="add_tocart_pkt('{{$p_group->id}}','{{$value->id}}')" >Simpan</button> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="paddles d-none d-md-block d-md-none">
                                                    @if($value->group_cat == NULL)
                                                        @if($value->item_active->count() > 3)
                                                        <button class="left-paddle_pop paddle_pop">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop paddle_pop" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @else
                                                        @if(count($all_product) > 3)
                                                        <button class="left-paddle_pop paddle_pop">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop paddle_pop" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                </div>
                            
                                                <div class="paddles d-md-none">
                                                    @if($value->group_cat == NULL)
                                                        @if($value->item_active->count() > 2)
                                                        <button class="left-paddle_pop paddle_pop">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop paddle_pop" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @else
                                                        @if(count($all_product) > 2)
                                                        <button class="left-paddle_pop paddle_pop">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop paddle_pop" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!--bonus-->
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm mt-4 margin_paket_pop_head-1 pl-5">
                                                    <h5 class="head_pop_prod mb-3" style="">+ Bonus</h5>
                                                </div>
                                                <div class="col-sm mt-4 pr-5 margin_paket_pop_head-2">
                                                    <div class="input-group mb-n2 justify-content-end">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" style="height:30px"><i class="fa fa-search"></i></div>
                                                        </div>
                                                        <input type="text" class="form-control" id="src_bns{{$value->id}}" onkeyup="search_bonus('{{$value->id}}')" placeholder="Cari produk bonus" style="height:30px;outline:none;"/>
                                                        <input type="hidden" class="form-control" id="src_groupcatbns{{$value->id}}" value="{{$value->group_cat}}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="container" style="">
                                            <div class="row mt-0">
                                                <div class="col-md-12 mt-4 margin_paket_bonus menu-wrapper_pop_bonus px-5">
                                                    <div id="bonus_cari{{$value->id}}" class="row section_content flex-row flex-nowrap menu_pop_bonus" style="overflow-x:auto;overflow-y:hidden;z-index:2222; ">
                                                        @if($value->group_cat == NULL)
                                                            @foreach($value->item_active as $p_group)
                                                                <div class="col-12 col-md-6 d-flex item_pop_bonus pb-4" style="">
                                                                    <div class="card card_margin_bonus" style="border-radius: 20px;">
                                                                        <div class="card-horizontal py-0">
                                                                            @php
                                                                                if($item){
                                                                                    $qty_on_bonus = \App\Order_paket_temp::where('order_id',$item->id)
                                                                                                ->where('product_id',$p_group->id)
                                                                                               //->where('paket_id',$paket_id->id)
                                                                                                ->where('group_id',$value->id)
                                                                                                ->whereNotNull('bonus_cat')->first();
                                                                                    if($qty_on_bonus){
                                                                                        $harga_on_bonus = $qty_on_bonus->price_item * $qty_on_bonus->quantity; 
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            @if(session()->has('ses_order'))
                                                                                <?php $store_name = session()->get('ses_order');?>
                                                                                @if($store_name->customer_id != null)
                                                                                    @php
                                                                                        $bnsPrice = App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $bnsPrice = $p_group->price;
                                                                                    @endphp
                                                                                @endif
                                                                            @else
                                                                                 @php
                                                                                    $bnsPrice = $p_group->price;
                                                                                @endphp
                                                                            @endif

                                                                            @if(($item) && ($qty_on_bonus != NULL))
                                                                                <input type="hidden" id="orderid_delete_bns{{$p_group->id}}_{{$value->id}}" value="{{$item->id}}">
                                                                            @else
                                                                                <input type="hidden" id="orderid_delete_bns{{$p_group->id}}_{{$value->id}}" value="">
                                                                            @endif
                                                                            <div class="round_bns">
                                                                                <input type="checkbox" onclick="delete_bns('{{$p_group->id}}','{{$value->id}}')" id="checkbox_bns{{$p_group->id}}_{{$value->id}}" {{($item && $qty_on_bonus != NULL && $qty_on_bonus->quantity > 0) ? 'checked' : 'checked disabled'}} style="display:none;"/>
                                                                                <label for="checkbox_bns{{$p_group->id}}_{{$value->id}}"></label>
                                                                            </div>
                                                                            <a>
                                                                                <img src="{{ asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'') }}" class="img-fluid img-responsive" alt="..." style="">
                                                                            </a>
                                                                            
                                                                            <div class="card-body d-flex flex-column ml-n4" style="">
                                                                                
                                                                                <div class="float-left pl-0 py-0" style="width: 100%;">
                                                                                    <p class="product-price-header_pop mb-0" style="">
                                                                                        {{$p_group->Product_name}}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="float-left pl-0 pt-1 pb-0" style="">
                                                                                    <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_bns{{$p_group->id}}_{{$value->id}}" style="">Rp. {{ $item && $qty_on_bonus != NULL ?  number_format($harga_on_bonus, 0, ',', '.') : number_format($bnsPrice, 0, ',', '.') }},-</p>
                                                                                </div>
                                                                                @if($stock_status->stock_status == 'ON')
                                                                                    @php
                                                                                        $stockValueBonus = App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//total order
                                                                                        $orderFinish = App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                                                                    @endphp
                                                                                    <span class="badge badge-stok py-1 badge-bonus mb-1" >
                                                                                        @if(session()->has('ses_order'))
                                                                                            <?php $store_name = session()->get('ses_order');?>
                                                                                            @if($store_name->customer_id != null)
                                                                                                <?php
                                                                                                    $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                                    [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                                ?>
                                                                                                @if($target != null)
                                                                                                    @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                        @foreach ($target->product_target as $pt)
                                                                                                            <span class="float-left">
                                                                                                                <?php
                                                                                                                    /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                                    $unsignedT = abs($leftT);
                                                                                                                    if($leftT < 0){
                                                                                                                        $leftTr = '+'.$unsignedT;
                                                                                                                    }else{
                                                                                                                        $leftTr = $leftT;
                                                                                                                    }*/
                                                                                                                ?>
                                                                                                                {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                            </span>
                                                                                                        @endforeach
                                                                                                        <span class="float-right">
                                                                                                            STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                        </span>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <span class="float-left">
                                                                                                        STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                    </span>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="float-left">
                                                                                                    STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                </span>    
                                                                                            @endif
                                                                                        @endif
                                                                                    </span>
                                                                                @else
                                                                                    @if(session()->has('ses_order'))
                                                                                        <?php $store_name = session()->get('ses_order');?>
                                                                                        @if($store_name->customer_id != null)
                                                                                            <?php
                                                                                                $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                                [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                            ?>
                                                                                            @if($target != null)
                                                                                                @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                    <span class="badge badge-stok py-1 badge-bonus mb-1" >
                                                                                                        @foreach ($target->product_target as $pt)
                                                                                                            
                                                                                                            <span class="float-left">
                                                                                                                    <?php
                                                                                                                    /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                                    $unsignedT = abs($leftT);
                                                                                                                    if($leftT < 0){
                                                                                                                        $leftTr = '+'.$unsignedT;
                                                                                                                    }else{
                                                                                                                        $leftTr = $leftT;
                                                                                                                    }*/
                                                                                                                ?>
                                                                                                                {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                            </span>
                                                                                                        @endforeach
                                                                                                    </span>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                                
                                                                                <div class="float-left pl-0 mt-auto">
                                                                                    <div class="input-group mb-0">
                                                                                        <input type="hidden" id="jumlah_val_bns{{$p_group->id}}_{{$value->id}}" name="" value="{{$item && $qty_on_bonus != NULL ? "$qty_on_bonus->quantity" : '0'}}">
                                                                                        <input type="hidden" id="jumlah_bns{{$p_group->id}}_{{$value->id}}" name="quantity_bns" value="{{$item && $qty_on_bonus != NULL ? "$qty_on_bonus->quantity" : '0'}}">
                                                                                        <input type="hidden" id="harga_bns{{$p_group->id}}_{{$value->id}}" name="price" value="{{$bnsPrice}}">
                                                                                        <input type="hidden" id="product_bns{{$p_group->id}}_{{$value->id}}" name="Product_id" value="{{$p_group->id}}">
                                                                                        <button class="input-group-text button_minus_bns" id="button_minus_bns{{$p_group->id}}_{{$value->id}}" 
                                                                                                style="cursor: pointer;
                                                                                                outline:none;
                                                                                                border:none;
                                                                                                border-top-right-radius:0;
                                                                                                border-bottom-right-radius:0;
                                                                                                border-right-style:none;
                                                                                                font-weight:bold;
                                                                                                padding-right:0;
                                                                                                height:25px" onclick="button_minus_bns('{{$p_group->id}}','{{$value->id}}')" 
                                                                                                onMouseOver="this.style.color='#495057'" >-</button>
                                                                                        <input type="number" id="show_bns{{$p_group->id}}_{{$value->id}}" onkeyup="input_qty_bns('{{$p_group->id}}','{{$value->id}}')" class="form-control show_pkt" value="{{$item && $qty_on_bonus !== NULL ? $qty_on_bonus->quantity : '0'}}" 
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
                                                                                                height:25px" onclick="button_plus_bns('{{$p_group->id}}','{{$value->id}}')">+</button>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="float-right mt-2">
                                                                                    <div id="product_list_bns">
                                                                                        <!--
                                                                                        <button id="disabled_button_bonus{{$p_group->id}}_{{$value->id}}" 
                                                                                            class="btn btn-block button_add_to_cart respon" 
                                                                                            onclick="add_tocart_bns('{{$p_group->id}}','{{$value->id}}')"
                                                                                            @if($stock_status->stock_status == 'ON') 
                                                                                                {{($p_group->stock+$orderFinish) - $stockValueBonus <= 0 ? 'disabled' : ''}}
                                                                                            @endif>
                                                                                            Simpan
                                                                                        </button>
                                                                                        -->
                                                                                        <button id="disabled_button_bonus{{$p_group->id}}_{{$value->id}}" 
                                                                                            class="btn btn-block button_add_to_cart respon" 
                                                                                            onclick="add_tocart_bns('{{$p_group->id}}','{{$value->id}}')">
                                                                                            Simpan
                                                                                        </button>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            @foreach($all_product as $p_group)
                                                                <div class="col-12 col-md-6 d-flex item_pop_bonus pb-4" style="">
                                                                    <div class="card card_margin_bonus" style="border-radius: 20px;">
                                                                        <div class="card-horizontal py-0">
                                                                            @php
                                                                                if($item){
                                                                                    $qty_on_bonus = \App\Order_paket_temp::where('order_id',$item->id)
                                                                                                ->where('product_id',$p_group->id)
                                                                                                //->where('paket_id',$paket_id->id)
                                                                                                ->where('group_id',$value->id)
                                                                                                ->whereNotNull('bonus_cat')->first();
                                                                                    if($qty_on_bonus){
                                                                                        $harga_on_bonus = $qty_on_bonus->price_item * $qty_on_bonus->quantity; 
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            @if(session()->has('ses_order'))
                                                                                <?php $store_name = session()->get('ses_order');?>
                                                                                @if($store_name->customer_id != null)
                                                                                    @php
                                                                                        $bnsPrice = App\Http\Controllers\CustomerKeranjangController::priceListCustomer($p_group->id,$store_name->customer_id);
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $bnsPrice = $p_group->price;
                                                                                    @endphp
                                                                                @endif
                                                                            @else
                                                                                @php
                                                                                    $bnsPrice = $p_group->price;
                                                                                @endphp
                                                                            @endif
                                                                            @if(($item) && ($qty_on_bonus != NULL))
                                                                                <input type="hidden" id="orderid_delete_bns{{$p_group->id}}_{{$value->id}}" value="{{$item->id}}">
                                                                            @else
                                                                                <input type="hidden" id="orderid_delete_bns{{$p_group->id}}_{{$value->id}}" value="">
                                                                            @endif
                                                                            <div class="round_bns">
                                                                                <input type="checkbox" onclick="delete_bns('{{$p_group->id}}','{{$value->id}}')" id="checkbox_bns{{$p_group->id}}_{{$value->id}}" {{($item && $qty_on_bonus != NULL && $qty_on_bonus->quantity > 0) ? 'checked' : 'checked disabled'}} style="display:none;"/>
                                                                                <label for="checkbox_bns{{$p_group->id}}_{{$value->id}}"></label>
                                                                            </div>
                                                                            <a>
                                                                                <img src="{{ asset('storage/'.(($p_group->image!='') ? $p_group->image : 'no_image_availabl.png').'') }}" class="img-fluid img-responsive" alt="..." style="">
                                                                            </a>
                                                                            
                                                                            <div class="card-body d-flex flex-column ml-n4" style="">
                                                                                
                                                                                <div class="float-left pl-0 py-0" style="width: 100%;">
                                                                                    <p class="product-price-header_pop mb-0" style="">
                                                                                        {{$p_group->Product_name}}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="float-left pl-0 pt-1 pb-0" style="">
                                                                                    <p style="line-height:1; bottom:0" class="product-price_pop mt-auto" id="productPrice_bns{{$p_group->id}}_{{$value->id}}" style="">Rp. {{ $item && $qty_on_bonus != NULL ?  number_format($harga_on_bonus, 0, ',', '.') : number_format($bnsPrice, 0, ',', '.') }},-</p>
                                                                                </div>
                                                                                @if($stock_status->stock_status == 'ON')
                                                                                    @php
                                                                                        $stockValueBonus = App\Http\Controllers\CustomerKeranjangController::stockInfo($p_group->id);//total order
                                                                                        $orderFinish = App\Http\Controllers\CustomerKeranjangController::TotalQtyFinish($p_group->id);
                                                                                    @endphp
                                                                                    <span class="badge badge-stok py-1 mb-1 badge-bonus" >
                                                                                        @if(session()->has('ses_order'))
                                                                                            <?php $store_name = session()->get('ses_order');?>
                                                                                            @if($store_name->customer_id != null)
                                                                                                <?php
                                                                                                    $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                                    [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                                ?>
                                                                                                @if($target != null)
                                                                                                    @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                        @foreach ($target->product_target as $pt)
                                                                                                            <span class="float-left">
                                                                                                                <?php
                                                                                                                    /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                                    $unsignedT = abs($leftT);
                                                                                                                    if($leftT < 0){
                                                                                                                        $leftTr = '+'.$unsignedT;
                                                                                                                    }else{
                                                                                                                        $leftTr = $leftT;
                                                                                                                    }*/
                                                                                                                ?>
                                                                                                                {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                            </span>
                                                                                                        @endforeach
                                                                                                        <span class="float-right">
                                                                                                            
                                                                                                            STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                        </span>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <span class="float-left">
                                                                                                        STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                    </span>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="float-left">
                                                                                                    STOK&nbsp; : <span class="stok_bns{{$p_group->id}}" id="stok_bns{{$p_group->id}}">{{($p_group->stock+$orderFinish) - $stockValueBonus > 0 ? ($p_group->stock+$orderFinish) - $stockValueBonus : 0}}</span>
                                                                                                </span>    
                                                                                            @endif
                                                                                        @endif
                                                                                    </span>
                                                                                @else
                                                                                    @if(session()->has('ses_order'))
                                                                                        <?php $store_name = session()->get('ses_order');?>
                                                                                        @if($store_name->customer_id != null)
                                                                                            <?php
                                                                                                $target = App\Http\Controllers\CustomerKeranjangController::targetItemInfo($p_group->id,$store_name->customer_id);
                                                                                                [$totalQty,$totalNml]= App\Http\Controllers\CustomerKeranjangController::achTargetItem($p_group->id,$store_name->customer_id)
                                                                                            ?>
                                                                                            @if($target != null)
                                                                                                @if($target->target_type == 1 || $target->target_type == 2 || $target->target_type == 3)
                                                                                                    <span class="badge badge-stok py-1 badge-bonus mb-1" >
                                                                                                        @foreach ($target->product_target as $pt)
                                                                                                            
                                                                                                            <span class="float-left">
                                                                                                                <?php
                                                                                                                    /*$leftT = $pt->quantityValues - $totalQty;
                                                                                                                    $unsignedT = abs($leftT);
                                                                                                                    if($leftT < 0){
                                                                                                                        $leftTr = '+'.$unsignedT;
                                                                                                                    }else{
                                                                                                                        $leftTr = $leftT;
                                                                                                                    }*/
                                                                                                                ?>
                                                                                                                {{$p_group->id == $pt->productId ? 'T : '.$pt->quantityValues .' / '. $totalQty : ''}}
                                                                                                            </span>
                                                                                                        @endforeach
                                                                                                    </span>
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                                <div class="float-left pl-0 mt-auto">
                                                                                    <div class="input-group mb-0">
                                                                                        <input type="hidden" id="jumlah_val_bns{{$p_group->id}}_{{$value->id}}" name="" value="{{$item && $qty_on_bonus != NULL ? "$qty_on_bonus->quantity" : '0'}}">
                                                                                        <input type="hidden" id="jumlah_bns{{$p_group->id}}_{{$value->id}}" name="quantity_bns" value="{{$item && $qty_on_bonus != NULL ? "$qty_on_bonus->quantity" : '0'}}">
                                                                                        <input type="hidden" id="harga_bns{{$p_group->id}}_{{$value->id}}" name="price" value="{{$bnsPrice}}">
                                                                                        <input type="hidden" id="product_bns{{$p_group->id}}_{{$value->id}}" name="Product_id" value="{{$p_group->id}}">
                                                                                        <button class="input-group-text button_minus_bns" id="button_minus_bns{{$p_group->id}}_{{$value->id}}" 
                                                                                                style="cursor: pointer;
                                                                                                outline:none;
                                                                                                border:none;
                                                                                                border-top-right-radius:0;
                                                                                                border-bottom-right-radius:0;
                                                                                                border-right-style:none;
                                                                                                font-weight:bold;
                                                                                                padding-right:0;
                                                                                                height:25px" onclick="button_minus_bns('{{$p_group->id}}','{{$value->id}}')" 
                                                                                                onMouseOver="this.style.color='#495057'" >-</button>
                                                                                        <input type="number" id="show_bns{{$p_group->id}}_{{$value->id}}" onkeyup="input_qty_bns('{{$p_group->id}}','{{$value->id}}')" class="form-control show_pkt" value="{{$item && $qty_on_bonus !== NULL ? $qty_on_bonus->quantity : '0'}}" 
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
                                                                                                height:25px" onclick="button_plus_bns('{{$p_group->id}}','{{$value->id}}')">+</button>
                                                                                    </div> 
                                                                                </div>
                                                                                <div class="float-right mt-2">
                                                                                    <div id="product_list_bns">
                                                                                        <!--
                                                                                        <button id="disabled_button_bonus{{$p_group->id}}_{{$value->id}}" 
                                                                                            class="btn btn-block button_add_to_cart respon" 
                                                                                            onclick="add_tocart_bns('{{$p_group->id}}','{{$value->id}}')" 
                                                                                            @if($stock_status->stock_status == 'ON')
                                                                                                {{($p_group->stock+$orderFinish) - $stockValueBonus <= 0 ? 'disabled' : ''}}
                                                                                            @endif>
                                                                                            Simpan
                                                                                        </button>
                                                                                        -->
                                                                                        <button id="disabled_button_bonus{{$p_group->id}}_{{$value->id}}" 
                                                                                            class="btn btn-block button_add_to_cart respon" 
                                                                                            onclick="add_tocart_bns('{{$p_group->id}}','{{$value->id}}')">
                                                                                            Simpan
                                                                                        </button>
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="paddles d-none d-md-block d-md-none">
                                                    @if($value->group_cat == NULL)
                                                        @if($value->item_active->count() > 2)
                                                        <button class="left-paddle_pop_bonus paddle_pop_bonus">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop_bonus paddle_pop_bonus" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @else
                                                        @if(count($all_product) > 2)
                                                        <button class="left-paddle_pop_bonus paddle_pop_bonus">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop_bonus paddle_pop_bonus" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>   
                                                        @endif
                                                    @endif
                                                </div>
                            
                                                <div class="paddles d-md-none">
                                                    @if($value->group_cat == NULL)
                                                        @if($value->item_active->count() > 1)
                                                        <button class="left-paddle_pop_bonus paddle_pop_bonus ">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop_bonus paddle_pop_bonus" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @else
                                                        @if(count($all_product) > 1)
                                                        <button class="left-paddle_pop_bonus paddle_pop_bonus ">
                                                            <i class="fa fa-angle-left" style="color:#878787;"></i>
                                                        </button>
                                                        <button class="right-paddle_pop_bonus paddle_pop_bonus" style="text-decoration: none;">
                                                            <i class="fa fa-angle-right" style="color:#878787;"></i>
                                                        </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer px-5">
                                        @php
                                            if($item){
                                            $pkt_total = \App\Order_paket_temp::where('order_id',$item->id)
                                            ->where('group_id',$value->id)
                                            //->where('paket_id',$paket_id->id)
                                            ->whereNull('bonus_cat')
                                            ->sum('quantity');
                                            $bns_total = \App\Order_paket_temp::where('order_id',$item->id)
                                            ->where('group_id',$value->id)
                                            //->where('paket_id',$paket_id->id)
                                            ->whereNotNull('bonus_cat')
                                            ->sum('quantity');
                                            $max_tmp = \App\Paket::where('status','=','ACTIVE')
                                                    ->where('client_id','=',$client->id)
                                                    ->whereRaw("purchase_quantity = (select max(purchase_quantity) FROM pakets WHERE client_id = '$client->id' AND purchase_quantity <= '$pkt_total')")
                                                    ->orderBy('updated_at','DESC')
                                                    ->first();
                                            if($max_tmp != NULL){
                                                    $purch_qty = $max_tmp->purchase_quantity;
                                                    $bonus_qty = $max_tmp->bonus_quantity;
                                                    $bonus_kali = $pkt_total / $purch_qty;
                                                    $desimal_kali = floor($bonus_kali) * $bonus_qty;
                                                }
                                            }
                                        @endphp
                                        <input type="hidden" id="purchase_qty{{$value->id}}" value="{{$item && $max_tmp != NULL ? $max_tmp->purchase_quantity : '' }}">
                                        <input type="hidden" id="bonus_qty{{$value->id}}" value="{{$item && $max_tmp != NULL ? $max_tmp->bonus_quantity : '' }}">
                                        <input type="hidden" id="paket_id{{$value->id}}" value="{{$item && $max_tmp != NULL ? $max_tmp->id : '' }}">
                                        <div class="mr-auto">
                                            <p class="mb-0">
                                                <span class="text-qty-paket" style="color: #000;font-weight:700;">* Total Quantity Paket&nbsp;&nbsp;: <a id="total_qty{{$value->id}}">{{$item ? $pkt_total : '0' }}</a></span>
                                            </p>
                                            <p class="mb-0">
                                                <span class="text-qty-paket" style="color: #000;font-weight:700;">* Total Quantity Bonus : <a id="total_bns{{$value->id}}">{{$item && $max_tmp != NULL ? $bns_total : '0' }}</a></span>
                                            </p>
                                            <p class="">    
                                                <span class="text-qty-paket" style="color:#1A4066;;font-weight:700;">* Jumlah Max. Bonus &nbsp;&nbsp;&nbsp;: <a id="bonus_max{{$value->id}}">{{$item && $max_tmp != NULL ? $desimal_kali : '0' }}</a></span>
                                            </p>
                                            
                                        </div>
                                        <input type="hidden" value="{{$item ? $pkt_total : '0' }}" id="total_produk{{$value->id}}">
                                        <input type="hidden" value="{{$item ? $bns_total : '0' }}" id="bns_total{{$value->id}}">
                                        <input type="hidden" value="{{$item && $max_tmp != NULL ? $desimal_kali : '0' }}" id="max_bonus{{$value->id}}">
                                        <input type="hidden" value="{{$item ? $item->id : '' }}" id="orderid_addcart{{$value->id}}">
                                        <a type="button" class="simpan-keranjang-paket btn button_add_to_cart float-right mb-2 mr-3" onclick="addcart_allpaket('{{$value->id}}')" style="padding: 10px 20px;">Simpan Ke-Keranjang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--
                    <div class="col-md-12">
                        <div class="row justify-content-center" >
                        <div class="page paging" style="margin-top:0; margin-bottom:1rem;">/*$product->appends(Request::all())->onEachSide(5)->links('vendor.pagination.bootstrap-4') */</div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>

    <!--cart--->
    <div id="accordion" class="fixed-bottom" style="border-radius:0;z-index: 1;">
        <div class="card" style="border-radius:0;">
            <a role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4" class="collapsed">
                <div id="card-cart" class="card-header pt-1" style="border-radius:0;">
                    <div class="card-cart container">
                        <table class="table borderless">
                            <tr>
                                <td align="left" id="td_itm" width="40%">
                                    <h5 style="color:#000">{{$total_item}} Item</h5>
                                </td>
                                <td align="middle"  id="td_crv" width="20%">
                                    <i class="fas fa-chevron-up" style=""></i>
                                </td>
                                <td align="right" id="td_krm-order" width="40%">
                                    <h5 class="pull-right" style="color: #000">Kirim Order&nbsp;&nbsp;<img src="{{ asset('assets/image/right-arrow.png') }}" width="20" class="my-auto" alt="right-arrow"></h5>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </a>
            
            <div id="{{$total_item > 0 ? 'collapse-4' : '' }}" class="collapse" data-parent="#accordion">
                <div id="cont-collapse" class="container">
                    <div class="card-body" id="card-detail" style="">
                        <div class="col-md-12 mt-n4" style="padding-bottom:10rem;">
                            
                            @if($total_item > 0)
                                @php
                                $groupby_paket = \DB::table('order_product')
                                                ->where('order_id',$item->id)
                                                ->whereNotNull('paket_id')
                                                ->whereNotNull('group_id')
                                                ->whereNull('bonus_cat')
                                                ->distinct()
                                                ->get(['paket_id','group_id']);
                                $krj_paket=count($groupby_paket);
                                    
                                @endphp
                                @if($krj_paket > 0)
                                <p id="p-title1" class="mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Paket</p>
                                <table class="table-detail" width="100%">
                                    <tbody>
                                    @foreach($groupby_paket as $dtl_pkt)

                                                @php
                                                    $paket_name =\App\Paket::where('id',$dtl_pkt->paket_id)
                                                                ->first();
                                                    $group_name =\App\Group::where('id',$dtl_pkt->group_id)
                                                                ->first();           
                                                @endphp
                                                <tr class="pb-0">
                                                    <td width="30%" class="img-detail-cart" valign="top" style="padding-top:3%;">
                                                        <img src="{{ asset('storage/'.(($group_name->group_image!='') ? $group_name->group_image : 'no_image_availabl.png').'') }}" 
                                                        class="image-detail"  alt="...">
                                                    </td>
                                                    <td width="60%" class="td-desc-detail" align="left" valign="top" style="padding-top:3%;">
                                                        <p style="color: #000">{{ $paket_name->display_name}},</p>
                                                        <p style="color: #000">{{ $group_name->display_name}}</p>
                                                        @php
                                                            if($item){
                                                            $pkt_total_krj = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum('quantity');
                                                            $pkt_pirce = \App\order_product::where('order_id',$item->id)
                                                            ->where('group_id',$dtl_pkt->group_id)
                                                            ->where('paket_id',$dtl_pkt->paket_id)
                                                            ->whereNull('bonus_cat')
                                                            ->sum(\DB::raw('price_item * quantity'));
                                                            }
                                                        @endphp
                                                        <h2 style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{ number_format($pkt_pirce, 0, ',', '.') }},-</h2>
                                                        
                                                        <p style="color: #000"><span>Qty</span><span class="d-inline ml-2" style="color: #153651;font-weight:900;">{{$pkt_total_krj}}</span></p>
                                                        <a onclick="open_detail_pkt('{{$item->id}}','{{$dtl_pkt->paket_id}}','{{$dtl_pkt->group_id}}')" style="cursor: pointer"><span class="badge badge-secondary">Detail Paket</span></a>

                                                    </td>
                                                    <td width="15%" align="right" valign="top" style="padding-top:3%;">
                                                        <button class="btn btn-default" onclick="delete_kr_pkt('{{$item->id}}','{{$dtl_pkt->paket_id}}','{{$dtl_pkt->group_id}}')" style="">X</button>
                                                        <input type="hidden"  id="order_id_delete_pkt" name="order_id" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="border-bottom: 1px solid #ddd;">
                                                        <div class="row">
                                                            <div class="col-3 pt-1 row-bonus-text">
                                                                <p class="" style="font-weight:700;color: #153651;font-family: Montserrat;">Bonus :</p>
                                                            </div>
                                                            <div class="col-9 row-bonus-detail">
                                                                @php
                                                                    $groupby_bns = \App\order_product::where('order_id',$item->id)
                                                                                    ->where('paket_id',$dtl_pkt->paket_id)
                                                                                    ->where('group_id',$dtl_pkt->group_id)
                                                                                    ->whereNotNull('bonus_cat')
                                                                                    ->get();
                                                                                    //dd($groupby_bns);
                                                                @endphp
                                                                @foreach($groupby_bns as $bns)
                                                                    @php
                                                                        $prd_bns =\App\product::findOrfail($bns->product_id);
                                                                    @endphp
                                                                    <p class="d-none d-md-block d-md-none mt-2 row-bonus-detail-p" style="color: #000;margin-left:-11rem;">* {{$prd_bns->Product_name}}&nbsp;<span style="color: #153651;">({{$bns->quantity}})</span></p>
                                                                    <p class="d-md-none mt-2 ml-n5" style="color: #000;font-size:3vw;">* {{ $prd_bns->Product_name}}&nbsp;<span style="color: #153651;">({{$bns->quantity}})</span></p>
                                                                    
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                @if(($krj_paket > 0) && (count($keranjang) > 0))        
                                    <p id="p-title2" class="mt-4 mb-2" style="font-weight:700;color: #153651;font-family: Montserrat;">Produk Non-Paket</p>
                                @endif
                            @endif
                            
                            <table class="table-detail" width="100%" >
                                <tbody>
                                    @foreach($keranjang as $detil)
                                    <tr>
                                        <td width="30%" class="img-detail-cart" valign="middle" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                            <img src="{{ asset('storage/'.(($detil->image!='') ? $detil->image : 'no_image_availabl.png').'') }}" 
                                            class="image-detail"  alt="...">   
                                        </td>
                                        <td width="60%" class="td-desc-detail" align="left" valign="top" style="border-bottom: 1px solid #ddd;padding-top:3%;">
                                            <p style="color: #000">{{ $detil->Product_name}}</p>
                                            <?php 
                                            if($detil->discount_item > 0){
                                                $total = $detil->price_item_promo * $detil->quantity;
                                            }else{
                                                $total=$detil->price_item * $detil->quantity;
                                            }
                                            ?>
                                            <h2 id="productPrice_kr{{$detil->product_id}}" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{ number_format($total, 0, ',', '.') }},-</h2>
                                            <table width="20%" class="tabel-quantity">
                                                <tbody>
                                                    <tr>
                                                        <td width="3%" class="" align="left" valign="middle" rowspan="2">
                                                            <p style="color: #000">Qty</p>
                                                            <input type="hidden" id="order_id{{$detil->product_id}}" name="order_id" value="{{$detil->order_id}}">
                                                            @if($detil->discount_item > 0)
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price_item_promo}}">
                                                            @else
                                                            <input type="hidden" id="harga_kr{{$detil->product_id}}" name="price" value="{{$detil->price_item}}">
                                                            @endif
                                                            <input type="hidden" id="id_detil{{$detil->product_id}}" value="{{$detil->id}}">
                                                            <input type="hidden" id="jmlkr_{{$detil->product_id}}" name="quantity" value="{{$detil->quantity}}">    
                                                        </td>
                                                        <td width="3%" class="" align="left" valign="middle" rowspan="2">
                                                            <p id="show_kr_{{$detil->product_id}}" class="d-inline" style="">{{$detil->quantity}}</p>
                                                        </td>
                                                        <td width="1%" align="center" valign="middle" bgcolor="#1A4066" style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                                            <button class="button_plus" onclick="button_plus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1%" align="middle" valign="middle" bgcolor="#1A4066" style="border-bottom-left-radius:5px;border-bottom-right-radius:5px;">
                                                            <button class="button_minus" onclick="button_minus_kr('{{$detil->product_id}}')" style="background:none; border:none; color:#ffffff;outline:none;"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="15%" align="right" valign="top" style="border-bottom: 1px solid #ddd;padding-top: 10%;">
                                            <button class="btn btn-default" onclick="delete_kr('{{$detil->product_id}}')" style="">X</button>
                                            <input type="hidden"  id="order_id_delete{{$detil->product_id}}" name="order_id" value="{{$detil->order_id}}">
                                            <input type="hidden"  id="quantity_delete{{$detil->product_id}}" name="quantity" value="{{$detil->quantity}}">
                                            @if($detil->discount_item > 0)
                                            <input type="hidden"  id="price_delete{{$detil->product_id}}" name="price" value="{{$detil->price_item_promo}}">
                                            @else
                                            <input type="hidden"  id="price_delete{{$detil->product_id}}" name="price" value="{{$detil->price_item}}">
                                            @endif
                                            <input type="hidden"  id="product_id_delete{{$detil->product_id}}"name="product_id" value="{{$detil->product_id}}">
                                            <input type="hidden" id="id_delete{{$detil->product_id}}" name="id" value="{{$detil->id}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td align="right" colspan="3">
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div id="desc_code" style="display: none;">
                                <div class="jumbotron jumbotron-fluid ml-2 py-4 mb-3">
                                    <p class="lead"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed-bottom" style="background-color:#e9eff5;">
                        <div class="container">
                            <div class="col-md-12 py-3">
                                <input type="hidden" class="form-control" id="voucher_code_hide">
                            @if($total_item > 0)
                                <!--
                                <div class="input-group mb-2 mt-2">
                                    <input type="text" class="form-control" id="voucher_code" 
                                    placeholder="Gunakan Kode Diskon" aria-describedby="basic-addon2" required style="background:#ffcc94;outline:none;">
                                    <div class="input-group-append" required>
                                        <button class="btn " type="submit" onclick="btn_code('')" style="background:#6a3137;outline:none;color:white;">Terapkan</button>
                                    </div>
                                </div>
                                
                                <div id="divchecktunai" class="custom-control custom-checkbox checkbox-lg ml-n3 mb-4 mt-n2">
                                    <input  type="checkbox" class="custom-control-input" id="checktunai" checked value="Cash">
                                    <label class="custom-control-label" for="checktunai" style="color: #000;font-weight:600;">Pembayaran Tunai</label>
                                </div>
                                -->
                                <div id="div_total" class="row float-left mt-2">
                                    <p class="mt-1" style="color: #000;font-weight:bold; ">Total Harga</p>&nbsp;
                                    @if($item!==null)
                                    <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. {{number_format($item->total_price , 0, ',', '.')}},-</h2>
                                    <input type="hidden" id="total_kr_val" value="{{$item->total_price}}">
                                        @else
                                    <h2 id="total_kr_" style="font-weight:700;color: #153651;font-family: Montserrat;">Rp. 0,-</h2>
                                    <input type="hidden" id="total_kr_val" value="0">
                                    @endif
                                </div>
                                

                                @if($item!==null)
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="{{$item->total_price}}">
                                @else
                                    <input type="hidden" name="total_pesanan" id="total_pesan_val_hide" value="0">
                                @endif
                                <input type="hidden" id="order_id_cek" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                                <div id="chk-bl-btn" class="row justify-content-end my-auto">
                                    <a type="button" id="beli_sekarang" class="btn button_add_to_pesan float-right mb-2" onclick="show_modal()" style="padding: 10px 20px; ">Pesan Sekarang <i class="fab fa-whatsapp" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i></a>
                                </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('customer.modal-pesan-wa')
    
    <!-- Modal validasi stok -->
    <div class="modal fade" id="modal_validasi" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                        <div class="text-center mb-3" style="color:#1A4066;font-weight:500">Mohon maaf...</div>
                        <hr> 
                            <div id="body_alert">
                            </div>
                            <div class="text-left mt-2 " style="color:#1A4066;font-weight:400"><small>Stok tidak mencukupi.</small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-block button_add_to_cart" data-dismiss="modal" style="">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal detail paket -->
    <div class="modal fade" id="DeatailPaket" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;">
                    <p style="font-weight:700;color: #153651;font-family: Montserrat;">Detail Paket</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class='table small'>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jml</th>
                                <th>Total Harga(Rp)</th>
                            </tr>
                        </thead>
                        <tbody id='body_detail_pkt'>
            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script>
    if($(window).width() <1450){
        $('.label-confirm').removeClass('col-md-5').addClass('col-md-7').addClass('px-4');
    }

    if ($(window).width() < 1220) {
        $('.row-bonus-detail-p').addClass('ml-n4');
        $('.label-confirm').removeClass('mb-4').removeClass('mt-4');
    }

    if ($(window).width() < 769) {
        $('.modal-dialog-paket').removeClass('modal-lg');
        $('.modal-dialog-paket').addClass('modal-dialog-full-width');
        $('.modal-content-paket').addClass('modal-content-full-width');
        $('.input_item_pop').addClass('mb-2');
        $('.label-confirm').removeClass('col-md-5').addClass('col-md-11').addClass('px-4');
    }
    if ($(window).width() < 601) {
        $('#div_total').removeClass('float-left');
        //$('#div_total').addClass('justify-content-center');
        $('#div_total').removeClass('mt-2');
        $('#div_total').addClass('mb-2');
        $('#beli_sekarang').removeClass('float-right');
        $('#beli_sekarang').addClass('btn-block');
        $('#beli_sekarang').addClass('mb-0');
        $('#chk-bl-btn').removeClass('justify-content-end');
        $('#chk-bl-btn').addClass('justify-content-center');
        $('#divchecktunai').addClass('mb-2');
        $('.dropfilter').removeClass('mt-3');
        $('#p-title1').addClass('ml-n3');
        $('#p-title2').addClass('ml-n3');
        $('.margin_paket_pop').removeClass('px-5');
        $('.margin_paket_bonus').removeClass('px-5');
        $('.margin_paket_pop_head-1').removeClass('pl-5').addClass('px-2');
        $('.margin_paket_pop_head-2').removeClass('pr-5').removeClass('mt-4').addClass('px-2');
        $('.margin_paket_pop').addClass('px-0');
        $('.margin_paket_bonus').addClass('px-0');
        $('.modal-footer').removeClass('px-5');
        $('.modal-footer').addClass('px-4');
        $('.simpan-keranjang-paket').addClass('btn-block');
        $('.simpan-keranjang-paket').removeClass('mr-3');
        $('.crd-body-pkt').removeClass('mt-n3');
        $('.input_item_pop').addClass('px-3');
        $('.input_item_pop').removeClass('mb-2');
        //$('.card_margin_bonus').addClass('ml-n2 mr-2');
        $('.menu_pop_bonus').addClass('mx-auto');
        //$('.margin_paket_pop_head').addClass('mx-0');
        $('.bt-add-paket').addClass('mb-3');
        $('.input-group').addClass('mt-n2');
        $('.row-bonus-text').removeClass('col-3');
        $('.row-bonus-text').addClass('col-4');
        $('.row-bonus-detail').removeClass('col-9');
        $('.row-bonus-detail').addClass('col-8');
        $('.badge-bonus').removeClass('mb-1').addClass('mb-3');
        
        //$('.margin_paket_pop').removeClass('col-md-12'); 
        //$('#dropfilter').addClass('mt-2');
    }
    if ($(window).width() <= 480) {
        $('#cont-collapse').removeClass('container');
        //$('.card-cart').removeClass('container');
    }

    if($(window).width()<= 411){
        $('.btn-preview-cancel').addClass('btn-block');
        $('.btn-preview-order').addClass('btn-block').addClass('mt-5')
    }
    
    $(function () {
        $('#popoverData,.popoverDokumen').popover({
            container: 'body'
        })
    });
</script>
@endsection


