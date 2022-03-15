@extends('customer.layouts.template-nocart')
@section('title') Orders @endsection
@section('content')
<style>
    .bg-blue-grey{
        background-color: #607D8B;
    }

    #modalNotesCancel .modal-dialog {
        -webkit-transform: translate(0,-50%);
        -o-transform: translate(0,-50%);
        transform: translate(0,-50%);
        top: 50%;
        margin: 5 auto;
    }

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

    .style-badge{
        padding:7px 10px; 
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius:0;
        border-bottom-left-radius:0;
    }

    .status-style{
        padding:5px 8px;
    }

    #tbl_ tbody {
        display:block;
        height:380px;
        overflow:auto;
    }

    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }

    thead {
        
    }

    .filter-badge{
        border:0.5px solid #1A4066;
    }
    
    .bg-link{
        background:#1A4066; 
    }

    .txt-reset{
        color:#1A4066;
        font-weight:600;
        font-size: 16px;
        padding-left:0;
        margin-top:10px;
    }

    .txt_dtl{
        line-height: 0;
    }

    .detail-list-order{
        margin-bottom:10px;
    }

    .detail-list-paket_table{
        margin-bottom:10px;
    }

    .p-btn-detil{
        padding-right:10px;
    }

    .data-list-order{
        font-size:16px;
        
    }

    @media (max-width: 540px){
        .col-list-order{
            margin-left: -1.3rem;
        }

        /*tbody {
            height:320px;
        }*/

        .data-list-order{
            font-size:14px;
            
        }

        .status-order{
            font-size:8px;
        }

        .filter-badge{
            font-size: 10px;
        }

        .txt-reset{
            font-size: 12px;
        }

        .detail-list-order{
            margin-bottom:-3rem;
        }

        .bt-dtl-pesan{
            width: 100%;
        }
        
        .p-btn-detil{
            padding-left:10px;
            padding-right:10px;
        }
    }
</style>

    <div class="container" style="">
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="float-right mt-0">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li id="prf-brd" class="breadcrumb-pesan-item active mt-2" aria-current="page">Daftar Pesanan</li>&nbsp;
                        <li class="breadcrumb-pesan-item" style="color: #000!important;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center" style="">
            <div class="col-src-order col-9 px-0">
                <div class="" >
                    <div class="input-group justify-content-end" style="z-index:3;background:#fff;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="height:30px"><i class="fa fa-search"></i></div>
                        </div>
                        <input type="text" class="form-control" id="src_order" onkeyup="search_order()" placeholder="Cari Pesanan" style="height:30px;outline:none;"/>
                    </div>
                </div>
                <div class="col-badge-order col-9 px-0 mt-3" style="z-index:3;">
                    <a href="{{route('pesanan', [$vendor,'status' =>'submit'])}}" >
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/submit')  ?'bg-link text-light' : 'badge-light' }}  status-order filter-badge" style="">SUBMIT</span>
                    </a>
                    <a href="{{route('pesanan', [$vendor,'status' =>'process'])}}">
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/process')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge" >PROCESS</span>
                    </a>
                    <a href="{{route('pesanan', [$vendor,'status' =>'partial-shipment'])}}">
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/partial-shipment')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge" >PARTIAL-SHIPMENT</span>
                    </a>
                    <a href="{{route('pesanan', [$vendor,'status' =>'finish'])}}">
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/finish')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge">FINISH</span>
                    </a>
                    <a href="{{route('pesanan', [$vendor,'status' =>'cancel'])}}" class="">
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/cancel')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge">CANCEL</span>
                    </a>
                    <a href="{{route('pesanan', [$vendor,'status' =>'no-order'])}}" class="mr-2">
                        <span class="style-badge badge {{Request::is($vendor.'/pesanan/no-order')  ?'bg-link text-light' : 'badge-light' }} status-order filter-badge">NO-ORDER</span>
                    </a>
                    <a class="ml-2 txt-reset" href="{{route('pesanan',[$vendor])}}">
                        <span class="style-badge  badge  txt-reset ">Reset Filter</span>
                    </a>
                </div>
                
            </div>
        </div>
        <div class="row justify-content-center" style="">
            <div class="col-list-order col-9">
                
                <div class="row section_content" style="z-index:3;">
                    @if($order_count < 1)
                    <div class="table-responsive mt-3" style="z-index:3;">
                        <table class="table table-striped" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <!--<th width="20%">Status</th>-->
                                    <th width="60%">Order</th>
                                    <th width="40%">Toko</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="3">Data tidak ditemukan</td>
                               </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div id="tbl_" class="table-responsive mt-3" style="z-index:3;">
                            <table class="table table-striped" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <!--<th width="20%">Status</th>-->
                                        <th width="60%">Order</th>
                                        <th width="40%">Toko</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=0;?>
                                    @foreach($orders as $order)
                                    <?php $no++;?>
                                    <tr>
                                        <td width="60%" style="padding-left:10px;">
                                            <span class="data-list-order"><p class="mb-n1">Nmr. Order</p></span>
                                            <b class="data-list-order"> {{$order->invoice_number}}</b><br>
                                            <span class="data-list-order"><p class="mb-n1 mt-2">Status</p></span>
                                            @if($order->status == "SUBMIT")
                                            <span class="status-style badge bg-warning text-white status-order mb-2">{{$order->status}}</span>
                                            @elseif($order->status == "PROCESS")
                                            <span class="status-style badge bg-blue-grey text-white status-order mb-2">{{$order->status}}</span>
                                            @elseif($order->status == "PARTIAL-SHIPMENT")
                                                <span class="status-style badge bg-info text-light status-order mb-2">
                                                    {{$order->TotalDelivery <= 0 ? 'PENDING-SHIPMENT' : $order->status}}
                                                </span>
                                            @elseif($order->status == "FINISH")
                                            <span class="status-style badge bg-success text-light status-order mb-2">{{$order->status}}</span>
                                            @elseif($order->status == "CANCEL")
                                            <span class="status-style badge bg-danger text-light status-order mb-2">{{$order->status}}</span>
                                            @elseif($order->status == "NO-ORDER")
                                            <span class="status-style badge bg-dark text-light status-order mb-2">{{$order->status}}</span>
                                            @endif
                                            <!--</td>
                                            <td width="50%">-->
                                            <span class="data-list-order"><p class="mb-n1">Tanggal Order</p></span>
                                            <b class="data-list-order mb-4"> {{$order->created_at}}</b><br>
                                            @if($order->status == "FINISH")
                                                @if($order->process_time)
                                                    <span class="data-list-order"><p class="mb-n1">Tanggal Proses</p></span>
                                                    <b class="data-list-order mb-4"> {{$order->process_time}}</b><br>
                                                @endif
                                                <span class="data-list-order"><p class="mb-n1">Tanggal Finish</p></span>
                                                <b class="data-list-order mb-4"> {{$order->finish_time}}</b><br>
                                            @endif
                                            @if($order->status == "PROCESS" && $order->process_time != null)
                                                <span class="data-list-order"><p class="mb-n1">Tanggal Proses</p></span>
                                                <b class="data-list-order mb-4"> {{$order->process_time}}</b><br>
                                            @endif
                                            <!--<span class="data-list-order"><p class="mb-n1 mt-2">Total Quantity</p></span>
                                            <b class="data-list-order"> {{$order->totalQuantity}}</b><br>-->
                                            @php
                                                $PriceTotal = App\Http\Controllers\TransaksiSalesController::cekDiscountVolume($order->id);
                                            @endphp
                                            <span class="data-list-order"><p class="mb-n1 mt-2">Total Harga</p></span>
                                            <b class="data-list-order"> Rp. {{number_format($PriceTotal)}}</b><br>
                                            
                                            <a onclick="open_detail_list('{{$order->id}}')" style="cursor: pointer;">
                                                <span class="style-badge badge text-light mt-2"
                                                    style="padding:5px 10px;background:#1A4066">
                                                    <small><b>Detail Pesanan</b></small>
                                                </span>
                                            </a>
                                            
                                        </td>
                                        <td width="40%">
                                            <span class="data-list-order">{{$order->customers->store_name}}</span>
                                            @if($order->customers->status == 'NEW')<span class="badge bg-pink">New</span>@endif
                                            <?php
                                                $cekpartial = $order->products()->whereNotNull('deliveryQty')->count();
                                            ?>
                                            @if (($order->TotalPreorder > 0) && ($order->status == "PARTIAL-SHIPMENT"))
                                                <br>
                                                <span class="badge badge-warning">Outstanding : {{$order->TotalQuantity - $order->TotalDelivery}}</span><br>
                                                <span class="badge badge-info">Delivered : {{$order->TotalDelivery}}</span>
                                            @elseif(($cekpartial > 0) && ($order->status == "PARTIAL-SHIPMENT"))
                                                <br>
                                                <span class="badge badge-warning">Outstanding : {{$order->TotalQuantity - $order->TotalDelivery}}</span><br>
                                                <span class="badge badge-info">Delivered : {{$order->TotalDelivery}}</span>
                                            @endif
                                            @if($order->po_file)
                                                <br>
                                                <div class="aniimated-thumbnials list-unstyled row clearfix">
                                                    <a href="{{asset('storage/'.$order->po_file)}}" data-sub-html="PO-DOC-{{$order->invoice_number}}">
                                                        <img  src="{{asset('storage/'.$order->po_file)}}" width="50px" height="50px" style="margin-left:15px;margin-top:10px;">
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                        </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-paket" id="modalDetilList" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-paket modal-lg" role="document">
            <div class="modal-content modal-content-paket">
                <div class="modal-body pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div id="DataListOrder">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cancel notes-->
    <div class="container">
        <div class="modal fade" id="modalNotesCancel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="color:#1A4066">Pembatalan Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{route('cancel_status', [$vendor])}}" target="_BLANK" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input name="order_id" type="hidden" value="" id="OrderIdCancel">
                            <textarea class="form-control" placeholder="Berikan alasan pembatalan pesanan" name="notes_cancel"
                            style="border-top-right-radius:20px;
                                    border-top-left-radius:20px;
                                    border-bottom-right-radius:0;
                                    border-bottom-left-radius:0;"
                            id="notes_cancel" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary px-3" onclick="wa_cancel()"
                            style="border:none;
                                background-color: #1A4066 !important;
                                border-top-right-radius:15px;
                                border-top-left-radius:15px;
                                border-bottom-right-radius:0;
                                border-bottom-left-radius:0;"><b>Confirm</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     

    <script>
        if ($(window).width() < 769) {
            $('.modal-dialog-paket').removeClass('modal-lg');
            $('.modal-dialog-paket').addClass('modal-dialog-full-width');
            $('.modal-content-paket').addClass('modal-content-full-width');
        }

        if ($(window).width() <= 600) {
            //$('#prf-brd').removeClass('mt-1');
            $('.col-list-order'). removeClass('col-9').addClass('col-12');
            $('.col-src-order'). removeClass('col-9').addClass('col-12').addClass('mt-n3').removeClass('px-0');
            $('.col-badge-order'). removeClass('col-9').addClass('col-12');
            $('.txt-reset'). removeClass('ml-2');
            //$('#prf-brd').addClass('mt-2');
        } 
        if ($(window).width() <= 411) {
            $('.col-list-order').addClass('ml-n3');
            $('.btn-preview-cancel').addClass('btn-block').addClass('mt-5');
            //$('.contact-row').addClass('mt-5');
        }

        $(document).ready(function() {
            $('.aniimated-thumbnials').lightGallery({
                thumbnail: true,
                selector: 'a'
            });
        });

    </script>
    @include('sweetalert::alert')
@endsection
