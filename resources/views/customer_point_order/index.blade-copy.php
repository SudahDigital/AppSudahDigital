@extends('layouts.master')
@section('title')Points Order Lists {{$period != null ? $period_name : '(Current period has not been created)'}}@endsection
@section('content')
@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif

@if(session('error'))
	<div class="alert alert-danger">
		{{session('error')}}
	</div>
@endif

<div class="row">
	<form id="form_validation" action="{{route('periodpoint.postfilter',[$vendor])}}" method="POST">
		@csrf 
		
		<div class="col-sm-6 m-t-10">
			<div class="form-group">
				<select name="period"  id="period_list" 
					class="form-control" style="width:100%;" required>
					<option></option>
					@foreach($period_list as $pl)
						<option value="{{$pl->id}}" {{(\Route::currentRouteName() == 'periodpoint.getfilter') && ($period == $pl->id) ? 'selected' : ''}}>
							{{$pl->name}}
						</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6">
			<button class="btn btn-primary waves-effect m-t-10" type="submit">Filter</button>
			@if (\Route::currentRouteName() == 'periodpoint.getfilter')
				<a href="{{route('customers_points.index',[$vendor])}}" class="btn btn-danger waves-effect m-t-10">Reset</a>
			@endif
			<!--
			<a class="btn waves-effect btn-success pull-right m-t-10"
				data-toggle="modal" data-target="#ExportModal">
				<i class="fas fa-file-excel fa-1x"></i> 
			</a>
			-->
		</div>
	</form>
</div>

<!--tabs-->
<ul class="nav nav-tabs tab-nav-right" role="tablist">
	<li role="presentation" class="active"><a href="#havePoints" data-toggle="tab">CUSTOMERS HAVE POINTS</a></li>
	<li role="presentation"><a href="#doesntHavePoints" data-toggle="tab">CUSTOMERS DOESN'T HAVE POINTS</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade in active p-t-10" id="havePoints">
		<div style="position: absolute; margin-top: -8px;">
		@if (\Route::currentRouteName() == 'periodpoint.getfilter')
			<a href="{{route('PointFilterPeriod.Export',[$vendor, $period]) }}" 
				class="btn btn-success  waves-effect  m-t-10">
				<i class="fas fa-file-excel fa-0x m-t--10"></i> Export
			</a>
		@else
			<a href="{{$period ? route('PointThisPeriod.Export',[$vendor]) : '#' }}" 
				class="btn btn-success  waves-effect m-t-10 {{$period ? '' : 'disabled'}}">
				<i class="fas fa-file-excel fa-0x m-t--10"></i> Export
			</a>
		@endif
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped  table-hover table-point">
				<thead>
					<tr><th>Customer</th>
						<th>Sales</th>
						<th>Starting <!--Points--></th>
						<th><!--Points--> In Periods</th>
						<th>(+) Potential <!--Points--></th>
						<th><!--Points--> Claim</th>
						<th>Total Points</th>
					</tr>
				</thead>
				<tbody>
					@if($period != null)
						@foreach($customers as $c)
							@php
								[$rest,$totalPotency] = App\Http\Controllers\CustomerPointOrderController::starting_point($period_start,$c->csid);
								$claim = App\Http\Controllers\CustomerPointOrderController::pointsClaim($period_start,$c->csid);
								$pointPartial = App\Http\Controllers\CustomerPointOrderController::pointPartial($period_start,$c->csid);
								$pointPrevPartial = App\Http\Controllers\CustomerPointOrderController::pointPrevPartial($period_start,$c->csid);
							@endphp
							<tr>
								<td>
									{{$c->store_name ? "$c->store_code - $c->store_name" : '-'}}
								</td>
								<td>
									{{$c->sales_name}}
								</td>
								<td>
									{{number_format($rest,2)}}
								</td>
								<td>
									{{number_format((($c->grand_total-$pointPrevPartial) + $pointPartial + $claim),2)}}
								</td>
								<td>
									<p class="col-teal">{{number_format(($c->potentcyPoint + $totalPotency),2)}}</p>
								</td>
								<td>
									{{number_format($claim,2)}}
								</td>
								<td>
									{{number_format((($c->grand_total-$pointPrevPartial) + $pointPartial + $rest) ,2)}}	
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade" id="doesntHavePoints">
		<div style="position: absolute; margin-top: -8px;">
			@if (\Route::currentRouteName() == 'periodpoint.getfilter')
				<a href="{{route('PointFilterPeriod.Export',[$vendor, $period]) }}" 
					class="btn btn-success  waves-effect  m-t-10">
					<i class="fas fa-file-excel fa-0x m-t--10"></i> Export
				</a>
			@else
				<a href="{{$period ? route('PointThisPeriod.Export',[$vendor]) : '#' }}" 
					class="btn btn-success  waves-effect m-t-10 {{$period ? '' : 'disabled'}}">
					<i class="fas fa-file-excel fa-0x m-t--10"></i> Export
				</a>
			@endif
		</div>
		<div class="table-responsive">
			<table class="table table-bordered table-striped  table-hover table-point">
				<thead>
					<tr><th>Customer</th>
						<th>Sales</th>
						<th>Starting <!--Points--></th>
						<th><!--Points--> In Periods</th>
						<th>(+) Potential <!--Points--></th>
						<th><!--Points--> Claim</th>
						<th>Total Points</th>
					</tr>
				</thead>
				<tbody>
					@if($period != null)
						@foreach($customers as $c)
							@php
								[$rest,$totalPotency] = App\Http\Controllers\CustomerPointOrderController::starting_point($period_start,$c->csid);
								$claim = App\Http\Controllers\CustomerPointOrderController::pointsClaim($period_start,$c->csid);
								$pointPartial = App\Http\Controllers\CustomerPointOrderController::pointPartial($period_start,$c->csid);
								$pointPrevPartial = App\Http\Controllers\CustomerPointOrderController::pointPrevPartial($period_start,$c->csid);
							@endphp
							<tr>
								<td>
									{{$c->store_name ? "$c->store_code - $c->store_name" : '-'}}
								</td>
								<td>
									{{$c->sales_name}}
								</td>
								<td>
									{{number_format($rest,2)}}
								</td>
								<td>
									{{number_format((($c->grand_total-$pointPrevPartial) + $pointPartial + $claim),2)}}
								</td>
								<td>
									<p class="col-teal">{{number_format(($c->potentcyPoint + $totalPotency),2)}}</p>
								</td>
								<td>
									{{number_format($claim,2)}}
								</td>
								<td>
									{{number_format((($c->grand_total-$pointPrevPartial) + $pointPartial + $rest) ,2)}}	
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		
		</div>
	</div>
</div>



@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		$('.table-point').DataTable( {
			"lengthChange": false
		} );
	} );

	$('#period_list').select2({
        placeholder: 'Select Period',
    }); 
</script>
@endsection