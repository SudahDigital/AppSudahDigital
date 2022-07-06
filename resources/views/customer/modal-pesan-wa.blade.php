<!-- Modal pesan wa--> 
<div class="modal fade right ml-0" id="my_modal_content" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
        <div class="modal-content-full-width modal-content ">
            <div class="modal-body">
                <div id="message" class="row justify-content-center"></div>
                <img src="{{ asset('assets/image/dot-top-right-profil.jpg') }}" class="dot-top-right-nocart"  
                style="" alt="dot-top-right-profil">
                <img src="{{ asset('assets/image/dot-bottom-left-profil.jpg') }}" class="dot-bottom-left-nocart"  
                style="" alt="dot-bottom-left-profil">
                <img src="{{ asset('assets/image/shape-profil-bottom.jpg') }}" class="shape-bottom-right-nocart"  
                style="" alt="shape-profil-bottom">
                <button type="button" class="btn btn-warning btn-circle" data-dismiss="modal" style="position:absolute;z-index:99999;"><i class="fa fa-times"></i></button>
                <!--
                <img src="{{ asset('assets/image/dot-top-right.png') }}" class="dot-top-right"  
                style="" alt="dot-top-right">
                <img src="{{ asset('assets/image/dot-bottom-left.png') }}" class="dot-bottom-left"  
                style="" alt="dot-bottom-left">
                <img src="{{ asset('assets/image/shape-bottom-right.png') }}" class="shape-bottom-right"  
                style="" alt="shape-bottom-right">
                <button type="button" class="btn btn-warning btn-circle" data-dismiss="modal" style="position:absolute;z-index:99999;"><i class="fa fa-times"></i></button>
                -->
                <div class="container image-logo-confirm">
                    <div class="d-flex justify-content-start mx-auto">
                        <div class="col-md-1" style="z-index: 2">
                            <img src="{{asset('storage/'.$client->client_image)}}" class="img-thumbnail" style="background-color:transparent; border:none;position:absolute;" alt="image logo">  
                        </div>
                    </div>
                </div>
                

                <div class="col-md-12 login-label py-3 label-confirm mb-4 mt-4" style="z-index: 4">
                    <h3 style="color: #1A4066 !important;">Konfirmasi Pesanan</h3>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-md-5 login-label label-confirm mt-4" style="z-index: 4">
                        <div id="PreviewToko_Produk" style="overflow: hidden;">
                            
                        </div>
                        
                        <form class="form-inline" enctype="multipart/form-data" 
                            method="POST" id="ga_pesan_form" target="_BLANK" 
                            action="{{ route('customer.keranjang.pesan',[$vendor]) }}"
                            onsubmit="return ValidatePo(this);">
                            @csrf
                            
                            <div class="col-md-12 px-0 mb-4">
                                <div class="upload-card">
                                    
                                    <div class="file-upload">
                                        <div class="file-select">
                                            <div class="imagePreview mb-1 img-thumbnail"></div>
                                            <!--
                                            <button class="btn btn-secondary btn-sm" >
                                                <i class="fa fa-camera" aria-hidden="true"></i>
                                            </button>
                                            -->
                                            <div class="file-select-name text-dark">Select Camera/File</div>
                                            <input type="file" 
                                                    id="imagePo" 
                                                    name="imagePo[]"  
                                                    class="profileimg imagePo"
                                                    accept="image/*;capture=camera"
                                                    {{$attach == 'ON' ? 'required' : ''}}
                                                    oninvalid="this.setCustomValidity('Wajib sertakan dokumen PO')"
                                                    oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-footer">
                                    <div class="row" >
                                        <div class="col-6 col-md-6">
                                            <b style="color: #1A4066 !important;
                                                     font-weight:600;
                                                     font-size:14px;">
                                                &nbsp;
                                            </b>
                                        </div>
                                        <div class="col-6 col-md-6 text-right">
                                            <a class="btn btn-primary mb-3 file-add btn-sm popoverDokumen" 
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
                            <input type="hidden" id="attachParam" value="{{$attach}}">
                            <!--====================================== --->
                            <!--cam capture
                                <div class="col-md-12 px-0 mb-1">
                                    <img id="preview-image-before-upload" src="{{asset('assets/image/2428676_frame_gallery_image_landscape_mobile_icon.png')}}"
                                        alt="preview image" class="img-thumbnail">
                                </div>
                                
                                <div class="col-12 mb-4 px-0">
                                    <label class="float-left" for="imagePo" 
                                            style="color: #1A4066 !important;
                                                cursor:pointer;">
                                        <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                                    </label>
                                    <p class="text-left mt-2" style="color: #1A4066 !important; margin-left:50px;">
                                        Unggah dokumen PO
                                    </p>
                                    <input type="file" 
                                            {{$attach == 'ON' ? 'required' : ''}}
                                            accept="image/*;capture=camera" 
                                            class="imagePo form-control" 
                                            id="imagePo"
                                            name="imagePo" 
                                            style="width:100%;
                                                    border-top-right-radius:20px;
                                                    border-top-left-radius:20px;
                                                    visibility:none;
                                                    display:none;">
                                </div>
                                <input type="hidden" id="attachParam" value="{{$attach}}">
                            -->
                            
                            <div class="col-md-5 px-0 pt-3">
                                <p class="text-left mb-1" style="color: #1A4066 !important;">Pilih Metode Pembayaran</p>
                            </div>
                            @if($item!==null)
                            <input type="hidden" name ="voucher_code_hide_modal" id="voucher_code_hide_modal">
                            <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                            <input type="hidden" name="total_pesanan" id="total_pesan_val" value="{{$item->total_price}}">
                            @else
                                <input type="hidden" name ="voucher_code_hide_modal"  id="voucher_code_hide_modal">
                                <input type="hidden" name="total_novoucher" id="total_novoucher_val">
                                <input type="hidden" name="total_pesanan" id="total_pesan_val" >
                            @endif
                            <div class="col-md-7 p-0 ">
                                <select name="check_tunai_value"  id="check_tunai" style="width:100%;" class="form-control" required>
                                    <option data-icon="fa-check-circle" value="Cash">&nbsp;&nbsp;Cash</option>
                                    <option data-icon="fa-check-circle" value="TOP">&nbsp;&nbsp;TOP</option>
                                    <!--
                                    <option data-icon="fa-check-circle" value="TOP 7 Days">&nbsp;&nbsp;TOP 7 Days</option>
                                    <option data-icon="fa-check-circle" value="TOP 14 Days">&nbsp;&nbsp;TOP 14 Days</option>
                                    <option data-icon="fa-check-circle" value="TOP 30 Days">&nbsp;&nbsp;TOP 30 Days</option>
                                    -->
                                </select>
                            </div>
                            <div class="col-md-12 px-0 mt-4">
                                <div class="form-group">
                                    <textarea name="notes" class="form-control p-3" rows="5" placeholder="Note..."
                                        style="width: 100%;
                                        border-top-left-radius:25px;
                                        border-top-right-radius:25px;
                                        border-bottom-right-radius:0;
                                        border-bottom-left-radius:0;">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12 px-0 mt-2">
                                <input type="hidden" id="order_id_pesan" name="id" value="{{$item !==null ? $item->id : ''}}"/>
                                @if($message)
                                <!--
                                    <button type="submit" id="ga_pesan" onclick="pesan_wa()" class="btn btn-success float-right btn-preview-order">
                                        <i class="fab fa-whatsapp fa-1x" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i>
                                        &nbsp;{{__('Pesan Sekarang') }}
                                    </button>
                                -->
                                    <button type="submit" id="ga_pesan"  class="btn btn-success float-right btn-preview-order">
                                        <i class="fab fa-whatsapp fa-1x" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i>
                                        &nbsp;{{__('Pesan Sekarang') }}
                                    </button>
                                @else
                                    <a id="popoverData" class="btn btn-success float-right btn-preview-order"
                                        data-trigger="hover" data-container="body" data-placement="top" 
                                        data-content="Maaf anda tidak dapat mengirim pesanan, format pesan whatsapp belum dibuat.">
                                        <i class="fab fa-whatsapp fa-1x" aria-hidden="true" style="color: #ffffff !important; font-weight:900;"></i>
                                        &nbsp;{{__('Pesan Sekarang') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                        <button type="submit" onclick="cancel_wa()" class="btn btn-danger btn-preview-cancel"
                            style="">
                            <i class="fa fa-times fa-1x" aria-hidden="true" style="color:#fff;font-weight:900;">
                            </i>&nbsp;{{__('Batalkan Pesanan') }}
                        </button>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>