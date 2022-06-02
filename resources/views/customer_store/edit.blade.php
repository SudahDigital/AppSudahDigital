@extends('layouts.master')
@section('title') 
    @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
        Edit Customer
    @else
        @if(Gate::check('isSpv'))
        Edit Customer Type
        @endif
    @endif 
@endsection
@section('content')

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
	<!-- Form Edit -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('customers.update',[$vendor,$cust->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
            <div class="form-group form-float">
                <div class="form-line" id="code_">
                    <input type="text" id="code" class="form-control" name="store_code" autocomplete="off" 
                    value="{{old('store_code',$cust->store_code)}}" required>
                    <label class="form-label">Customer Code</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="store_name" 
                    value="{{old('store_name',$cust->store_name)}}" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" class="form-control" value="{{old('email',$cust->email)}}" 
                    name="email" autocomplete="off">
                    <label class="form-label">Email</label>
                </div>
            </div>

            <div class="col-12" style="padding:0;margin-bottom:30px;">
                <b>Group Code</b>
                <select name="group_id"  id="group_id" class="form-control">
                    <option></option>
                    @foreach($groups as $cg)
                        <option value="{{$cg->id}}" 
                             {{(old('group_id') == $cg->id || $cust->group_id == $cg->id ? 'selected':'')}}>
                             {{$cg->code}}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        @if(Gate::check('isSpv') || Gate::check('isSuperadmin') || Gate::check('isAdmin'))
            <b>Customer Type</b>
            <select name="cust_type"  id="cust_type" class="form-control" 
                {{Gate::check('isSuperadmin') || Gate::check('isAdmin') ? '' : 'required'}}>
                <option></option>
                @foreach($type as $ty)
                    <option value="{{$ty->id}}" 
                        {{(old('cust_type') == $ty->id || $ty->id == $cust->cust_type ? 'selected' : '')}}>
                        {{$ty->name}}
                    </option>
                @endforeach
            </select>
        @endif
        @if(Gate::check('isSuperadmin') || Gate::check('isAdmin'))
            <div class="col-12" style="padding:0;margin-top:30px;margin-bottom:20px;">
                <b>Customer Price Type</b>
                <select name="cust_price_type"  id="cust_price_type" class="form-control">
                    <option></option>
                    @if($cust->pricelist_id != null)
                        <option value="0">Don't use customer price type</option>
                    @endif
                    @foreach($custPrice as $cp)
                        <option value="{{$cp->id}}" 
                            {{(old('cust_price_type') == $cp->id || $cust->pricelist_id == $cp->id ? 'selected':'')}}>
                            {{$cp->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12" style="padding:0;margin-top:30px;margin-bottom:30px;">
                <b>City</b>
                <select name="city"  id="city_id" class="form-control">
                    <option></option>
                    @foreach($city as $cty)
                        <option value="{{$cty->id}}" 
                            {{(old('city') == $cty->id || $cust->city_id == $cty->id ? 'selected':'')}}>
                            {{$cty->city_name}}
                        </option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="form-group">
                <div class="form-line">
                    <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{old('address',$cust->address)}}</textarea>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" id="latlng" class="form-control" value="{{old('latlng', $cust->lat ? $cust->lat.', '.$cust->lng : '')}}"
                    name="latlng">
                    <label class="form-label">Coordinate</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input id="txtNumber" value="{{old('phone', $cust->phone)}}" class="form-control" onkeypress="return isNumberKey(event)"  type="text" name="phone" minlength="10" maxlength="13" autocomplete="off">
                    <label class="form-label">Whatsapp Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" value="{{old('phone_owner',$cust->phone_owner)}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_owner"  autocomplete="off" >
                    <label class="form-label">Owner Phone</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" value="{{old('phone_store',$cust->phone_store)}}" id="txtNumber" class="form-control" onkeypress="return isNumberKey(event)" name="phone_store"  autocomplete="off" >
                    <label class="form-label">Office/Shop Phone</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="contact_person" 
                    value="{{old('contact_person',$cust->name)}}" autocomplete="off" required>
                    <label class="form-label">Contact Person</label>
                </div>
            </div>
            <!--
            <h2 class="card-inside-title">Payment Term</h2>
                <select name="payment_term"  id="payment_term" class="form-control" required>
                    <option value="7 Days" {{$cust->payment_term == '7 Days' ? 'selected' : '' }}>7 Days</option>
                    <option value="45 Days" {{$cust->payment_term == '45 Days' ? 'selected' : '' }}>45 Days</option>
                    <option value="60 Days" {{$cust->payment_term == '60 Days' ? 'selected' : '' }}>60 Days</option>
                </select>
            <br>
            -->
            <h2 class="card-inside-title">Term Of Payment</h2>
            <div class="col-sm-2" style="padding-left:0;padding-right:0;">
                <div class="form-group">
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="cash" value="Cash" required onclick="checkstate()"
                        {{old('payment_term',$cust_term)== 'Cash' ? 'checked' : ''}} > 
                    <label for="cash">Cash</label>
                    &nbsp;&nbsp;
                    <input class="form-control {{$errors->first('payment_term') ? "is-invalid" : "" }}" 
                        type="radio" name="payment_term" id="top" value="TOP" onclick="checkstate()"
                        {{{old('payment_term',$cust_term)=='TOP' ? 'checked' : ''}}}> 
                    <label for="top">TOP</label>
                </div>
            </div>
            
            <div class="col-sm-10" style="padding-left:0;">
                <div class="input-group">
                    <div class="form-line">
                        <input type="number" min="0" class="form-control" 
                        id="pay_cust" name="pay_cust" value="{{old('pay_cust',preg_replace("/[^0-9]/","",$cust->payment_term))}}" 
                        autocomplete="off" required placeholder="Net d Days"
                        {{($cust_term == "Cash") ? 'disabled' : ''}}>
                    </div>
                    <span class="input-group-addon">Days</span>
                </div>
            </div>
            
            <!--
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="payment_term" value="{{$cust->payment_term}}" autocomplete="off" required>
                    <label class="form-label">Payment Term</label>
                </div>
            </div>
            -->

            <div class="col-12" style="padding:0;">
                <b>Pareto Code</b>
                <select name="pareto_id"  id="pareto_id" class="form-control">
                    <option></option>
                    @if ($cust->pareto_id)
                        <option value="0">Not Pareto</option>
                    @endif
                    @foreach($pareto as $prt)
                        <option value="{{$prt->id}}" 
                            {{(old('pareto_id') == $prt->id || $prt->id == $cust->pareto_id ? 'selected' : '')}}>
                            {{$prt->pareto_code}}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!--
            <div class="input-group">
                <div class="form-line">
                    <input type="number" min="0" class="form-control" 
                    id="target_store" name="target_store" value="{{old('target_store',preg_replace("/[^0-9]/","",$cust->target_store))}}" 
                    autocomplete="off" placeholder="Target Store">
                </div>
                <span class="input-group-addon">IDR</span>
            </div>
            -->
            
            <div class="col-12" style="padding:0;margin-top:30px">
                <b>Sales Representative</b>
                <select name="sales"  id="user" class="form-control">
                    <option></option>
                    @foreach($user as $usr)
                        <option value="{{$usr->id}}" 
                            {{(old('sales') == $usr->id || $usr->id == $cust->user_id? 'selected':'')}}>
                            {{$usr->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <h2 class="card-inside-title">Status</h2>
            <div class="form-group">
                <input type="radio" value="NEW" name="status" id="NEW" {{$cust->status == 'NEW' ? 'checked' : ''}} disabled>
                <label for="NEW">NEW</label>
                    &nbsp;
                <input type="radio" value="ACTIVE" name="status" id="ACTIVE" {{$cust->status == 'ACTIVE' ? 'checked' : ''}}>
                <label for="ACTIVE">ACTIVE</label>
                                &nbsp;
                <input type="radio" value="NONACTIVE" name="status" id="INACTIVE" {{$cust->status == 'NONACTIVE' ? 'checked' : ''}}>
                <label for="INACTIVE">INACTIVE</label>
            </div>

            <!--
            <h2 class="card-inside-title">Registered Points</h2>
            <div class="form-group">
                <input type="radio" value="Y" name="reg_point" id="Y" {{$cust->reg_point == 'Y' ? 'checked' : ''}}>
                <label for="Y">Y</label>
                                &nbsp;
                <input type="radio" value="N" name="reg_point" id="N" {{$cust->reg_point == 'N' ? 'checked' : ''}}>
                <label for="N">N</label>
            </div>
            -->
        @endif
        
        <button class="btn btn-primary waves-effect" name="save_action" value="SAVE" type="submit" style="margin-top: 20px;">UPDATE</button>
    </form>
    <!-- #END#  -->
    		
    
@endsection

@section('footer-scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    //select2 option list
    $('#cust_price_type').select2({
        placeholder: 'Select a Customer Price Type',
    });

    $('#cust_type').select2({
        placeholder: 'Select a Customer Type',
    });

    $('#pareto_id').select2({
        placeholder: 'Select a Pareto Code',
    });

    $('#group_id').select2({
        placeholder: 'Select a Group Code',
    });

    $('#city_id').select2({
        placeholder: 'Select a City',
    });

    $('#user').select2({
        placeholder: 'Select a Sales Representative',
    });

    //cash or top
    $('document').ready(function(){
        document.getElementById('pay_cust').disabled = document.getElementById('cash').checked;
     });
    function checkstate() {
        document.getElementById('pay_cust').disabled = document.getElementById('cash').checked;
    }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
        return false;
        return true;
    }
    
    //js store code input
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

    
    /*$('#user').select2({
      placeholder: 'Select a Sales Representative',
      ajax: {
        url: '{{URL::to('/ajax/users/search')}}',
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

    var users = JSON.stringify([{!! $cust->users !!}]);
    users = JSON.parse(users);
    users.forEach(function(cust){
    var option = new Option(cust.name, cust.id, true, true);
    $('#user').append(option).trigger('change');
    });*/

    //city
    /*$('#city_id').select2({
        placeholder: 'Select a City',
        ajax: {
            url: '{{URL::to('/customer/ajax/city_search')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.city_name,
                            
                    }
                })
            };
            }
            
        }
    });

    var cities = JSON.stringify([{!! $cust->cities !!}]);
    cities = JSON.parse(cities);
    cities.forEach(function(cust_city){
    var option_city = new Option(cust_city.city_name, cust_city.id, true, true);
    $('#city_id').append(option_city).trigger('change');
    });*/
</script>
@endsection