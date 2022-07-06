<!--Modal confirm cekout tanpa order-->
<div class="modal fade right" id="cekOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class="modal-body">
                <button type="button" class="btn  btn-circle" data-dismiss="modal" style="position:absolute;z-index:99999;background:#fff;"><i class="fa fa-times text-primary"></i></button>
                <img src="{{ asset('assets/image/dot-top-right.png') }}" class="dot-top-right"  
                style="" alt="dot-top-right">
                <img src="{{ asset('assets/image/dot-bottom-left.png') }}" class="dot-bottom-left"  
                style="" alt="dot-bottom-left">
                <img src="{{ asset('assets/image/shape-bottom-right.png') }}" class="shape-bottom-right"  
                style="" alt="shape-bottom-right">
                <div class="container">
                    <div class="d-flex justify-content-center mx-auto">
                        <div class="col-md-2 image-logo-login" style="z-index: 2">
                            <img src="{{asset('storage/'.$client->client_image)}}" class="img-thumbnail pt-4 img-logo-loc" style="background-color:transparent; border:none;" alt="VENDOR LOGO">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 login-label pt-4" style="z-index: 2">
                    <h5 class="text-center text-white">Konfirmasi Check Out</h5>
                </div>
                
                <div class="row justify-content-center  d-flex">
                    <div class="col-md-5 login-label" style="z-index: 2">
                        
                        <div id="PreviewToko_CheckOut" style="overflow: hidden;">
                            
                        </div>
                        <form method="POST" enctype="multipart/form-data"
                        action="{{route('checkout.no_order',[$vendor])}}"
                        onsubmit="return ValidateNoOdr(this);">
                            @csrf
                            
                            <div class="row mt-3">
                                
                                <div class="col-select col-lg-12 pl-3">
                                    <div class="form-group">
                                        <select name="reasons_id"  id="reasons_id" 
                                            class="form-control" style="width:100%;" 
                                            required
                                            oninvalid="this.setCustomValidity('Pilih alasan tidak order')"
                                            onchange="this.setCustomValidity('')">
                                        </select>
                                    </div>
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-select col-lg-12 pl-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <textarea name="notes_no_order" class="form-control p-3" rows="3" placeholder="Catatan..."
                                            style="width: 100%;
                                            border-top-left-radius:25px;
                                            border-top-right-radius:25px;
                                            border-bottom-right-radius:0;
                                            border-bottom-left-radius:0;
                                            font-weight: 500;" required
                                            oninvalid="this.setCustomValidity('Tambahkan catatan tidak order')"
                                            oninput="setCustomValidity('')"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--upload doc. checkout no order-->
                            
                                <div class="col-md-12 px-0 mb-4">
                                    <div class="upload-card upload-card-no-order">
                                        
                                        <div class="file-upload file-upload-no-order">
                                            <div class="file-select">
                                                <div class="imagePreview mb-1 img-thumbnail"></div>
                                                <!--
                                                <button class="btn btn-secondary btn-sm" >
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </button>
                                                -->
                                                <div class="file-select-name text-dark">Foto Keterangan <br> No-Order</div>
                                                <input type="file" 
                                                        accept="image/*;capture=camera" 
                                                        class="imageNoOdr profileimg" 
                                                        id="imageNoOdr"
                                                        name="imageNoOdr[]" 
                                                        {{$nAttach == 'ON' ? 'required' : ''}}
                                                        oninvalid="this.setCustomValidity('Wajib sertakan foto keterangan No-Order')"
                                                        oninput="setCustomValidity('')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="upload-footer" style="top:-5px;">
                                        <div class="row" >
                                            <div class="col-6 col-md-6">
                                                <b style="color: #1A4066 !important;
                                                         font-weight:600;
                                                         font-size:14px;">
                                                    &nbsp;
                                                </b>
                                            </div>
                                            <div class="col-6 col-md-6 text-right">
                                                <a class="btn btn-primary mb-3  btn-sm popoverDokumen file-add-noOrder" 
                                                    href="#" 
                                                    data-content="Tambah foto dokumen" 
                                                    rel="popover" 
                                                    data-placement="left" 
                                                    data-trigger="hover"
                                                    style="background-color: #1A4066 !important;
                                                        border:none;">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="attachParamNoOrder" value="{{$nAttach}}">

                                <!--
                                    <div class="col-select col-lg-12 pl-3 mb-1">
                                        <img id="preview-imageNoOdr-before-upload" src="{{asset('assets/image/2428676_frame_gallery_image_landscape_mobile_icon.png')}}"
                                            alt="preview image" class="img-thumbnail">
                                    </div>
                                    <div class="col-select col-lg-12 pl-3">
                                        <label class="float-left" for="imageNoOdr" 
                                                style="color: #ffff !important;
                                                    cursor:pointer;">
                                            <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                                        </label>
                                        <p class="text-left mt-2" style="color: #ffff !important; margin-left:50px;">
                                            Unggah dokumen
                                        </p>
                                        <input type="file" 
                                                {{$nAttach == 'ON' ? 'required' : ''}}
                                                accept="image/*;capture=camera" 
                                                class="imageNoOdr form-control" 
                                                id="imageNoOdr"
                                                name="imageNoOdr" 
                                                style="width:100%;
                                                        border-top-right-radius:20px;
                                                        border-top-left-radius:20px;
                                                        visibility:none;
                                                        display:none;">
                                        <input type="hidden" id="attachParamNoOrder" value="{{$nAttach}}">
                                    </div>
                                -->
                            

                            <div class="mx-auto text-center">
                                <button type="submit" id="ga_checkout"  class="btn btn_login_form" >{{ __('Konfirmasi') }}</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>