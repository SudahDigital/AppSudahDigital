@extends('layouts.master')
@section('title') Create Customer Price List @endsection
@section('content')

    @if(!empty ($status))
		<div class="alert alert-success">
			{{$status}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('cDiscount.store',[$vendor])}}">
    	@csrf
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" id="name" name="name" 
                autocomplete="off" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <div class="col-sm-12" style="padding:0;">
            <h2 class="card-inside-title">Type</h2>
            <select name="type"  id="type" class="form-control" required>
                <option></option>
                @foreach($custType as $ty)
                    <option value="{{$ty->id}}" >{{$ty->name}}</option>
                @endforeach
            </select>
        </div>

       <button class="btn btn-primary" name="save_action" id="save" value="SAVE" type="submit" style="margin-top:20px;">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
   $('#type').select2({
      placeholder: 'Select a customer type',
      /*ajax: {
        url: '{{URL::to('/ajax/custTypeDisc/search')}}',
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                        id: item.id,
                        text: item.name
                      
                  }
              })
          };
        }
        
      }*/
    }); 
</script>

@endsection