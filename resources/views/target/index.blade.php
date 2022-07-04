@extends('layouts.master')


	@section('title') Sales Target Lists ({{date("M", mktime(0, 0, 0, $thisMonth, 10))}}, {{$thisYear}})@endsection
	@section('content')
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif

	<div class="row">
		
			<form id="form_validation" action="{{route('salesTarget.filter',[$vendor])}}" method="POST">
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
						<a href="{{route('target.index',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
					@endif
				</div>
			</form>
			<a href="{{route('sales.create_target',[$vendor])}}" class="btn bg-cyan m-t-10 m-r-10 pull-right">Create Target</a>
		
	</div>
		
	
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
			<thead>
				<tr>
					<!--<th>No</th>-->
					<th>Name</th>
					<th>VAT(PPN)</th>
					<th>Target Type</th>
					<th>Target Qty(BOX)</th>
					<th>Target Val.(IDR)</th>
					<th>Achieve. (IDR)</th>
					<th>Period</th>
					<!--
					<th>Created By</th>
					<th>Updated By</th>
					-->
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=0;?>
				@foreach($targets as $u)
					<?php $no++;?>
					<tr>
						<!--<td>{{$no}}</td>-->
						<td>
							@if($u->users)
								{{ $u->users->name }}
							@endif
						</td>
						<td>
							
							@if ($u->ppn == 1)
								<span class="badge bg-green">Y</span>
							@else
							<span class="badge bg-red">N</span>
							@endif	
							
						</td>
						<td>
							@if($u->target_type == 1)
								Qty
							@elseif($u->target_type == 2)
								Nominal
							@elseif($u->target_type == 3)
								Qty & Nominal
							@else
							-
							@endif
						</td>
						<td>
							@if ($u->target_type == 1 || $u->target_type == 3)
								{{$u->target_quantity}}
							@else
								-
							@endif
						</td>
						<td>
							@if ($u->target_type == 2 || $u->target_type == 3)
								{{number_format($u->target_values)}}
							@else
								-
							@endif
						</td>
						<td>
							
							@php
								$month= date('m', strtotime($u->period));
								$year= date('Y', strtotime($u->period));
								//dd($month);
								$order_ach = \App\Order::select('id','user_id','customer_id','created_at','status')
										->where('user_id',$u->user_id)
										->whereNotNull('customer_id')
										->whereMonth('created_at', '=', $month)
										->whereYear('created_at', '=', $year)
										->where('status','!=','CANCEL')->get();
								$total_ach = 0;
								foreach($order_ach as $p){
									$PriceTotal = App\Http\Controllers\OrderController::cekDiscountVolume($p->id);
									$total_ach += $PriceTotal;
								}
								//return $total_ach;
								echo number_format($total_ach / 1.1);
								/*if($u->ppn == 1){
									echo number_format($total_ach / 1.1);
								}
								else{
									echo number_format($total_ach);
								}*/
							@endphp
						</td>
						<td>
							
							{{date('M-Y', strtotime($u->period))}}
							<br>
							@php
								$customer = \App\Customer::select('user_id')
											->where('user_id',$u->user_id)->count();
							@endphp
							<small><b>{{$customer.' Customers'}}</b></small>
						</td>
						<!--
						<td>
							
								{{$u->created_by ? $u->created_of->name : ''}}
								<br>
								{{$u->created_by ? $u->created_at : ''}}
							
						</td>
						<td>
							
								{{$u->updated_by ? $u->updated_of->name : ''}}
								<br>
								{{$u->updated_by ? $u->updated_at : ''}}
							
						</td>
						-->
						<td>
							
							<a class="btn btn-info btn-xs" href="{{route('sales.edit_target',[$vendor,Crypt::encrypt($u->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
							
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
		
	</div>
@endsection
@section('footer-scripts')
<script type="text/javascript">
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
</script>
@endsection