<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$client->client_name}} | @yield('title')</title>

    <link rel="icon" href="{{asset('storage/'.$client->client_image)}}" type="image/x-icon">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" >
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style-r_1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive-r_1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">

    <!--image upload css-->
    <link rel="stylesheet" href="{{asset('css/images_upload.css')}}">

    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome JS -->
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <!--Aos Css-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-183852861-1"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <!-- Light Gallery Plugin Css -->
    <link href="{{asset('bsb/plugins/light-gallery/css/lightgallery.css')}}" rel="stylesheet">

    <style type="text/css">
        /*[class^='select2'] {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }*/

        .btn-circle {
            float: right;
            width: 30px;
            height: 30px;
            padding: 2px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 15px;
            line-height: 1.42857;
            right:2rem;
            top: 2rem;
            border: none;
        }

        #cekOut .modal-dialog-full-width {
            position:absolute;
            right:0;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width:none !important;
        }

        #cekOut .modal-content-full-width  {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #1A4066 !important 
        }

        .panel-custom>.panel-body {
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-color: #ddd;
            color:#000;
        }

        .alert{
            position:fixed;
            top:5%; 
            width:50%; 
            z-index:9999; 
            margin: 0 auto; 
            background: rgba(0, 0, 0, 0.7); 
            border:none; 
            color:#ffffff; 
            font-weight:bold;
        }
        
        .select2-container--default .select2-selection--single{
            padding:4px;
            outline: none;
            height: 37px;
            font-weight: 500;
            font-size: 1em; 
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px;
            right: 4px;
            width: 25px;
        }

        .select2-search__field{
            outline:none;
        }

        .select2-results { 
            background:transparent;
            font-weight: 600;
        }

        #LocationForm .modal-dialog-full-width {
            position:absolute;
            right:0;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width:none !important;
        }

        #LocationForm .modal-content-full-width  {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #1A4066 !important 
        }

        .borderless td, .borderless th {
            border: none;
        }
    
        .paddles {
        }

        .paddle {
            position: absolute;
            right: 0;
            top:35%;
            color: #fff;
            transition: all 0.4s;
            background: #000000;
            opacity: 0.4;
            border-radius: 50px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 1;
            outline: none;
            border:none;
            cursor: pointer;
        }
        
        .paddle:hover {
            background: #6a3137;
            color: #fff;
        }
        
        .left-paddle {
            left: 0;
        }
        .right-paddle {
            right: 0;
        }
        
        .paddles_hide {
            display: none;
        }

        

        .row::-webkit-scrollbar {
            height: 12px;
        }
        /* line 17, sass/page/_home.scss */
        .row::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }
        /* line 24, sass/page/_home.scss */
        .row::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #6a3137;
            -webkit-box-shadow: inset 0 0 6px #FDD8AF;
        }
        /* line 30, sass/page/_home.scss */
        .row::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(255, 0, 0, 0.4);
        }
        /*Hidden class for adding and removing*/
        .lds-dual-ring.hidden {
            display: none;
        }

        /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
        .overlay_ajax {
            position: fixed;
            left: 39%;
            top: 40%;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 9999;
            transition: all 0.5s;
        }
        @media(min-width:1366px){
            .overlay_ajax {
            left: 47%;
            }
            .preloader .loading {
            left: 40%;
            top: 40%;
            }  
        }

        @media(min-width:1920px){
            .overlay_ajax {
            left: 45%;
            }
            .preloader .loading {
            left: 42%;
            top: 42%;
            }  
        }
        
        .preloader{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #fff;
            opacity : 0.9;
        }

        .preloader .loading {
            position: absolute;
            left: 53%;
            top: 50%;
            transform: translate(-50%,-50%);
            font: 14px arial;
        }

        #fvpp-blackout {
            display: none;
            z-index: 9997;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: #000;
            opacity: 0.8;
        }

        #my-welcome-message {
            display: none;
            z-index: 9998;
            position: fixed;
            border-radius: 10px;
            width: 42%;
            left: 29%;
            top: 5%;
            padding: 0;
            background: #FDD8AF;
            box-shadow: 5px 10px 18px #0000;
        }

        .button_welcome {
            background: linear-gradient(to bottom, #6a3137, #6a3137); 
            color:white; 
            padding: 5px 15px; 
            border:none; 
            box-shadow: 2px 2px 2px grey; 
            border-radius: 14px;
            font-size: 15px;
            font-weight: 800; 
            position: absolute;
            top: 70px;
            right: 20px;
        }

        .button_welcome:hover {
            outline:0px !important;
            -webkit-appearance:none;
            -webkit-transform: translateY(-3px);
            transform: translateY(-3px);
            box-shadow: 0 0.3rem 1rem rgba(0, 0, 0, 0.3); 
        }

        @media (max-width: 2560px){
            .button_welcome {
                font-size: 34px;
                padding: 12px 26px;
                top: 42rem;
                right: 12%;
                font-weight: 600;
                border-radius: 20px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1920px){
            .button_welcome {
                font-size: 25px;
                padding: 10px 25px;
                top: 32rem;
                right: 12%;
                font-weight: 600;
                border-radius: 17px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1440px){
            .button_welcome {
                font-size: 21px;
                padding: 10px 17px;
                top: 24rem;
                right: 10%;
                font-weight: 600;
                border-radius: 15px;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1366px){
            .button_welcome {
                font-size: 19px;
                padding: 10px 17px;
                top: 22.4rem;
                right: 10%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 5%;
            }
        }

        @media (max-width: 1024px){
            .button_welcome {
                font-size: 15px;
                padding: 10px 17px;
                top: 17rem;
                right: 9%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 42%;
                left: 29%;
                top: 10%;
            }
        }

        @media (max-width: 768px){
            .button_welcome {
                font-size: 15px;
                padding: 10px 17px;
                top: 18.2rem;
                right: 9.5%;
                font-weight: 600;
                border-radius: 14px;
            }

            #my-welcome-message {
                width: 60%;
                left: 20%;
                top: 20%;
            }
        }

        @media (max-width: 600px){
            .button_welcome {
                font-size: 15px;
                padding: 7px 18px;
                top: 27rem;
                right: 13%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 90%;
                left: 5%;
                top: 5%;
            }

            .btn-circle{
                width: 20px;
                height: 20px;
                font-size: 10px;
                padding: 3px 0px;
                right:1rem;
                top: 1rem;
            }

            #cekOut .col-md-2{
                width: 40%;
            }
            
        }

        @media (max-width: 480px){
            .button_welcome {
                font-size: 12px;
                padding: 7px 15px;
                top: 21.5rem;
                right: 13%;
                font-weight: 600;
            }

            #my-welcome-message {
                top: 2%;
            }
        }

        @media (max-width: 425px){
            .button_welcome {
                font-size: 11px;
                padding: 7px 15px;
                top: 19rem;
                right: 12%;
                font-weight: 600;
            }

            #my-welcome-message {
                width: 90%;
                left: 5%;
                top: 5%;
            }
        }

        @media (max-width: 411px){
            .button_welcome {
                font-size: 11px;
                padding: 7px 14px;
                top: 18.5rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 384px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 13px;
                top: 17.2rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 375px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 13px;
                top: 16.8rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 364px){
            .button_welcome {
                font-size: 10px;
                padding: 7px 12px;
                top: 16.4rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 338px){
            .button_welcome {
                font-size: 9px;
                padding: 7px 12px;
                top: 15.4rem;
                right: 12%;
                font-weight: 600;
            }
        }

        @media (max-width: 320px){
            .button_welcome {
                font-size: 8px;
                padding: 7px 12px;
                top: 14.5rem;
                right: 12%;
                font-weight: 600;
            }
        }
    
        #product_list .ribbon {
            position: absolute;
            left: -5px; top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 200px; height: 200px;
            text-align: right;
        }

        #product_list .span-ribbon {
            font-size: 20px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 40px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            width: 225px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#F79E05 0%, #8F5408 100%);
            box-shadow: 0 6px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 40px; left: -52px;
        }

        #product_list .span-ribbon::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 7px solid #8F5408;
            border-right: 7px solid transparent;
            border-bottom: 7px solid transparent;
            border-top: 7px solid #8F5408;
        
        }
        
        #product_list .span-ribbon::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 7px solid transparent;
            border-right: 7px solid #8F5408;
            border-bottom: 7px solid transparent;
            border-top: 7px solid #8F5408;
        
        }

        @media(max-width: 768px){
            #product_list .ribbon {
            position: absolute;
            left: -5px; top: -5px;
            z-index: 1;
            overflow: hidden;
            width: 75px; height: 75px;
            text-align: right;
            }
            #product_list .span-ribbon {
            font-size: 10px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            text-align: center;
            line-height: 20px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            width: 100px;
            display: block;
            background: #79A70A;
            background: linear-gradient(#F79E05 0%, #8F5408 100%);
            box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
            position: absolute;
            top: 19px; left: -21px;
            }
            #product_list .span-ribbon::before {
            content: "";
            position: absolute; left: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid #8F5408;
            border-right: 3px solid transparent;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #8F5408;
            }
            #product_list .span-ribbon::after {
            content: "";
            position: absolute; right: 0px; top: 100%;
            z-index: -1;
            border-left: 3px solid transparent;
            border-right: 3px solid #8F5408;
            border-bottom: 3px solid transparent;
            border-top: 3px solid #8F5408;
            }
        }
    </style>
    <script>
        $(document).ready(function(){
          $(".preloader").fadeOut();
        })
    </script>
</head>
<body>
     <!--catalog & attachment query-->
    @php
        $catalog = App\Http\Controllers\SalesHomeController::catalog(\Auth::user()->client_id);
        $nAttach = App\Http\Controllers\SalesHomeController::attachOrder(\Auth::user()->client_id); 
    @endphp

    @if($catalog)
        @include('customer.layouts.catalog')
    @endif
    
    @include('customer.modal-checkout-no-order')

    <!--preloader-->
    <div class="preloader" id="preloader">
        <div class="loading">
          <img src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader">
          <p style="font-weight:900;line-height:2;color:#1A4066;margin-left: -10%;">Harap Tunggu</p>
        </div>
    </div>

    <div id="loader" class="lds-dual-ring hidden overlay_ajax"><img class="hidden" src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader"></div>
    

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <img src="{{ asset('assets/image/sp-sidebar.png') }}" class="sidebar-dot-top-right"  
            style="" alt="sp-sidebar">
            <div class="sidebar-header">
                <a href="{{url('/') }}" >
                    @if(\Auth::user())
                        @if(\Auth::user()->avatar)
                            <img class="rounded-circle" src="{{asset('storage/'.Auth::user()->avatar)}}" alt="user" />
                        @else
                        <img src="{{asset('assets/image/image-noprofile.png')}}" alt="user"/>
                        @endif
                    @endif
                </a>
                <p class="mt-4">{{\Auth::user()->name}}</p>
            </div>
            <ul class="list-unstyled components">
                <li class="">
                    <a href="{{route('dash-sales',[$vendor])}}">Dashboard</a>
                </li>
                <li class="">
                   <a href="{{ url('/') }}">Beranda</a>
                </li>
                <!--
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Paket</a>
                    <ul class="collapse list-unstyled page-submenu" id="pageSubmenu">
                        foreach($paket as $paket_menu)
                            <li>
                                <a href="route('home_paket', ['paket'=>$paket_menu->id] )}}" style="">$paket_menu->display_name}}</a>
                            </li>
                        endforeach
                    </ul>
                </li>
                -->
                @if($paket != null)
                    <li>
                        <a href="{{URL::route('home_paket',[$vendor])}}">Paket</a>
                    </li>
                @endif
                
                <li>
                   <a href="{{URL::route('profil.index',[$vendor])}}">Profile</a>
                </li>
                <li>
                    <a href="{{URL::route('session.clear',[$vendor])}}">Ubah Lokasi / Toko</a>
                 </li>
                <li>
                    <a href="{{URL::route('contact',[$vendor])}}">Kontak Kami</a>
                </li>
                
                <li>
                    <a href="{{URL::route('pesanan',[$vendor])}}">Pesanan</a>
                </li>

                <!--catalog menu-->
                @if(count($catalog) > 0)
                    <li>
                        <a href="#" data-toggle="modal" data-target="#catalogModal" 
                        onclick="show_catalog()">Katalog</a>
                    </li>
                @endif

                <li class="mt-4">
                    @if (!session()->has('ses_order'))
                        <a href="{{ url('/') }}" class="btn logout">
                            Check Out
                        </a>
                    @else
                        <a class="btn logout" data-toggle="modal" onclick="show_modal_chekout()">
                            Check Out
                        </a>
                    @endif
                    
                <li>
                
                <li class="mt-4">
                    <a href="{{route('log-out')}}" onclick="logout_record()">
                        <i class="fas fa-sign-out-alt "></i> Keluar
                    </a>
                <li>
            </ul>
            
             <img src="{{ asset('assets/image/sp-sidebar-bottom.jpg') }}" class="sidebar-dot-bottom"  
             style="" alt="sp-sidebar-bottom"> 
        </nav>
        <div class="overlay"></div>

        <nav class="navbar navbar-expand-lg fixed-top" style="z-index: 1.5;">
            <div class="container">
                <button type="button" id="sidebarCollapse" class="btn button-burger-menu ">
                    <i class="fas fa-bars fa-2x d-none d-md-block d-md-none" style="color:#1A4066;"></i>
                    <i class="fas fa-bars fa-1x d-md-none" style="color:#1A4066;"></i>
                </button>
                
            </div>
        </nav>
        
        <!--content-->
        <div id="content">
            <div role="main">
                <!--
                <div class="container button-burger-menu-nocart">
                    <button type="button" id="sidebarCollapse" class="btn button-burger-menu-nocart">
                        <i class="fas fa-bars fa-2x d-none d-md-block d-md-none" style="color:#1A4066;"></i>
                        <i class="fas fa-bars fa-1x d-md-none" style="color:#1A4066;"></i>
                    </button>
                </div>
                -->
                @yield('content')
            </div>
        </div>

    </div>

    <div id="message" class="row justify-content-center"></div>
    <img src="{{ asset('assets/image/dot-top-right-profil.jpg') }}" class="dot-top-right-nocart"  
    style="" alt="dot-top-right-profil">
    <img src="{{ asset('assets/image/dot-bottom-left-profil.jpg') }}" class="dot-bottom-left-nocart"  
    style="" alt="dot-bottom-left-profil">
    <img src="{{ asset('assets/image/shape-profil-bottom.jpg') }}" class="shape-bottom-right-nocart"  
    style="" alt="shape-profil-bottom">

    
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <!-- Light Gallery Plugin Js -->
    <script src="{{asset('bsb/js/pages/medias/image-gallery.js')}}"></script>
    <script src="{{asset('bsb/plugins/light-gallery/js/lightgallery-all.js')}}"></script>

    <script src="{{ asset('js/fileinput.js')}}" type="text/javascript"></script>
    @yield('footer-scripts')

    
    <!--<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>-->
    
    <!--<script src="{{ asset('assets/js/jquery.firstVisitPopup.js')}}"></script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
    
    <script type="text/javascript">
        $(function () {
            $('.popoverDokumen').popover({
                container: 'body'
            })
        });

        $(document).ready(function(){
            $(window).scroll(function(){
                var scroll = $(window).scrollTop();
                if (scroll > 50) {
                    $(".navbar").css("background" , "#1A4066");
                    $(".fa-bars").css("color" , "#fff");
                    $(".navbar").css("opacity" , "0.9");
                    
                }

                else{
                    $(".navbar").css("background" , "transparent");
                    $(".fa-bars").css("color" , "#1A4066");  	
                }
            })
        });

        //sidebar
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        //Select2 Reasons check out
        $('#reasons_id').select2({
        placeholder: 'Pilih Alasan',
        language: {
        noResults: function() {
            return '&nbsp;Data Tidak Ditemukan';
            },
        },
        escapeMarkup: function(markup) {
            return markup;
        },
        ajax: {
            url: '{{URL::to('/ajax/reasons')}}',
            
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                            id: item.id,
                            text: item.reasons_name,
                            
                    }
                })
            };
            }
        }
        });
        
        
        function show_modal()
        {
            //$( "#collapse-4" ).load(window.location.href + " #collapse-4" );
            var order_id = $('#order_id_cek').val();
            var total_pesan_val_hide = $('#total_pesan_val_hide').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/cek_order')}}',
                type:'POST',
                dataType: 'json',
                data:{
                    order_id : order_id,
                },
                success: function(response){
                    var len = 0;
                    $('#body_alert').empty();
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        
                        for(var i=0; i<len; i++){
                            var desc = response['data'][i].description;
                            
                            var tr_str = "<li class='text-center'><small>"+desc+"</small></li>";
                            $("#body_alert").append(tr_str);
                        }
                        $("#modal_validasi").modal('show');
                    }
                    else
                    {
                        $("#my_modal_content").modal('show');
                        $('#total_pesan_val').val(total_pesan_val_hide);
                        $('#order_id_pesan').val(order_id);
                        //$("#my_modal_content_ajax").modal('show');
                        //$("#my_modal_content_ajax").modal('show');
                    }
                }
            });
        }

        $(document).ready(function() {  
            $('#btn-yes').on('click', function(){
                var id_modal = $("#modal-input-id").val();
                Swal.fire('Yes!');
            });
        });
        
        function search_order(){
            var query = $('#src_order').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{URL::to('/sales/order_search')}}',
                method:'POST',
                data:{
                        query:query,
                     },
                //dataType:'json',
                success:function(data)
                {
                    //$('tbody').html(data.table_data);
                    $('tbody').html(data);
                    //$('#total_records').text(data.total_data);
                }
            });
        }

        function open_detail_list(order_id){
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url : '{{URL::to('/pesanan/detail')}}',
                type:'POST',
                data:{
                    order_id : order_id,
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },              
                success: function (response){
                    $("#modalDetilList").modal('show');
                    $('#DataListOrder' ).html(response);
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').addClass('hidden');
                },
                
                error: function (response) {
                console.log('Error:', response);
                }
            });
        }

        function cancel_status(order_id)
        {
            $("#modalNotesCancel").modal('show');
            $('#OrderIdCancel').val(order_id);
            $("#modalDetilList").modal('hide');
        }

        function wa_cancel()
        {
            
            //var order_id = $('#OrderIdCancel').val();
            var notes = $('#notes_cancel').val();
            if (notes != "") {
                $('#modalNotesCancel').modal('hide');
                Swal.fire({
                            //title: 'Berhasil',
                            text: "Pesanan berhasil dibatalkan",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: "OK",
                            confirmButtonColor: '#4db849'
                            }).then(function(){ 
                                window.location.href = '{{URL::to('/pesanan/cancel/success')}}';
                            });
            }
        }

        function show_modal_chekout(){
            $.ajax({
                url : '{{URL::to('/keranjang/preview_checkout')}}',
                
                              
                success: function (response){
                    //$("#modalDetilList").modal('show');
                    $("#cekOut").modal('show');
                    $('#sidebar').removeClass('active');
                    $('.overlay').removeClass('active');
                    $('#PreviewToko_CheckOut' ).html(response);
                    var diswa = $('#dsbl_btn_checkout' ).val();
                    if (diswa.length > 0) {
                        $('#ga_checkout').attr("disabled", 'disabled');
                    }
                },
                error: function (response) {
                console.log('Error:', response);
                }
            });
        }

        function show_catalog(){
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        }

        function logout_record(){
            $.ajax({
                url : '{{URL::to('/sales/logout-record')}}',
            });
        }

        function openItemNotAchieved(csId,period){
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url : '{{URL::to('/dashboard/detail-item-target')}}',
                type:'POST',
                data:{
                    csId : csId,
                    period : period,
                },
                /*beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },*/              
                success: function (response){
                    $("#detilItemTidakCapai").modal('show');
                    $('#listItemTidakCapai' ).html(response);
                },
                /*complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').addClass('hidden');
                },*/
                
                error: function (response) {
                console.log('Error:', response);
                }
            });
        }

        //validate  No Order
        var _validFileExtensions = [".jpg", ".jpeg", ".png"];
        function ValidateNoOdr(oForm) {
            var arrInputs = oForm.getElementsByClassName("imageNoOdr");
            //var file = document.getElementById('imagePo').files[0].name;
            for (var i = 0; i < arrInputs.length; i++) {
                var oInput = arrInputs[i];
                if (oInput.type == "file") {
                    var sFileName = oInput.value;
                    if (sFileName.length > 0) {
                        var blnValid = false;
                        for (var j = 0; j < _validFileExtensions.length; j++) {
                            var sCurExtension = _validFileExtensions[j];
                            if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                                blnValid = true;
                                break;
                            }
                        }
                        
                        if (!blnValid) {
                            //alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                            Swal.fire({
                                icon: 'error',
                                text: 'Maaf,  Jenis file dokumen tidak diizinkan...(ekstensi yang diizinkan adalah'+ _validFileExtensions.join(", ")+') ',
                                
                                });
                            return false;
                        }else{
                            Swal.fire({
                                title: 'Berhasil',
                                text: "Anda sudah checkout tanpa order",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                confirmButtonColor: '#4db849'
                                });
                        }
                    }else{
                            Swal.fire({
                                title: 'Berhasil',
                                text: "Anda sudah checkout tanpa order",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                confirmButtonColor: '#4db849'
                                });
                        }
                }
            }
            
            return true;
            
        }

    /*
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(".alert").slideUp(500); 
        });
        }, 6000);*/
    </script>
    <script>
        /*
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-183852861-1');
        */
    </script>
</body>

</html>