@extends('layouts.master')
@section('title') Customer Group Code Lists @endsection
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
<form action="{{route('products.index',[$vendor])}}">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('customerGroups.create',[$vendor])}}" class="btn waves-effect btn-success">Create</a>
		</div>
	</div>
</form>	
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover dataTable js-basic-example">
		<thead>
			<tr>
				<th>Group Id</th>
				<th>Group Code</th>
				<th>Name</th>
				<th width="25%">Action</th>
			</tr>
		</thead>
		<tbody>
			
			@foreach($csGroups as $cg)
			<tr>
				<td>{{$cg->id}}</td>
				<td>{{$cg->code}}</td>
				<td>{{$cg->name}}</td>
				<td>
					<a class="btn btn-info btn-xs waves-effect" href="{{route('customerGroups.edit',[$vendor,Crypt::encrypt($cg->id)])}}"><i class="material-icons">edit</i></button></a>
					
					<button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$cg->id}}"><i class="material-icons">delete</i></button>
					
					<!-- Modal Delete -->
		            <div class="modal fade" id="deleteModal{{$cg->id}}" tabindex="-1" role="dialog">
		                <div class="modal-dialog modal-sm" role="document">
		                    <div class="modal-content modal-col-red">
		                        <div class="modal-header">
		                            <h4 class="modal-title" id="deleteModalLabel">Delete Group</h4>
		                        </div>
		                        <div class="modal-body">
		                           Delete this group code..?
								</div>
		                        <div class="modal-footer">
		                        	<form action="{{route('customerGroups.destroy',[$vendor,$cg->id])}}" method="POST">
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
