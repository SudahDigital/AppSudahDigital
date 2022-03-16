@extends('layouts.master')
@section('title') Order List @endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif


<div class="row">
	<div class="col-md-10">
		<ul class="nav nav-tabs tab-col-pink pull-left" >
			<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/orders' ? 'active' : ''}}">
				<a href="{{route('orders.index',[$vendor])}}" aria-expanded="true" >All</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'submit' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'submit'])}}" >SUBMIT</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'process' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'process'])}}">PROCESS</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'partial-shipment' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'partial-shipment'])}}">PARTIAL-SHIPMENT</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'finish' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'finish'])}}">FINISH</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'cancel' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'cancel'])}}">CANCEL</a>
			</li>
			<li role="presentation" class="{{Request::get('status') == 'no-order' ?'active' : '' }}">
				<a href="{{route('orders.index', [$vendor,'status' =>'no-order'])}}">NO-ORDER</a>
			</li>
		</ul>
	</div>
	<div class="col-md-2">
		@if(\Auth::user()->roles == 'SUPERADMIN')
			
			<a class="btn btn-success pull-right" href="" data-toggle="modal" data-target="#exportOrderModal">
				<i class="fas fa-file-excel fa-0x "></i> Export
			</a>
			<div class="modal fade" id="exportOrderModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<form id="form_validation" method="post" action="{{route('orders.export_mapping',[$vendor]) }}">
							@csrf
							<div class="modal-body">
								
									<label class="form-label m-t-20">Period</label>
									<div class="form-group">
										<div class="form-line " >
											<input type="text" name="period" autocomplete="off" required
											id="bs_datepicker_container" class=" form-control" placeholder="Please choose a date...">
										</div>
									</div>
									<div class="form-group">
										<input class="form-control" type="radio" name="dataExport" id="orderSelect" value="1" required> 
										<label for="orderSelect">Order Data</label>

										<input class="form-control" type="radio" name="dataExport" id="notOrderSelect" value="0" > 
										<label for="notOrderSelect">Customer Has not Ordered</label>
									</div>
								
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-sm btn-success waves-effect">Export</button>
								<button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		@elseif(\Auth::user()->roles == 'ADMIN' || \Auth::user()->roles == 'SUPERVISOR')
		<a href="" 
			class="btn btn-success pull-right "
			data-toggle="modal" data-target="#exportSpvOrderModal">
			<i class="fas fa-file-excel fa-0x "></i> Export
		</a>
		<div class="modal fade" id="exportSpvOrderModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
					<form id="form_validation" method="post" action="{{route('orders.exportThisPeriod',[$vendor]) }}">
						@csrf
						<div class="modal-body">
								
								<div class="form-group m-t-30">
									<input class="form-control" type="radio" name="dataExport" id="orderSelect" value="1" required> 
									<label for="orderSelect">Order Data</label>

									<input class="form-control" type="radio" name="dataExport" id="notOrderSelect" value="0" > 
									<label for="notOrderSelect">Customer Has not Ordered</label>
								</div>
							
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-sm btn-success waves-effect">Export</button>
							<button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover order-table">
		<thead>
			
			<tr>
				<th width="20%">#Order</th>
				<th>Status</th>
				<th >Customer</th>
				<!--<th width="15%">Order Product</th>-->
				<th>Total quantity</th>
				<th>Order date</th>
				<th>Total price</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($orders as $order)
			
			<tr>
				<td>
					{{$order->invoice_number}}<br>
					@if($order->po_file)
						<div class="aniimated-thumbnials list-unstyled row clearfix">
							<a href="{{asset('storage/'.$order->po_file)}}" data-sub-html="PO-DOC-{{$order->invoice_number}}">
								<img class="m-l-15 m-b--50" src="{{asset('storage/'.$order->po_file)}}" width="50px" height="50px">
							</a>
						</div>
						
					@endif
				</td>
				<td>
					@if($order->status == "SUBMIT")
					<span class="badge bg-orange text-light">{{$order->status}}</span>
					@elseif($order->status == "PROCESS")
					<span class="badge bg-blue text-light">{{$order->status}}</span>
					@elseif($order->status == "FINISH")
					<span class="badge bg-green text-light">{{$order->status}}</span>
					@elseif($order->status == "CANCEL")
					<span class="badge bg-black text-light">{{$order->status}}</span>
					@elseif($order->status == "NO-ORDER")
					<span class="badge bg-red text-light">{{$order->status}}</span>
					@elseif($order->status == "PARTIAL-SHIPMENT")
					<span class="badge bg-blue-grey">{{$order->status}}</span>
					@endif
				</td>
				<td>
					
					@if(\Auth::user()->roles == 'SUPERVISOR')
						@php
							$odr = \App\Order::with('products')->with('customers')
								->where('id',$order->id)->first();
						@endphp
						@if($odr->customers->status == 'NEW')<span class="badge bg-pink">New Customer</span><br>@endif
						<small><b>Code :</b> {{$odr->customers->store_code}}</small><br>
						<small><b>Name :</b> {{$odr->customers->store_name}}</small><br>
						<small><b>Sales Rep :</b> {{$odr->users['name']}} <span class="badge {{$odr->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$odr->user_loc}}</span></small><br>
						<small><b>Payment Term :</b> 
							{{$odr->payment_method}}
						</small>	
					@else
						@if($order->customers->status == 'NEW' )
							<a href="{{route('orders.addnew_customer',[$vendor,Crypt::encrypt($order->customers->id),$order->payment_method])}}"><span class="badge bg-pink">New Customer</span></a><br>
						
						@endif
						<small><b>Code :</b> {{$order->customers->store_code}}</small><br>
						<small><b>Name :</b> {{$order->customers->store_name}}</small><br>
						<!--<small><b>Email :</b> {{$order->customers->email}}</small><br>
						<small><b>Addr :</b> {{$order->customers->address}}</small><br>
						<small><b>Phone :</b> {{$order->customers->phone}}</small><br>-->
						<small><b>Sales Rep :</b> {{$order->users['name']}} <span class="badge {{$order->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$order->user_loc}}</span></small><br>
						<small><b>Payment Term :</b> 
							{{$order->payment_method}}
						</small>
					@endif
				</td>
				<!--
				<td align="left">
					<ul style="margin-left: -25px;">
						foreach(/*$order->products as $p)
						<li><small>$p->description <b>(/*$p->pivot->quantity*/)</b></small></li>
						endforeach
					</ul>
				</td>
				-->
				<td>
					{{\Auth::user()->roles == 'SUPERVISOR' ? $odr->totalQuantity : $order->totalQuantity}} 
					{{$order->status == 'NO-ORDER' ? '' : 'DUS'}}
				</td>
				<td>{{$order->created_at}}</td>
				<td>
					@php
						$PriceTotal = App\Http\Controllers\OrderController::cekDiscountVolume($order->id);
					@endphp
					{{number_format($PriceTotal)}}
					<!--{{number_format($order->total_price)}}-->
				</td>
				
				<td>
					<a class="btn btn-info btn-xs btn-block" href="{{route('orders.detail',[$vendor,Crypt::encrypt($order->id)])}}">Details</a>&nbsp;
					@can('isSuperadmin')
						<!--<a style="margin-top:0;" class="btn btn-success btn-xs btn-block" href="route('order_edit',[$vendor,$order->id])">Edit</a>&nbsp;-->
					@endcan
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection
@section('footer-scripts')

<script>
	$(document).ready(function() {
		$('.order-table').DataTable( {
			"order": [[ 4, "desc" ]]
		});
	});

	var dp=$("#bs_datepicker_container").datepicker( {
		format: "yyyy-mm",
		startView: "months", 
		minViewMode: "months",
	});

	dp.on('changeMonth', function (e) {
            //var dateObject = $("#datepicker").val();    
            //do something here
            $(".datepicker").hide();
        });

	$(document).ready(function() {
		$('.aniimated-thumbnials').lightGallery({
			thumbnail: true,
			selector: 'a'
		});
	});
</script>
@endsection
