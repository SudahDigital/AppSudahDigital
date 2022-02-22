@extends('layouts.master')
@section('title') Import Products Price @endsection
@section('content')

    <!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('cDiscount.storeImport',[$vendor])}}">
    	@csrf
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                @foreach($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach      
            </div>
        @endif

        @if(Session::has('success'))
            <?php
             $success = 'success'; 
            ?>
            <script>
                window.location.href = "{{URL::to($vendor.'/customer-discount/create/'.$success)}}";
            </script>
        @endif
        <input type="hidden" name="idDisc" value="{{Crypt::decrypt($id)}}">
        <h2 class="card-inside-title">File(.xls, .xlsx)</h2>
        <div class="form-group">
            <div class="form-line">
            <input type="file" name="file" accept=".xls, .xlsx" 
            class="form-control" id="file" autocomplete="off" required>
            </div>
            <label id="name-error" class="error" for="file">{{ $errors->first('file') }}</label>
        </div>

        <button  class="btn btn-primary waves-effect" value="ADD" type="submit">UPLOAD</button>
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
      ajax: {
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
        
      }
    }); 
</script>

@endsection