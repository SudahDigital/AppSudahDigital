@extends('layouts.master')
@section('title') Create Catalog Link @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('catalog.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('name')}}" class="form-control" 
                name="name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>
        
        <h2 class="card-inside-title">Type</h2>
        <div class="form-group">
            <input class="form-control" type="radio" name="type" id="PDF" value="PDF" required> <label for="PDF">PDF</label>
            <input class="form-control" type="radio" name="type" id="IMAGE" value="IMAGE"> <label for="IMAGE">IMAGE</label>
            <input class="form-control" type="radio" name="type" id="VIDEO" value="VIDEO"> <label for="VIDEO">VIDEO</label>
            <input class="form-control" type="radio" name="type" id="OTHERS" value="OTHERS"> <label for="OTHERS">OTHERS</label>
            <div class="invalid-feedback">
                {{$errors->first('type')}}
            </div>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="url" class="form-control" id="ctl_url" name="catalog_url" 
                value="{{old('catalog_url')}}" required>
                <label class="form-label">Catalog URL</label>
            </div>
        </div>
                        
        <button class="btn btn-primary waves-effect" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection