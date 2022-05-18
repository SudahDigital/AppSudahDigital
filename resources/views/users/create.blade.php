@extends('layouts.master')

@if(Route::is('users.create'))
    @section('title') Create Admin @endsection
    @section('content')

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('users.store',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="name" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>
            <!--                        
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="username" autocomplete="off" required>
                    <label class="form-label">UserName</label>
                </div>
            </div>
            -->               
            <h2 class="card-inside-title">Roles</h2>
            <div class="form-group">
                <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles" id="ADMIN" value="SUPERADMIN" required> <label for="ADMIN">Super Admin</label>
                <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles" id="STAFF" value="ADMIN"> <label for="STAFF">Admin</label>
                <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles" id="SLSCT" value="SALES-COUNTER"> <label for="SLSCT">Sales Order</label>
                <div class="invalid-feedback">
                    {{$errors->first('roles')}}
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="phone" minlength="10" maxlength="12" autocomplete="off" required>
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 12 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required></textarea>
                </div>
            </div>

            <h2 class="card-inside-title">Avatar Image</h2>
            <div class="form-group">
            <div class="form-line">
                <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
                </div>
            </div>
            <!--
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" class="form-control" name="email" autocomplete="off" required>
                    <label class="form-label">Email</label>
                </div>
            </div>
            -->
            <div class="form-group form-float">
                <div class="form-line" id="email_" class="email_">
                    <input type="email" class="form-control" id="email"  name="email" autocomplete="off" required>
                    <label class="form-label">Email</label>
                </div>
                <small class="err_exist"></small>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" name="password" id="password" required>
                    <label for="password" class="form-label">Password</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}" name="password_confirmation" id="password_confirmation" required>
                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password_confirmation')}}
                    </div>
                </div>
            </div>
                            
            <button id="btnSubmit" class="btn btn-primary waves-effect btn-create-user" type="submit">SUBMIT</button>
        </form>
        <!-- #END#  -->		

    @endsection
@endif

@if(Route::is('sales.create'))
    @section('title') Create Sales @endsection
    @section('content')

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('sales.store',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="name" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>
            <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="hidden" name="roles" id="SALES" value="SALES" required>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="phone" minlength="10" maxlength="13" autocomplete="off" required>
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required></textarea>
                </div>
            </div>

            
            <h2 class="card-inside-title">Image</h2>
            <div class="form-group">
            <div class="form-line">
                <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
                </div>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line" id="email_" class="email_">
                    <input type="email" class="form-control" id="email"  name="email" autocomplete="off" required>
                    <label class="form-label">Email</label>
                </div>
                <small class="err_exist"></small>
            </div>


            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="sales_area" autocomplete="off" required>
                    <label class="form-label">Sales Area</label>
                </div>
            </div>
            <!--
            <h2 class="card-inside-title">Sales Area</h2>
            <select name="city_id"  id="city_id" class="form-control"></select>
            <br>
            <br>
            -->
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" name="password" id="password" required>
                    <label for="password" class="form-label">Password</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}" name="password_confirmation" id="password_confirmation" required>
                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password_confirmation')}}
                    </div>
                </div>
            </div>
                            
            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
        </form>
        <!-- #END#  -->		

    @endsection
@endif

@if(Route::is('spv.create'))
    @section('title') Create Supervisor @endsection
    @section('content')

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-success">
                {{session('error')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" class="form_spv" method="POST" enctype="multipart/form-data" action="{{route('spv.store',[$vendor])}}">
            @csrf
            <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="name" autocomplete="off" required value="{{old('name') }}">
                    <label class="form-label">Name</label>
                </div>
            </div>
            <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="hidden" name="roles" id="SUPERVISOR" value="SUPERVISOR" required>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="phone" minlength="10" maxlength="13" autocomplete="off" required value="{{old('phone') }}">
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <textarea id="address" name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{old('address') }}</textarea>
                </div>
            </div>

            <h2 class="card-inside-title">Avatar Image</h2>
            <div class="form-group">
                <div class="form-line">
                    <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off" required accept="image/png,image/jpg,image/jpeg" >
                </div>
                <label id="name-error" class="error" for="avatar">{{ $errors->first('avatar') }}</label>
            </div>

            <div class="form-group">
                <h2 class="card-inside-title">Sales Team Member</h2>
                <select id="list_user" class="users" multiple="multiple" name="sls_id[]" style="width: 100%;" required>
                    @foreach ($users as $u)
                        @if (old('sls_id'))
                            <option value="{{ $u->id }}" {{ in_array($u->id, old('sls_id')) ? 'selected' : '' }}>{{ $u->name }}</option>   
                        @else
                            <option value="{{ $u->id }}" >{{  $u->name }}</option>
                        @endif 
                    @endforeach
                </select>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line" id="email_" class="email_">
                    <input type="email" class="form-control" id="email"  name="email" autocomplete="off" required>
                    <label class="form-label">SPV Email</label>
                </div>
                <small class="err_exist"></small>
            </div>

            <!--
            <div class="form-group form-float">
                <div class="form-line" id="email_" class="email_">
                    <input type="email" class="form-control" id="emailSenior1"  name="emailSenior1" autocomplete="off">
                    <label class="form-label">Senior Officer's Email 1</label>
                </div>
                <small class="err_exist"></small>
            </div>

            <div class="form-group form-float">
                <div class="form-line" id="email_" class="email_">
                    <input type="email" class="form-control" id="emailSenior2"  name="emailSenior2" autocomplete="off">
                    <label class="form-label">Senior Officer's Email 2</label>
                </div>
                <small class="err_exist"></small>
            </div>
            -->
            <!--
            <h2 class="card-inside-title">Sales Area</h2>
            <select name="city_id"  id="city_id" class="form-control"></select>
            <br>
            <br>
            -->
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password') ? "is-invalid" : ""}}" name="password" id="password" required {{old('password') }}>
                    <label for="password" class="form-label">Password</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password')}}
                    </div>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="password" class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}" name="password_confirmation" id="password_confirmation" required {{old('password_confirmation') }}>
                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                    <div class="invalid-feedback">
                        {{$errors->first('password_confirmation')}}
                    </div>
                </div>
            </div>
                            
            <button id="btnSubmit" class="btn btn-primary waves-effect" type="submit">SUBMIT</button>
        </form>
        <!-- #END#  -->		

    @endsection
@endif


@section('footer-scripts')

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        
        /*$( ".form_spv" ).validate({
            rules: {
                avatar: {
                    required: true,
                    extension: "jpg|jpeg|png"
                }
            }
        });
        */
        $('document').ready(function(){
            $('#email, .btn-create-user').on('keyup blur', function(){
            var email = $('#email').val();
                $.ajax({
                    url: '{{URL::to('/ajax/users_email/search')}}',
                    type: 'get',
                    data: {
                        'email' : email,
                    },
                    success: function(response){
                        if (response == 'taken' && email !="" ) {
                        $('.email_').addClass("focused error");
                        $('.err_exist').addClass("small").addClass('merah').text('Sorry... Email Already Exists');
                        $('#btnSubmit').prop('disabled', true);
                        }else if (response == 'not_taken' && email !="") {
                        $('.email_').addClass("");
                        $('.err_exist').addClass("text-primary").removeClass('merah').text('Email Available');
                        $('#btnSubmit').prop('disabled', false);
                        }
                        else if(response == 'not_taken' && email==""){
                            //$('#email_').siblings("label").text('');
                            $('.err_exist').text('');
                        }
                    }
                });
            });
        });

       $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#password").val();
                var confirmPassword = $("#password_confirmation").val();
                if (password != confirmPassword) {
                    Swal.fire('Passwords Do not Match');
                    return false;
                }
                return true;
            });
        });
    
        $(".users").select2({
            width: 'resolve' // need to override the changed default
        });
        $('#city_id').select2({
        placeholder: 'Select an item',
        ajax: {
            url: '{{URL::to('/ajax/cities/search')}}',
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.city_name
                        
                    }
                })
            };
            }
            
        }
        });
    </script>
@endsection