@extends('layouts.master')
@section('title') Edit Catalog Link @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('catalog.update',[$vendor,$ctl_edit->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="GET">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('name',$ctl_edit->name)}}" class="form-control" 
                name="name" autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <h2 class="card-inside-title">Type</h2>
        <div class="form-group">
            <input class="form-control" type="radio" 
            name="type" id="PDF" value="PDF" {{$ctl_edit->type == 'PDF' ? 'checked' : ''}} required> 
            <label for="PDF">PDF</label>
            
            <input class="form-control" type="radio" 
            name="type" id="IMAGE" value="IMAGE" {{$ctl_edit->type == 'IMAGE' ? 'checked' : ''}}> 
            <label for="IMAGE">IMAGE</label>

            <input class="form-control" type="radio" 
            name="type" id="VIDEO" value="VIDEO" {{$ctl_edit->type == 'VIDEO' ? 'checked' : ''}}> 
            <label for="VIDEO">VIDEO</label>

            <input class="form-control" type="radio" 
            name="type" id="OTHERS" value="OTHERS" {{$ctl_edit->type == 'OTHERS' ? 'checked' : ''}}> 
            <label for="OTHERS">OTHERS</label>

            <div class="invalid-feedback">
                {{$errors->first('type')}}
            </div>
        </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="url" class="form-control" id="ctl_url" name="catalog_url" 
                value="{{old('catalog_url',$ctl_edit->url)}}" required>
                <label class="form-label">Catalog URL</label>
            </div>
        </div>

        <button class="btn btn-primary waves-effect" type="submit">UPDATE</button>&nbsp;
        <a href="{{route('catalog.index',[$vendor])}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
    </form>

    <!-- #END#  -->		

@endsection