@extends('layouts.master')
@section('title') Catalog Lists @endsection
@section('content')

@if(session('status'))
	<div class="alert alert-success">
		{{session('status')}}
	</div>
@endif
<style>
	.wrapword {
		white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
		white-space: -webkit-pre-wrap;          /* Chrome & Safari */ 
		white-space: -pre-wrap;                 /* Opera 4-6 */
		white-space: -o-pre-wrap;               /* Opera 7 */
		white-space: pre-wrap;                  /* CSS3 */
		word-wrap: break-word;                  /* Internet Explorer 5.5+ */
		word-break: break-all;
		white-space: normal;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<a href="{{route('catalog.create',[$vendor])}}" class="btn btn-success">Create</a>
	</div>
</div>

<hr>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover catalog-table">
		<thead>
			<tr>
				<th width="1%">#</th>
				<th width="30%">Name</th>
				<th width="5%">Type</th>
				<th width="64%">URL</th>
				<th>#</th>
			</tr>
		</thead>
		<tbody id="tablecontents">
			@foreach($catalog as $ctl)
				<tr class="row1" data-id="{{$ctl->id}}">
					<td><i class="fa fa-sort"></i></td>
					<td>{{$ctl->name}}</td>
					<td>
						@switch($ctl->type)
							@case('PDF')
								<i class="fad fa-file-pdf fa-2x"></i>
								@break
							@case('IMAGE')
								<i class="fad fa-file-image fa-2x"></i>
								@break
							@case('VIDEO')
								<i class="fad fa-file-video fa-2x"></i>
								@break
							@case('OTHERS')
								<i class="fad fa-file fa-2x"></i>
								@break
							@default
								<i class="fad fa-file fa-2x"></i>
						@endswitch
					</td>
					<td class="wrapword">
						<a href="{{$ctl->url}}" target="_blank" 
							style="text-decoration:none;">
							{{$ctl->url}}
						</a>
					</td>
					<td>
						<div class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
								<i class="material-icons" >apps</i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="{{route('catalog.edit',[$vendor,Crypt::encrypt($ctl->id)])}}" 
										class=" waves-effect waves-block">
										Edit
									</a>
								</li>
								<li>
									<a href="javascript:void(0);" class=" waves-effect waves-block" 
										data-toggle="modal" data-target="#deleteModal{{$ctl->id}}">
										Delete
									</a>
								</li>
							</ul>
						</div>

						<!-- Modal Delete -->
						<div class="modal fade" id="deleteModal{{$ctl->id}}" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content modal-col-red">
									<div class="modal-header">
										<h4 class="modal-title" id="deleteModalLabel">Delete Catalog</h4>
									</div>
									<div class="modal-body">
										Delete this catalog ..? 
									</div>
									<div class="modal-footer">
										<form action="{{route('catalog.destroy',[$vendor,$ctl->id])}}" method="POST">
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
@section('footer-scripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.catalog-table').DataTable( {
				columnDefs: [{
					targets: "_all",
					orderable: false
				}]
			});
		});

		$(function () {
		$( "#tablecontents" ).sortable({
			items: "tr",
			cursor: 'move',
			opacity: 0.6,
			update: function() {
				sendOrderToServer();
			}
		});

		function sendOrderToServer() {
			var order = [];
			var token = $('meta[name="csrf-token"]').attr('content');
			$('tr.row1').each(function(index,element) {
			order.push({
				id: $(this).attr('data-id'),
				position: index+1
			});
			});

			$.ajax({
			type: "POST", 
			dataType: "json", 
			url: '{{URL::to('/ajax/catalog/sortable')}}',
				data: {
				posit: order,
				_token: token
			},
			success: function(response) {
				if (response.status == "success") {
					console.log(response);
					} else {
					console.log(response);
				}
				
			}
			});
		}
		});
	</script>
@endsection
