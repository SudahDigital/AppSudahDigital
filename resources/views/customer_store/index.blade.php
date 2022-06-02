@extends('layouts.master')
@section('title') Customer List @endsection
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


<form action="{{route('customers.index',[$vendor])}}">
	<div class="row">
		<!--
		<div class="col-md-3">
			<div class="input-group input-group-sm">
        		<div class="form-line">
	            	<input type="text" class="form-control" name="keyword" value="{{Request::get('keyword')}}" placeholder="Filter by product name" autocomplete="off" />
	    		</div>
	        </div>
		</div>
		<div class="col-md-2">
			<input type="submit" class="btn bg-blue pull-left" value="Filter">
		</div>
		-->
		<div class="col-md-6">
			<ul class="nav nav-tabs tab-col-pink pull-left" >
				<li role="presentation" class="{{Request::get('status') == NULL && Request::path() == $vendor.'/customers' ? 'active' : ''}}">
					<a href="{{route('customers.index',[$vendor])}}" aria-expanded="true" >All</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'active' ?'active' : '' }}">
					<a href="{{route('customers.index', [$vendor,'status' =>'active'])}}" >ACTIVE</a>
				</li>
				<li role="presentation" class="{{Request::get('status') == 'nonactive' ?'active' : '' }}">
					<a href="{{route('customers.index', [$vendor,'status' =>'nonactive'])}}">INACTIVE</a>
				</li>
				<!--
				<li role="presentation" class="{{Request::get('status') == 'reg_point' ?'active' : '' }}">
					<a href="{{route('customers.index', [$vendor,'status' =>'reg_point'])}}">REGISTERED POINT</a>
				</li>
				-->
			</ul>
		</div>
		<div class="col-md-6">&nbsp;</div>
	</div>
</form>
@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
<div class="row">
	<div class="col-md-12">
		<a href="{{route('customers.import',[$vendor])}}" class="btn btn-success py-auto"><i class="fas fa-file-excel fa-0x "></i> Import </a>&nbsp;
		<a href="{{route('customers.export',[$vendor])}}" class="btn btn-success "><i class="fas fa-file-excel fa-1x"></i> Export</a>&nbsp;
		<a href="{{route('cities.export',[$vendor])}}" class="btn btn-primary "><i class="fas fa-file-excel fa-1x"></i> City List </a>&nbsp;
		<a href="{{route('customers.create',[$vendor])}}" class="btn bg-cyan">Create Customer</a>
	</div>
</div>
@endif
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>Status</th>
				<th>Code</th>
				<th>Name</th>
				<th width="20%">Address</th>
				<th>Phone</th>
				<!--<th>Customer</th>-->
				<th>Sales Rep</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($customers as $c)
			<?php $no++;?>
			<tr>
				<td>
					@if($c->status=="NONACTIVE")
						<span class="badge bg-red text-white">{{$c->status}}</span>
							@else
						<span class="badge bg-green">{{$c->status}}</span>
					@endif
				</td>
				<td>
					@if($c->store_code)
					{{$c->store_code}}
					@else
					-
					@endif
					<br>
					@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
						@if($c->pareto_id)
							<span class="badge bg-orange">{{$c->pareto->pareto_code}}</span>
						@endif
					@else
						@if($c->pareto_id)
							<span class="badge bg-orange">{{$c->pareto_code}}</span>
						@endif
					@endif

				</td>
				<td>
					<small><b> Key : </b>{{$c->store_key ? "$c->store_key" : '-'}}</small><br>
					@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
						<small><b>Group</b> : {{$c->group_id ? $c->customerGroups->code : ''}}</small><br>
						<small><b>Type</b> : {{$c->type_cust ? $c->type_cust->name : ''}}</small><br>
						<!--<small><b>Price Type</b> : {{$c->pricelist_id ? $c->CustomerPrice->name : ''}}</small>-->
					@else
						@if(Gate::check('isSpv'))
							<small><b>Group</b> :{{$c->group_id ? $c->cgCode : ''}}</b></small>
							<small><b>Type</b> :{{$c->cust_type ? $c->tp_name : ''}}</b></small>
							<!--<small><b>Price Type</b> : {{$c->pricelist_id ? $c->cd_name : ''}}</small>-->
						@endif
					@endif
					<small><b> Name : </b>{{$c->store_name ? "$c->store_name" : '-'}}</small><br>
					<!--
					<small><b> Email : </b>{{$c->email ? "$c->email" : '-'}}</small><br>
					<small><b> Contact Person : </b>{{$c->name ? $c->name : '-'}}</small><br>
					-->
					
				</td>
				<td>
					{{$c->address}}<br>
					@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
					{{$c->city_id ? $c->cities->city_name :''}}
					@else 
						@if(Gate::check('isSpv'))
							{{$c->city_name}}
						@endif
					@endif
					@if($c->lat && $c->lng)
						<span class="badge bg-blue">with coordinate</span>
					@endif
				</td>
				<td>
					<small class="text-primary"><b> Wa : </b>{{$c->phone != NULL ? "$c->phone" : '-'}}</small><br>
					<small class="text-warning"><b> Owner : </b>{{$c->phone_owner != NULL ? "$c->phone_owner" : '-'}}</small><br>
					<small class="text-danger"><b> Office : </b>{{$c->phone_store != NULL ? "$c->phone_store" : '-'}}</small>
				</td>
				<!--<td>
					@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
						<small>Type : {{$c->type_cust ? $c->type_cust->name : ''}}</small><br>
						<small>Price Type : {{$c->type_cust ? $c->type_cust->name : ''}}</small>
					@else
						@if(Gate::check('isSpv'))
							{{$c->cust_type ? $c->tp_name : ''}}
						@endif
					@endif
				</td>-->
				@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
					<td>@if($c->user_id > 0)
							@php
								if($c->users != null){
									echo $c->users->name;
								}else{
									echo '';
								}
							@endphp
						@else
						-
						@endif
					</td>
				@else 
					@if(Gate::check('isSpv'))
						<td>
							{{$c->user_name}}	
						</td>
					@endif
				@endif
				<td>
					<div class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<i class="material-icons" >apps</i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="{{route('customers.detail',[$vendor,Crypt::encrypt($c->id)])}}" 
								class=" waves-effect waves-block">
									Details
								</a>
							</li>
							<li>
								<a href="{{route('customers.edit',[$vendor,Crypt::encrypt($c->id)])}}" 
								class=" waves-effect waves-block">
									Edit
								</a>
							</li>
							@if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
								<li>
									<a  
										data-toggle="modal" data-target="#deleteModal{{$c->id}}"
										class=" waves-effect waves-block">
										Delete
									</a>
								</li>
							@endif
						</ul>
					</div>
					
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$c->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Customer</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this customer ..? 
		                        </div>
		                        <div class="modal-footer">
		                        	<form action="{{route('customers.delete-permanent',[$vendor,$c->id])}}" method="POST">
										@csrf
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-link waves-effect">Delete</button>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
									</form>
		                        </div>
		                    </div>
		                </div>
		            </div>
					
		        </td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection