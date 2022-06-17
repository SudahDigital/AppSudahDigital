@extends('layouts.master')
@section('title') Edit Paket @endsection
@section('content')
<style>
    /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
    @php
        function currency($angka){
        
            $hasil = number_format($angka, 0, ".", ",");
            return $hasil;
        
        }
    @endphp
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('paket.update',[$vendor, $pakets->id])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id='old_name' value="{{$pakets->id}}">
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code" 
                value="{{$pakets->paket_name}}"
                {{$exists == 1 ? 'readonly' : ''}}
                name="paket_name" autocomplete="off" required>
                <label class="form-label">Paket Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>
        <!--
        <div class="form-group form-float">
            <div class="form-line" >
                <input type="text" class="form-control"  readonly name="paket_name" autocomplete="off" required>
                <label class="form-label">Paket Name</label>
            </div>
        </div>
        
        <h2 class="card-inside-title">Groups</h2>
        <select name="groups"  id="groups" class="form-control" required></select>
        <br>
        <br>
        -->
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="{{$pakets->display_name}}" class="form-control" name="display_name" autocomplete="off" required>
                <label class="form-label">Display Name</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" value="{{$pakets->bonus_quantity}}" 
                class="form-control" name="bonus_quantity" autocomplete="off" 
                {{$exists == 1 ? 'readonly' : ''}} required>
                <label class="form-label">Bonus Quantity</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" 
                value="{{$pakets->purchase_quantity}}" 
                name="purchase_quantity" autocomplete="off" 
                {{$exists == 1 ? 'readonly' : ''}} required>
                <label class="form-label">Purchase Quantity</label>
            </div>
        </div>

        <div class="form-group">
            <input type="checkbox" name="useExtraDisc" id="useExtraDisc" 
            onchange="valueChanged()"  {{$pakets->discount ? 'checked' : ''}}>
            <label for="useExtraDisc">Extra Discount</label>
        </div>
        
        <div id="discType" style="{{$pakets->discount ? 'display: block' : 'display: none'}}">
            <h2 class="card-inside-title">Type</h2>
            <div class="form-group">
                <input class="form-control" type="radio" onclick='showPcnt();'
                    name="discount_type" id="PERCENT" value="PERCENT" 
                    {{$pakets->discount_type == 'PERCENT' ? 'checked' : '' }} required> 
                <label for="PERCENT">Percent</label>
                <!--
                <input class="form-control" type="radio" onclick='showNml();'
                    name="discount_type" id="NOMINAL" value="NOMINAL"
                    {{$pakets->discount_type == 'NOMINAL' ? 'checked' : '' }}> 
                <label for="NOMINAL">Nominal</label>
                -->
                <div class="invalid-feedback">
                    {{$errors->first('type')}}
                </div>
            </div>
        </div>

        <div class="form-group form-float" id="percentDisc" 
        style="{{$pakets->discount_type == 'PERCENT' ? 'display: block' : 'display: none'}}">
            <div class="form-line">
                <input type="number" class="form-control" min='0' 
                name="valuePercent" 
                value="{{old('valuePercent',$pakets->discount_type == 'PERCENT' ? $pakets->discount : '')}}" autocomplete="off" required>
                
                <label class="form-label">Percent (%)</label>
            </div>
        </div>
        
        <div class="form-group form-float" id="percentNml" 
        style="{{$pakets->discount_type == 'NOMINAL' ? 'display: block' : 'display: none'}}">
            <div class="form-line">
                <input type="text" name="valueNominal" class="form-control"
                value="{{old('valueNominal',$pakets->discount_type == 'NOMINAL' ? currency($pakets->discount) : '')}}"
                id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" 
                data-type="currency" required>
                
                <label class="form-label">Nominal (IDR)</label>
            </div>
        </div>
        
        <button class="btn btn-primary waves-effect" id="save" value="UPDATE" type="submit">UPDATE</button>
        <!--<a href="{{URL::previous()}}" class="btn btn-danger waves-effect" >CANCEL</a>-->
        
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<!--
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
-->
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

    function valueChanged() {
        if($('#useExtraDisc').is(":checked")){
            $("#discType, #percentDisc").show();
            $('#PERCENT').prop('checked', true);
        }else{
            $("#discType").hide();
            $("#percentDisc").hide();
            $("#percentNml").hide();
            $('#PERCENT').prop('checked', false);
            $('#NOMINAL').prop('checked', false);
        }
    };

    $('document').ready(function(){
        $('#code, .btn').on('keyup', function(){
        var old_code = $('#old_name').val();
        var code = $('#code').val();
            $.ajax({
                url: '{{URL::to('/ajax/edit/paket/search')}}',
                type: 'get',
                data: {
                    'old_code': old_code,
                    'code' : code,
                },
                success: function(response){
                    if (response == 'taken' && code !="" ) {
                    $('#code_').addClass("focused error");
                    $('#code_').siblings("label").addClass("error").text('Sorry... Paket Name Already Exists');
                    $('#code_').siblings("small").text('');
                    $('#save').prop('disabled', true);
                    }else if (response == 'not_taken' && code !="") {
                    $('#code_').addClass("");
                    $('#code_').siblings("small").addClass("text-primary").text('Paket Name Available');
                    $('#code_').siblings("label").text('');
                    $('#save').prop('disabled', false);
                    }
                    else if(response == 'not_taken' && code ==""){
                        $('#code_').siblings("label").text('');
                        $('#code_').siblings("small").text('');
                    }
                }
            });
        });
    });

    function showPcnt(){
        var x = document.getElementById('percentDisc');
        var y = document.getElementById('percentNml');
        x.style.display = 'block';
        y.style.display = 'none';
        // $('.target_quantity').prop('required',true);
        // $('.target_nominal').prop('required',false);
    }

    function showNml(){
        var x = document.getElementById('percentDisc');
        var y = document.getElementById('percentNml');
        x.style.display = 'none';
        y.style.display = 'block';
        // $('.target_quantity').prop('required',true);
        // $('.target_nominal').prop('required',false);
    }

    $("input[data-type='currency']").on({
        keyup: function() {
        formatCurrency($(this));
        },
        blur: function() { 
        formatCurrency($(this), "blur");
        }
    });

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.
        
        // get input value
        var input_val = input.val();
        
        // don't validate empty input
        if (input_val === "") { return; }
        
        // original length
        var original_len = input_val.length;

        // initial caret position 
        var caret_pos = input.prop("selectionStart");
            
        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);
            
            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
            right_side += "00";
            }
            
            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            //input_val = "$" + left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            //input_val = "$" + input_val;
            
            // final formatting
            /*if (blur === "blur") {
            input_val += ".00";
            }*/
        }
        
        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }
    
    
</script>

@endsection
