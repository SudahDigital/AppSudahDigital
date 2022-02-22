@extends('layouts.master')
@section('title') Detail Customer Price Lists @endsection
   
@section('content')
   
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('cDiscount.update',[$vendor,$cDiscounts->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" id="code" name="name" 
                autocomplete="off" value="{{$cDiscounts->name}}" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <div class="col-sm-12" style="padding:0;">
            <h2 class="card-inside-title">Type</h2>
            <select name="type"  id="type" class="form-control" required>
                <option value="{{$cDiscounts->type}}">{{$cDiscounts->typeCustomer->name}}</option>
                @foreach($custType as $ty)
                    <option value="{{$ty->id}}" >{{$ty->name}}</option>
                @endforeach
            </select>
        </div>
        
        <button type="button" class="btn bg-green waves-effect m-b-20" data-toggle="modal" 
            data-target="#importModal" id="popoverData" data-trigger="hover" data-container="body" data-placement="bottom" 
            data-content="Import for add or change item discount">
            <i class="fas fa-file-excel"></i> Import
        </button>
        
        @if($cDiscounts->TotalItem > 1)
            <!--<button type="button" class="btn bg-red waves-effect m-b-20" data-toggle="modal" 
                data-target="#allDeleteModal" id="popoverData" data-trigger="hover" data-container="body" data-placement="right" 
                data-content="Delete for all item">
                <i class="fas fa-trash"></i> Delete All Item
            </button>-->
            <a href="{{route('cDiscItemExport',[$vendor,$cDiscounts->id]) }}" 
                class="btn bg-green waves-effect m-b-20" id="popoverData" 
                data-trigger="hover" data-container="body" data-placement="right" 
                data-content="Export Item">
                <i class="fas fa-file-excel fa-0x "></i> Export
            </a>
        @endif

        
        
        
        <table class="table table-responsive table-striped table-list-item">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Netto Price (IDR)</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer" >
                @foreach($cDiscounts->item as $item)
                    <tr>
                        <td style="width: 50%">
                            {{$item->products->product_code ? $item->products->product_code.' -' : ''}}
                            {{$item->products->Product_name}}
                        </td>
                        <td >
                            {{number_format($item->discount_price)}}
                        </td> 
                        
                        <td>
                            <a 
                                data-toggle="modal" data-target="#deleteModal{{$item->id}}"
                                class="btn btn-xs btn-danger waves-effect">
                                <i class="material-icons">delete</i>
                            </a>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content modal-col-red">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
                                        </div>
                                        <div class="modal-body">
                                        Delete this product ..? 
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{route('cDiscount.itemDelete',
                                                [$vendor,$item->id,$item->cust_disc_id])}}" class="btn btn-link waves-effect">Delete</a>
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                @endforeach  
            </tbody>
            
        </table>

        <button class="btn btn-primary" name="save_action" id="save" value="UPDATE" type="submit" style="margin-top:20px;" >UPDATE</button>
        <a href="{{route('customer_discount.index',[$vendor])}}" class="btn bg-grey" style="margin-top:20px;margin-left:10px;">BACK</a>
        
    </form>

    <!-- Modal import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Item</h5>
                </div>
                <div class="modal-body">
                    <form id="form_validation" class="form_spv" method="POST" 
                        enctype="multipart/form-data" action="{{route('cDiscount.updateItem',[$vendor])}}">
                        @csrf
                        <input type="hidden" name="idDisc" value="{{$cDiscounts->id}}">
                        <h2 class="card-inside-title">File(.xls, .xlsx)</h2>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="file" name="file" accept=".xls, .xlsx" 
                            class="form-control" id="file" autocomplete="off" required>
                            </div>
                            <label id="name-error" class="error" for="file">{{ $errors->first('file') }}</label>
                        </div>
            
                        <button  class="btn btn-primary waves-effect" value="ADD" type="submit">UPLOAD</button>
                        <button type="button" class="btn waves-effect bg-red m-l-5" data-dismiss="modal">Close</button>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>

    	

@endsection
@section('footer-scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#popoverData,#popoverDataTemplate').popover();
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