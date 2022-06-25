<style>
    #catalogModal .modal-header{
        border-top-right-radius: 20px;
        border-top-left-radius: 20px;
    }
    .toast-copied {
        left: 50%;
        position: fixed;
        transform: translate(-50%, 0px);
        z-index: 9999;
        border: none;
        border-radius:5px;
    }
    @media (max-width: 425px){
        .col-image-catalog{
            padding-left:40px;
            padding-right:40px;
        }
        .col-title-catalog{
            text-align: center;
        }
    }
</style>

<div class="modal fade modal-fixed-footer"  id="catalogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog-full-width modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content-full-width modal-content" style="border-radius: 20px;">
            <div class="modal-header" style=" background-color: #dbf6e9;">
                <h6 class="modal-title font-weight-bold">Daftar Katalog</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="toast toast-copied" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000" >
                        <div class="toast-body" style="background:#000000;border-radius: 5px;">
                            <strong class="mr-auto text-white">URL Copied!</strong>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($catalog as $ctlg)
                            <div class="col-lg-6  my-lg-2 my-3 d-flex">
                                <div class="card catalog-card float-right" style="">
                                    <a href="{{$ctlg->url}}" target="_blank" style="text-decoration: none;">
                                        <div class="row">
                                            <div class="col-sm-5 my-auto col-image-catalog">
                                                @switch($ctlg->type)
                                                    @case('PDF')
                                                        <img class="d-block w-100" src="{{ asset('assets/image/catalog-pdf.png') }}" alt="">
                                                        @break
                                                    @case('IMAGE')
                                                        <img class="d-block w-100" src="{{ asset('assets/image/catalog-image-vodeo.png') }}" alt="">
                                                        @break
                                                    @case('VIDEO')
                                                        <img class="d-block w-100" src="{{ asset('assets/image/catalog-image-vodeo.png') }}" alt="">
                                                        @break
                                                    @case('OTHERS')
                                                        <img class="d-block w-100" src="{{ asset('assets/image/catalog-default.png') }}" alt="">
                                                        @break
                                                    @default
                                                        <img class="d-block w-100" src="{{ asset('assets/image/catalog-default.png') }}" alt="">
                                                @endswitch
                                                
                                            </div>
                                            <div class="col-sm-7 col-title-catalog">
                                                <div class="card-block">
                                                    <!--           <h4 class="card-title">Small card</h4> -->
                                                    <p class="catalog-text-p" style="font-weight:700;color: #153651;font-family: Montserrat;">{{$ctlg->name}}</p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="card-footer px-0" style="border:none; background-color:transparent;">
                                        <input type="text" value="{{$ctlg->url}}" id="urlTxtCopied{{$ctlg->id}}" style="display:none">
                                        <div class="badge badge-dark float-right">
                                            <a onclick="urlCopy('{{$ctlg->id}}')">Copy URL</a>
                                        </div>
                                        <!--
                                        <small class="text-muted ml-0 text-copied-catalog{{$ctlg->id}}"></small>
                                        -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function urlCopy(id) {
        /* Get the text field */
        //var copyText = $('urlTxtCopied'+id).val();
        var copyText = document.getElementById('urlTxtCopied'+id);
        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);
        
        /* Alert the copied text */
        //$('.text-copied-catalog'+id).text("URL copied!");
        $('.toast').toast('show');
    }
</script>