@extends('layouts.master')
@section('title') Order Lists ({{date("M", mktime(0, 0, 0, $thisMonth, 10))}}, {{$thisYear}})@endsection
@section('menuHeader')
	@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
			
		<div class="dropdown pull-right m-t--20">
			<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
				<i class="material-icons">settings</i>
			</a>
			<ul class="dropdown-menu pull-right" style="width:350px;">
				<p style="text-align: center;font-weight:bold;">ORDER ATTACHMENTS SETTING</p>
				<ul class="list-group">
					<li class="list-group-item" style="border-left:none; border-right:none;">Order Attachment 
						<div class="switch pull-right">
							<label>OFF<input id="orderAttachOnOff" type="checkbox" 
								{{$orderAttach && $orderAttach->attachment == 'ON' ? 'checked' : ''}}>
								<span class="lever"></span>ON
							</label>
						</div>
					</li>
					<li class="list-group-item" style="border-left:none; border-right:none;">No Order Attachment 
						<div class="switch pull-right">
							<label>OFF<input id="noOrderAttachOnOff" type="checkbox" 
								{{$noOrderAttach && $noOrderAttach->attachment == 'ON' ? 'checked' : ''}}>
								<span class="lever"></span>ON
							</label>
						</div>
					</li>
				</ul>
			</ul>
		</div>

	@endif
@endsection

@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif


	<div class="row">
		<form id="form_validation" action="{{route('ordersFilter.filter',[$vendor])}}" method="POST">
			@csrf 
			<div class="col-md-4 m-t-5">
				<div class="form-group">
					<div class="form-line">
						<input type="text" id="dateFilterList" name="listFilter" class="date-picker form-control" 
						placeholder="Select order list period  ..." autocomplete="off" required>
					</div>
				</div>
			</div>	
			<div class="col-md-2">
				<button class="btn btn-primary waves-effect m-t-10" type="submit">Filter</button>
				@if ($periodFilter)
					<a href="{{route('orders.index',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
				@endif
			</div>
		</form>
		<div class="col-md-6">
				@if((\Auth::user()->roles == 'SUPERADMIN') || (\Auth::user()->roles == 'SALES-COUNTER'))
					
					<button  type="button" class="btn btn-success waves-effect m-t-10 pull-right" data-toggle="modal" data-target="#exportOrderModal">
						<i class="fas fa-file-excel" 
						style="font-size:16px;top:1px;"></i> Export
					</button>
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
								<form id="form_validation" method="post" action="{{route('orders.export_mapping',[$vendor]) }}">
									@csrf
									<div class="modal-body">

											<div class="form-group m-t-30">
												<select class="form-control" name="period" id="periodSelect" style="width:100%" required>
													<?php 
														$day = date('d');
													?>
													<option value=""></option>
													@if($day <= 5)
														<option value="{{date("Y-m")}}">{{date("Y-M")}}</option>
														<option value="{{date("Y-m", strtotime("-1 months"))}}">{{date("Y-M", strtotime("-1 months"))}}</option>
													@else
														<option value="{{date("Y-m")}}">{{date("Y-M")}}</option>
													@endif
												</select>
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
				@endif
		</div>
		<div class="col-md-12">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/orders' ? 'active' : ''}}">
					<a href="{{$periodFilter ? route('orders.index',[$vendor,$periodFilter]) : route('orders.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'submit' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'submit']) : route('orders.index', [$vendor,'status' =>'submit'])}}" >SUBMIT</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'process' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'process']) : route('orders.index', [$vendor,'status' =>'process'])}}">PROCESS</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'partial-shipment' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'partial-shipment']) : route('orders.index', [$vendor,'status' =>'partial-shipment'])}}">PARTIAL-SHIPMENT</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'finish' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'finish']) :route('orders.index', [$vendor,'status' =>'finish'])}}">FINISH</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'cancel' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'cancel']) :route('orders.index', [$vendor,'status' =>'cancel'])}}">CANCEL</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'no-order' ?'active' : '' }}">
					<a href="{{$periodFilter ? route('orders.index', [$vendor,$periodFilter,'status' =>'no-order']) :route('orders.index', [$vendor,'status' =>'no-order'])}}">NO-ORDER</a>
				</li>
			</ul>
		</div>
	</div>
		
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
								<a href="{{asset('storage/'.$order->po_file)}}" 
									data-sub-html="{{$order->status == 'NO-ORDER' ? 'NO-ORDER-DOC-'.$order->invoice_number : 'PO-DOC-'.$order->invoice_number}}">
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
								@if($periodFilter)
									<a href="{{route('customers.edit',[$vendor,Crypt::encrypt($order->customers->id),$order->payment_method,$periodFilter])}}">
										<span class="badge bg-pink">New Customer</span>
									</a>
								@else
									<a href="{{route('customers.edit',[$vendor,Crypt::encrypt($order->customers->id),$order->payment_method])}}">
										<span class="badge bg-pink">New Customer</span>
									</a>
								@endif
								<br>
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
						{{number_format($PriceTotal, 2, ',', '.')}}
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		$('#periodSelect').select2({
			placeholder: 'Select Period',
		});

		$(document).ready(function() {
			$('.order-table').DataTable( {
				"order": [[ 4, "desc" ]]
			});
		});

		var dp=$("#bs_datepicker_container,#dateFilterList").datepicker( {
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

		//on/off attachment submit(Order)
		$("#orderAttachOnOff").change(function() {
			if(this.checked) {
				var status = 'ON';
				$.ajax({
					url: '{{URL::to('/orders/change_status_attach')}}',
					type: 'get',
					data: {
						'status' : status,
					},
					success: function(){
						Swal.fire({
							//title: 'Apakah anda yakin ?',
							text: "Mandatory order attachments file is ON",
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok',
							showClass: {
								popup: 'animate__animated animate__fadeInDown'
							},
							hideClass: {
								popup: 'animate__animated animate__fadeOutUp'
							}
						})
					}
				});
			}
			else
			{
				var status = 'OFF';
				$.ajax({
					url: '{{URL::to('/orders/change_status_attach')}}',
					type: 'get',
					data: {
						'status' : status,
					},
					success: function(){
						Swal.fire({
							//title: 'Apakah anda yakin ?',
							text: "Mandatory order attachments file is OFF",
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok',
							showClass: {
								popup: 'animate__animated animate__fadeInDown'
							},
							hideClass: {
								popup: 'animate__animated animate__fadeOutUp'
							}
						})
					}
				});
			
			}
		});

		//on/off attachment no-order
		$("#noOrderAttachOnOff").change(function() {
			if(this.checked) {
				var status = 'ON';
				$.ajax({
					url: '{{URL::to('/orders/change_noorder_attach')}}',
					type: 'get',
					data: {
						'status' : status,
					},
					success: function(){
						Swal.fire({
							//title: 'Apakah anda yakin ?',
							text: "Mandatory no-order attachments file is ON",
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok',
							showClass: {
								popup: 'animate__animated animate__fadeInDown'
							},
							hideClass: {
								popup: 'animate__animated animate__fadeOutUp'
							}
						})
					}
				});
			}
			else
			{
				var status = 'OFF';
				$.ajax({
					url: '{{URL::to('/orders/change_noorder_attach')}}',
					type: 'get',
					data: {
						'status' : status,
					},
					success: function(){
						Swal.fire({
							//title: 'Apakah anda yakin ?',
							text: "Mandatory no-order attachments file is OFF",
							type: 'success',
							showCancelButton: false,
							confirmButtonColor: '#3085d6',
							confirmButtonText: 'Ok',
							showClass: {
								popup: 'animate__animated animate__fadeInDown'
							},
							hideClass: {
								popup: 'animate__animated animate__fadeOutUp'
							}
						})
					}
				});
			
			}
		});
		
	</script>
@endsection
