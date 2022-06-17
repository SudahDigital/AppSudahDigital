@extends('layouts.master')
@section('title') Create Paket @endsection
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
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('paket.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
        <div class="form-group form-float">
            <div class="form-line" id="code_">
                <input type="text" class="form-control" id="code" name="paket_name" autocomplete="off" required>
                <label class="form-label">Paket Name</label>
            </div>
            <label id="name-error" class=""></label>
            <small class=""></small>
        </div>
        <!--
        <h2 class="card-inside-title">Groups</h2>
        <select name="groups"  id="groups" class="form-control" required></select>
        <br>
        <br>
        -->
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="display_name" autocomplete="off" required>
                <label class="form-label">Display Name</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" min="0" class="form-control" name="bonus_quantity" autocomplete="off" required>
                <label class="form-label">Bonus Quantity</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" min="0" class="form-control" name="purchase_quantity" autocomplete="off" required>
                <label class="form-label">Purchase Quantity</label>
            </div>
        </div>

        <div class="form-group">
            <input type="checkbox" name="useExtraDisc" id="useExtraDisc" 
            onchange="valueChanged()">
            <label for="useExtraDisc">Extra Discount</label>
        </div>
        
        <div id="discType" style="display: none">
            <h2 class="card-inside-title">Type</h2>
            <div class="form-group">
                <input class="form-control" type="radio" onclick='showPcnt();'
                    name="discount_type" id="PERCENT" value="PERCENT" checked required> 
                <label for="PERCENT">Percent</label>
                <!--
                <input class="form-control" type="radio" onclick='showNml();'
                    name="discount_type" id="NOMINAL" value="NOMINAL"> 
                <label for="NOMINAL">Nominal</label>
                -->
                <div class="invalid-feedback">
                    {{$errors->first('type')}}
                </div>
            </div>
        </div>

        <div class="form-group form-float" id="percentDisc" style="display: none">
            <div class="form-line">
                <input type="number" class="form-control" min='0' 
                name="valuePercent" value="{{old('target_quantity')}}" autocomplete="off" required>
                
                <label class="form-label">Percent (%)</label>
            </div>
        </div>
        
        <div class="form-group form-float" id="percentNml" style="display: none"    >
            <div class="form-line">
                <input type="text" name="valueNominal" class="form-control"
                id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" 
                data-type="currency" required>
                
                <label class="form-label">Nominal (IDR)</label>
            </div>
        </div>
        
        
        
        <button class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit">SAVE</button>
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
            $('#discType, #percentDisc').show();
            $('#PERCENT').prop('checked', true);
            //$("#percentDisc").show();
        }else {
            $("#discType").hide();
            $("#percentDisc").hide();
            $("#percentNml").hide();
            $('#PERCENT').prop('checked', false);
            $('#NOMINAL').prop('checked', false);
        }
    };

    $('document').ready(function(){
        $('#code, .btn').on('keyup', function(){
        var code = $('#code').val();
            $.ajax({
                url: '{{URL::to('/ajax/paket/search')}}',
                type: 'get',
                data: {
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
    
    
    /*$('#groups').select2({
      placeholder: 'Select an item',
      ajax: {
        url: '{{URL::to('/ajax/groups/search')}}',
        processResults: function (data) {
          return {
            results:  $.map(data, function (item) {
                  return {
                        id: item.id,
                        text: item.display_name
                      
                  }
              })
          };
        }
        
      }
    });
    */
    </script>

@endsection