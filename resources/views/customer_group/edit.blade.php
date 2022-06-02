@extends('layouts.master')
@section('title') Edit Customer Group Code @endsection
@section('content')
<style>
    .text-error{
        color: #F44336;
    }
</style>
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif
	<!-- Form Edit-->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('customerGroups.update',[$vendor,$groups->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id="old_code" value="{{$groups->id}}">
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" value="{{old('code',$groups->code)}}" class="form-control" 
                id="code" name="code" autocomplete="off" required>
                <label class="form-label" for="code">Group Code</label>
            </div>
            <small class=""></small>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{old('name',$groups->name)}}" class="form-control" id="name"  
                name="name" autocomplete="off" required >
                <label class="form-label">Name</label>
            </div>
        </div>
        <button id="save" class="btn btn-primary waves-effect" name="save_action" value="UPDATE" type="submit" style="margin-top: 20px;">UPDATE</button>
    </form>
    <!-- #END#  -->
    		
    
@endsection

@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script>
    $("#code").on({
        keydown: function(e) {
        if (e.which === 32)
            return false;
        },
        keyup: function(){
        this.value = this.value.toUpperCase();
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
            
        }
    });

    $('document').ready(function(){
        $('#code, .btn').on('keyup blur', function(){
        var code = $('#code').val();
        var old_code =$('#old_code').val();
            $.ajax({
                url: '{{URL::to('/ajax/customerGroups/search')}}',
                type: 'get',
                data: {
                    'code' : code,
                    'old_code' : old_code
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("small").addClass("text-error").text('Sorry... Code Already Exists');
                    //$('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").removeClass("text-error").addClass("text-primary").text('Code Available');
                    //$('#code_').siblings("label").addClass("text-primary").text('Code Available');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && code ==""){
                        $('#code_').addClass("error");
                        $('#code_').siblings("small").text('');
                    }
                }
            });
        });
    });
</script>

@endsection