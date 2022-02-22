@extends('layouts.master')
@section('title') 
	Customer Price List
	<div class="pull-right">
		<div class="dropdown">
			<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" 
				aria-haspopup="true" aria-expanded="true" id="popoverDataTemplate" data-trigger="hover" data-container="body" data-placement="left" 
				data-content="Download Template">
					<i class="material-icons">archive</i>
			</a>
			<ul class="dropdown-menu pull-right">
				<li>
				   <a href="{{route('productsInfo.export',[$vendor])}}" class=" waves-effect waves-block">
						<i class="fas fa-file-excel fa-0x" style="color: #4CAF50"></i> Products
					</a>
				
					<a href="{{asset('assets/template/ProductDiscountImport.xlsx')}}" class=" waves-effect waves-block" download>
						<i class="fas fa-file-excel fa-0x" style="color: #4CAF50"></i> Import Template
					</a>
				</li>
			</ul>
		</div>
		
	</div> 
@endsection
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
@if(Session::has('success'))
	<div class="alert alert-success">
		{!! Session::get('success') !!}
	</div>
@endif
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('cDiscount.create',[$vendor])}}" class="btn bg-cyan pull-right">Create</a>
		</div>
	</div>
	
<hr>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Type</th>
				<th width="18%">Product</th>
				<th>Status</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody>
			<?php $no=0;?>
			@foreach($cDiscounts as $cd)
			<?php $no++;?>
			<tr>
				<td>{{$cd->id}}</td>
				<td>{{$cd->name}}</td>
				<td>
					{{$cd->typeCustomer->name}}
				</td>
				
				<td>
					{{$cd->TotalItem}} Item
				</td>
				<td>
					@if($cd->status=="ACTIVE")
						<span class="badge bg-green text-white">{{$cd->status}}</span>
					@elseif($cd->status=="INACTIVE")
						<span class="badge bg-red">{{$cd->status}}</span>
					@endif
				</td>
				<td>
					<div class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<i class="material-icons" >apps</i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								
								<a href="{{route('cDiscount.detail',[$vendor,Crypt::encrypt($cd->id)])}}" 
								class=" waves-effect waves-block">
									Edit & Details
								</a>
								
							</li>
							<li>
								@if($cd->status=="ACTIVE")
									<a href="{{route('cDiscount.status',[$vendor,$cd->id,'INACTIVE'])}}" 
									class=" waves-effect waves-block">
										Inactivates
									</a>
								@else
									<a 
										href="{{$cd->TotalItem < 1 ? '#' : route('cDiscount.status',[$vendor,$cd->id,'ACTIVE'])}}" 
										class=" waves-effect waves-block">
											Activates
									</a>
								@endif
							</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</div>

@endsection
@section('footer-scripts')
	<script type="text/javascript">
		$('#popoverDataTemplate').popover();
	</script>
@endsection
