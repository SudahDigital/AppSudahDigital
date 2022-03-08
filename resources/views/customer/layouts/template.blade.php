<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$client->client_name}} | @yield('title')</title>

    <link rel="icon" href="{{asset('storage/'.$client->client_image)}}" type="image/x-icon">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" >
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style-r_1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/responsive-r_1.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <!-- Font Awesome JS -->
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.13.0/css/all.css"
      integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V"
      crossorigin="anonymous"
    />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <!--Aos Css-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-183852861-1"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MSWC453');</script>
    <!-- End Google Tag Manager -->
    <style type="text/css">
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

        .searchbar {
            position: relative;
            min-width: 40px;
            width: 0%;
            height: 40px;
            float: right;
            overflow: hidden;
            -webkit-transition: width 0.3s;
            -moz-transition: width 0.3s;
            -ms-transition: width 0.3s;
            -o-transition: width 0.3s;
            transition: width 0.3s
        }

        .searchbar-input {
            top: 0;
            right: 0;
            border: 0;
            outline: 0;
            background: #fff;
            width: 100%;
            height: 40px;
            margin: 0;
            font-size: 20px;
            color: #1A4066;
            
        }

        .searchbar-input::-webkit-input-placeholder {
            color: #1A4066
        }

        .searchbar-input:-moz-placeholder {
            color: #1A4066
        }

        .searchbar-input::-moz-placeholder {
            color: #1A4066
        }

        .searchbar-input:-ms-input-placeholder {
            color: #1A4066
        }

        .searchbar-icon,
        .searchbar-submit {
            width: 40px;
            height: 40px;
            display: block;
            position: absolute;
            top: 0;
            font-family: Montserrat;
            font-size: 20px;
            right: 0;
            padding: 0;
            margin: 0;
            border: 0;
            outline: 0;
            line-height: 40px;
            text-align: center;
            cursor: pointer;
            color: #1A4066;
            /*background: #1A4066;*/
            background:#fff;
            border-left: none;
            font-weight: bold;
        }

        .searchbar-open {
            width: 95%
        }

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
        }

        .btn-warning {
            background-color: #1A4066;
            opacity: 0.7;
            border-color: #fff;
            color:#fff;
        }

        .btn-warning:hover{
            background-color: #fff;
            border-color: #fff;
        }
        
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

        button#no-results-btn {
            width: 100%;
            height: 100%;
            padding: 6px;
        }

        /* Make button look like other li elements */
        button#no-results-btn {
            border: 0;
            background-color: #DADADA;
            text-align: left;
            font-weight: 600;
        }

        button#no-results-btn:hover {
            background-color: #5897fb;
        }
        
        .checkbox-lg .custom-control-label::before, 
        .checkbox-lg .custom-control-label::after {
        top: .8rem;
        width: 1.55rem;
        height: 1.55rem;
        }

        .checkbox-lg .custom-control-label {
        padding-top: 13px;
        padding-left: 6px;
        }


        .checkbox-xl .custom-control-label::before, 
        .checkbox-xl .custom-control-label::after {
        top: 1.2rem;
        width: 1.85rem;
        height: 1.85rem;
        }

        .checkbox-xl .custom-control-label {
        padding-top: 23px;
        padding-left: 10px;
        }
        /*[class^='select2'] {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }*/
        .panel-custom>.panel-body {
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-color: #ddd;
            color:#000;
        }

        .select2-selection--single {
            /*height: 100% !important;*/
            overflow: hidden;
            text-overflow: ellipse;
        }

        .select2-selection__rendered{
            word-wrap: break-word !important;
            text-overflow: inherit !important;
            white-space: normal !important;
        }
        
        .select2-container--default .select2-selection--single{
            padding:4px;
            outline: none;
            height: 37px;
            font-weight: 500;
            font-size: 16px; 
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

        .select2-results__options { max-height: 100px !important;}

        
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
        
        #storeForm .modal-dialog-full-width {
            position:absolute;
            right:0;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width:none !important;
        }

        #storeForm .modal-content-full-width  {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #1A4066 !important 
        }

        #my_modal_content .modal-dialog-full-width {
            position:absolute;
            right:0;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width:none !important;
        }

        #my_modal_content .modal-content-full-width  {
            height: auto !important;
            min-height: 100% !important;
            border-radius: 0 !important;
            background-color: #fff !important 
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

        .paddle_pop {
            position: absolute;
            right: 0;
            top:33%;
            color: #fff;
            transition: all 0.4s;
            background:none;
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

        .paddle_pop_bonus {
            position: absolute;
            right: 0;
            bottom:10%;
            color: #fff;
            transition: all 0.4s;
            background:none;
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

        .paddle_pop:focus {
            outline:0; /* I have also tried outline:none */
            -webkit-appearance:none;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .paddle_pop_bonus:focus {
            outline:0; /* I have also tried outline:none */
            -webkit-appearance:none;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }
        
        .paddle:hover {
            background: #4b6b9e;
            color: #fff;
        }
        
        .left-paddle {
            left: 0;
        }

        .left-paddle_pop {
            left: 0;
        }

        .left-paddle_pop_bonus {
            left: 0;
        }

       .right-paddle {
            right: 0;
        }

        .right-paddle_pop {
            right: 0;
        }

        .right-paddle_pop_bonus {
            right: 0;
        }
        
        .paddles_hide {
            display: none;
        }

        .paddles_hide_pop {
            display: none;
        }

        .paddles_hide_pop_bonus {
            display: none;
        }

        .row::-webkit-scrollbar {
            height: 8px;
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
            background: #8c8e91;
            -webkit-box-shadow: inset 0 0 6px #ffff;
        }
        /* line 30, sass/page/_home.scss */
        .row::-webkit-scrollbar-thumb:window-inactive {
            background: rgba(45, 88, 129, 0.4);
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
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            font: 14px arial;
        }

        .carousel-inner{
            max-height: 800px;
        }

        .bell-icon-right{
            position: absolute;
            right: 7%;
        }
        .dropdown-menu-nav {display: block;
            visibility: hidden;
            opacity:0;transform: 
            translateY(50px);
            transition:.5s ease all;
            width: 300px;
        }
        .dropdown-menu-nav.show {
            display: block;
            visibility: visible;
            opacity:1;transform: 
            translateY(0px);
            transition:.5s ease all;
        }
        .dropdown-toggle:after { content: none }

        .radio-claim {
            display: none;
            &:not(:disabled) ~ label {
                cursor: pointer;
            }
            &:disabled ~ label {
                color: hsla(150, 5%, 75%, 1);
                border-color: hsla(150, 5%, 75%, 1);
                box-shadow: none;
                cursor: not-allowed;
            }
        }

        .label-radio-claim {
            height: 100%;
            display: block;
            background: white;
            border: 1px solid hsla(150, 75%, 50%, 1);
            border-radius: 20px;
            
            margin-bottom: 1rem;
            /*margin: 1rem;*/
            text-align: center;
            box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
            position: relative;
        }
        
        .radio-claim:checked + label {
        background: hsla(150, 75%, 50%, 1);
        color: hsla(215, 0%, 100%, 1);
        box-shadow: 0px 0px 20px hsla(150, 100%, 50%, 0.75);
        &::after {
            color: hsla(215, 5%, 25%, 1);
            font-family: FontAwesome;
            border: 2px solid hsla(150, 75%, 45%, 1);
            content: "\f00c";
            font-size: 24px;
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            height: 50px;
            width: 50px;
            line-height: 50px;
            text-align: center;
            border-radius: 50%;
            background: white;
            box-shadow: 0px 2px 5px -2px hsla(0, 0%, 0%, 0.25);
            }
        }

        .modal-fixed-footer .modal-body {
            max-height: 70vh; /* max 80% of the viewport height */
            overflow-y: auto;
        }

        .notification-box{
            padding: 10px 0px;
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

            .searchbar-open {
                width: 90.5%
            }

            .bell-icon-right{
                right: 30%;
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

            .searchbar-open {
                width: 90.5%
            }

            .bell-icon-right{
                right: 23%;
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

            .searchbar-open {
                width: 90.5%
            }

            .bell-icon-right{
                right: 15%;
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

            .overlay_ajax {
            left: 47%;
            }

            .preloader .loading {
            left: 50%;
            top: 50%;
            } 
            
            .searchbar-open {
                width: 90%
            }

            .bell-icon-right{
                right: 10%;
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

            .searchbar-open {
                width: 88%
            }

            .bell-icon-right{
                right: 5%;
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

            .searchbar-open {
                width: 85%
            }

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

        @media(max-width: 767px){
            
            .searchbar-input {
                height: 25px;
                font-size: 14px;
            }

            .searchbar {
               min-width: 25px;
               height: 25px;
            }

            .searchbar-icon,
            .searchbar-submit {
                width: 25px;
                height: 25px;
                display: block;
                position: absolute;
                top: 0;
                font-size: 14px;
                line-height: 27px;
                font-weight: bold;
                
            }
        }

        @media (max-width: 759px){
            .bell-icon{
                font-size: 22px;
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

            .swal2-toast{
                /*font-size: 10px !important;*/
                width:420px !important;
                max-width: 100% !important;
            }

            .btn-circle{
                width: 20px;
                height: 20px;
                font-size: 10px;
                padding: 3px 0px;
                right:1rem;
                top: 1rem;
            }

            .dropfilter{
                margin-top: 11px;
            }
            
        }

        @media (max-width: 540px){
            .left-paddle {
             left: 10px;
            }

            .paddle_pop{
                top:27%;
            }

            .paddle_pop_bonus{
                bottom:13%;
            }

            .left-paddle_pop {
                left: -1rem;
            }

            .left-paddle_pop_bonus {
                left: -1rem;
            }

            .right-paddle_pop {
                right: -1rem;
            }

            .right-paddle_pop_bonus {
                right: -1rem;
            }

            .right-paddle {
                right: -10px;
            }

            .col-md-2{
                width: 40%;
            }
            
            #beli_sekarang{
                margin-bottom: 0;
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

            .swal2-toast{
                /*font-size: 10px !important;*/
                width:400px !important;
                max-width: 100% !important;
            }

            .searchbar-open {
                width: 77%
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

            .swal2-toast{
                /*font-size: 10px !important;*/
                width:380px !important;
                max-width: 100% !important;
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

            .swal2-toast{
                font-size: 14px !important;
                width:360px !important;
                max-width: 100% !important;
            }

            .searchbar-open {
                width: 75%
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

            .swal2-toast{
                font-size: 14px !important;
                width:350px !important;
                max-width: 100% !important;
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

            .swal2-toast{
                font-size: 14px !important;
                width:340px !important;
                max-width: 100% !important;
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

            .swal2-toast{
                font-size: 14px !important;
                width:320px !important;
                max-width: 100% !important;
            }

            .searchbar-open {
                width: 73%
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

            .swal2-toast{
                font-size: 14px !important;
                width:280px !important;
                max-width: 100% !important;
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
        
       
        
    </style>
    
    <script>
        $(document).ready(function(){
          $(".preloader").fadeOut();
        })
    </script>
</head>
<body>
    <div id="message" class="row justify-content-center"></div>
    <!-- Modal loaction-->
    @if (!session()->has('ses_order'))
    <div class="modal fade right" id="LocationForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content ">
                <div class="modal-body">
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
                        <h3 >Lokasi Anda</h3>
                    </div>
                    
                    <div class="row justify-content-center  d-flex">
                        <div class="col-md-5 login-label" style="z-index: 2">
                            <form method="POST" action="{{route('session.store',[$vendor])}}">
                                @csrf
                                <input type="hidden" name="user_id" id="user_id_sales" value="{{ Auth::user()->id }}">
                                <div class="row mt-3">
                                    <div class="col-label col-lg-3 mt-auto">
                                        <p class="p-label text-left">Kota</p>
                                    </div>
                                    <div class="col-select col-lg-9 pl-0">
                                        <div class="form-group">
                                            <select onchange="getval(this);" name="city_id"  id="city_id" class="form-control" style="width:100%;" required></select>
                                        </div>
                                     </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-label col-lg-3 mt-auto">
                                        <p class="p-label text-left">Pilih Toko</p>
                                    </div>
                                    <div class="col-select col-lg-9 pl-0">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <select onchange="getct(this);" name="customer_id"  id="customer_id" class="form-control" style="width:100%;" required>
                                                </select>
                                            </div>
                                            <input id="store_id_select" type="hidden" value=""/>
                                            <input id="city_id_select" type="hidden" value=""/>
                                            <input id="nm-toko-hide" name="nm_toko_hide" type="hidden" />
                                            <input id="nm-cust-hide" name="nm_cust_hide" type="hidden" />
                                            <input id="no-telp-hide" name="no_telp_hide" type="hidden" />
                                            <input id="no-owner-hide" name="no_owner_hide" type="hidden" />
                                            <input id="no-toko-hide" name="no_toko_hide" type="hidden" />
                                            <input id="alamat-hide" name="alamat_hide" type="hidden" />
                                        </div>
                                    </div>
                                </div>
                                
                                <!---
                                <table class="table borderless">
                                    <tbody width="100%">
                                        <tr>
                                            <td align="left" class="mx-auto td-label-loc">
                                                <h6>Kota</h6>
                                            </td>
                                            <td class="px-2" width="80%">
                                                <div class="form-group">
                                                    <select onchange="getval(this);" name="city_id"  id="city_id" class="form-control" style="width:100%;" required></select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" class="my-auto td-label-loc">
                                                <h6>Pilih Toko</h6>
                                            </td>
                                            <td class="px-2">
                                                <div class="form-group">
                                                    <select name="customer_id"  id="customer_id" class="form-control" style="width:100%;" required>
                                                    </select>
                                                </div>
                                                <input id="city_id_select" type="hidden" value=""/>
                                                <input id="nm-toko-hide" name="nm_toko_hide" type="hidden" />
                                                <input id="nm-cust-hide" name="nm_cust_hide" type="hidden" />
                                                <input id="no-telp-hide" name="no_telp_hide" type="hidden" />
                                                <input id="no-owner-hide" name="no_owner_hide" type="hidden" />
                                                <input id="no-toko-hide" name="no_toko_hide" type="hidden" />
                                                <input id="alamat-hide" name="alamat_hide" type="hidden" />
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                -->

                                <div class="row justify-content-center mt-2 mb-2">
                                    <div class="custom-control custom-radio mr-4">
                                        <input type="radio" name="user_loc" class="custom-control-input" id="on_location" value="On Location" required>
                                        <label class="custom-control-label" for="on_location" style="color:#ffffff;font-weight:600;">On Location</label>
                                    </div>
                                    
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="user_loc" class="custom-control-input" id="off_location" value="Off Location" >
                                        <label class="custom-control-label" for="off_location" style="color:#ffffff;font-weight:600;">Off Location</label>
                                    </div>
                                </div>
                                <input type="hidden" id="lat" name="lat">
                                <input type="hidden" id="lng" name="lng">
                                <div class="mx-auto text-center">
                                    <button type="submit" class="btn btn_login_form" >{{ __('Masuk') }}</button>
                                </div>
                                <div class="row justify-content-center mt-4">
                                    <a href="{{route('log-out')}}" onclick="logout_record()"><p>Keluar</p></a>
                                    <h4 class="ml-2 mt-n1 grip-on" style="font-weight: 100;color:#f0f0f0;">|</h4>
                                    <!--<a href="{{URL::route('pesanan',[$vendor])}}"><p class="ml-2">Dashboard</p></a>
                                    <h4 class="ml-2 mt-n1 grip-on" style="font-weight: 100;color:#f0f0f0;">|</h4>-->
                                    <a href="{{route('dash-sales',[$vendor])}}">
                                        <div class="row ml-2">
                                            <p>Dashboard</p><span><i class="fa fa-angle-right ml-2" style="color: #ffffff"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(session()->has('ses_order'))
        <?php $store_name = session()->get('ses_order');
            if($store_name->store_name != null){
                $point = 0;
                $amount_claim = 0;
                $totalPotencyPoints = 0; 
            }else{
                [$point,$totalPotencyPoints]= App\Http\Controllers\PointInfoController::PointInfo($store_name->customer_id);
                [$paramPeriod,$amount_claim] = App\Http\Controllers\PointInfoController::amountClaim($store_name->customer_id);
            }
        ?>
    @endif
    
    <!--poin-->
    @if(session()->has('ses_order'))
        <!-- Modal detail point-->
        <div style="position: fixed;" class="modal fade modal-fixed-footer"  id="DetailPoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-info-circle mr-1" style="color: turquoise"></i>Informasi Poin</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" style="border-radius: 18px;">
                        <li class="list-group-item d-flex list-group-item-primary justify-content-between align-items-center">
                            Total Poin 
                            <span class="badge badge-primary badge-pill">{{number_format($point,1)}}</span>
                        </li>
                        <li class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                            Potensi Tambahan Poin 
                            <span class="badge badge-warning badge-pill">{{number_format($totalPotencyPoints,1)}}</span>
                        </li>
                        <li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                            Poin yang dapat diklaim 
                            <span class="badge badge-success badge-pill">{{number_format($amount_claim,1)}}</span>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </div>

        <!-- Modal notif no period claim-->
        @if($store_name->customer_id != null)
            <div class="modal fade modal-fixed-footer"  id="TukarPoinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius: 20px;">
                    <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">Tukar Poin</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <section>
                            <?php
                            if($paramPeriod != null){
                                $list_rewards = App\PointReward::where('client_id',\Auth::user()->client_id)
                                                ->where('period_id', $paramPeriod)
                                                ->orderBy('bonus_amount','DESC')
                                                ->get();
                            
                            ?>
                            @if($list_rewards)
                                @foreach ($list_rewards as $item)
                                    <div>
                                        <input class="radio-claim" type="radio" id="radioPoin{{$item->id}}" 
                                        name="selectClaim" value="{{$item->id}}" required 
                                        {{$amount_claim  < $item->point_rule ? 'disabled' : ''}}>
                                        <label class="label-radio-claim py-2" for="radioPoin{{$item->id}}">
                                            <h4><img class="mt-n1" src="{{asset('assets/image/medal-64.png')}}" alt="" width="20">
                                                <b class="mt-3">{{$item->point_rule}}</b></h4>
                                            <h6>Rp. {{number_format($item->bonus_amount,2)}}</h6>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                            <?php
                               } 
                            ?>
                        </section>
                    </div>
                    <div class="modal-footer">
                    <button id="submitClaim" type="button" disabled
                        class="btn btn-primary btn-sm btn-block py-2 font-weight-bold"
                        style=" border-radius:0;
                                border-top-left-radius: 20px;
                                border-top-right-radius : 20px;
                                background-color:  #FF0000  !important;
                                border:none;">Klaim</button>
                    </div>
                </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Modal new store form-->
    <div class="modal fade right" id="storeForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content">
                <div class="modal-body">
                    <img src="{{ asset('assets/image/dot-top-right.png') }}" class="dot-top-right"  
                    style="" alt="dot-top-right">
                    <img src="{{ asset('assets/image/dot-bottom-left.png') }}" class="dot-bottom-left"  
                    style="" alt="dot-bottom-left">
                    <img src="{{ asset('assets/image/shape-bottom-right.png') }}" class="shape-bottom-right"  
                    style="" alt="shape-bottom-right">
                    <!--
                    <button type="button" class="btn btn-warning btn-circle" onClick="window.location.reload();" data-dismiss="modal" style="position:absolute;z-index:99999;"><i class="fa fa-times"></i></button>
                    -->
                    <div class="container content-new-toko">
                        <div class="d-flex justify-content-center mx-auto">
                            <div class="col-md-2 image-logo-login" style="z-index: 2">
                            <img src="{{asset('storage/'.$client->client_image)}}" class="img-thumbnail pt-4" style="background-color:transparent; border:none;" alt="image-logo">  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 login-label pt-4" style="z-index: 2">
                        <h3 >Tambah Toko Baru</h3>
                    </div>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-5 login-label col-new-toko" style="z-index: 2">
                            
                                <div class="card mx-auto contact_card" 
                                style="border-top-left-radius:25px;
                                border-top-right-radius:25px;
                                border-bottom-right-radius:0;
                                border-bottom-left-radius:0;">
                                    <div class="card-body pb-1 pt-2">
                                        <div class="form-group">
                                            <input type="text" name="store_name" class="form-control mb-n3 contact_input @error('store_name') is-invalid @enderror" placeholder="Nama Toko" id="new_store_name" required autocomplete="off" autofocus value="{{ old('new_store_name') }}">
                                            @error('new_store_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <hr style="border-bottom:1px solid rgba(116, 116, 116, 0.507);">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control my-n3 contact_input @error('name') is-invalid @enderror" placeholder="Nama Customer" id="new_name" required autocomplete="off" autofocus value="{{ old('new_name') }}">
                                            @error('new_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <hr style="border-bottom:1px solid rgba(116, 116, 116, 0.507);">
                                        <div class="form-group">
                                            <input type="number" minlength="10" maxlength="13" name="phone" class="form-control my-n3 contact_input @error('new_telp') is-invalid @enderror" placeholder="No. Telp 1 (Whatsapp)" id="new_telp" required autocomplete="off" autofocus value="{{ old('new_telp') }}">
                                            @error('new_telp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <hr style="border-bottom:1px solid rgba(116, 116, 116, 0.507);">
                                        <div class="form-group">
                                            <input type="number" minlength="10" maxlength="13" name="phone_owner" class="form-control my-n3 contact_input @error('new_telp_owner') is-invalid @enderror" placeholder="No. Telp 2 (Telp. Owner)" id="new_telp_owner" required autocomplete="off" autofocus value="{{ old('new_telp_owner') }}">
                                            @error('new_telp_owner')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <hr style="border-bottom:1px solid rgba(116, 116, 116, 0.507);">
                                        <div class="form-group">
                                            <input type="number" minlength="10" maxlength="13" name="phone_store" class="form-control my-n3 contact_input @error('new_telp_toko') is-invalid @enderror" placeholder="No. Telp 3 (Telp. Toko)" id="new_telp_toko" required autocomplete="off" autofocus value="{{ old('new_telp_toko') }}">
                                            @error('new_telp_toko')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <hr style="border-bottom:1px solid rgba(116, 116, 116, 0.507);">
                                        <div class="form-group">
                                            <input type="text" name="address" class="form-control my-n3 contact_input @error('address') is-invalid @enderror" placeholder="Alamat" id="new_address" required autocomplete="off" autofocus value="{{ old('address') }}">
                                            @error('new_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mx-auto text-center px-0">
                                    <button type="button" class="btn btn_login_form float-left btn-new-toko" onClick="window.location.reload();" data-dismiss="modal">{{__('Batal')}}</button>
                                    <button type="submit" id="btn_new_toko" class="btn btn_login_form float-right btn-new-toko" style="background-color: green !important;">{{ __('Simpan') }}</button>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <form method="POST" action="{{route('checkout.no_order',[$vendor])}}">
                                @csrf
                                
                                <div class="row mt-3">
                                    
                                    <div class="col-select col-lg-12 pl-3">
                                        <div class="form-group">
                                            <select name="reasons_id"  id="reasons_id" class="form-control" style="width:100%;" required></select>
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
                                                font-weight: 500;" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mx-auto text-center">
                                    <button type="submit" id="ga_checkout"class="btn btn_login_form" >{{ __('Konfirmasi') }}</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--preloader-->
    <div class="preloader" id="preloader">
        <div class="loading">
          <img src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader">
          <p style="font-weight:900;line-height:2;color:#1A4066;margin-left: -10%;">Harap Tunggu</p>
        </div>
    </div>

    <!--
    <div id="loader" class="lds-dual-ring hidden overlay_ajax"><img class="hidden" src="{{ asset('assets/image/preloader.gif') }}" width="80" alt="preloader"></div>
    -->

    <!-- Modal validasi stok cart -->
    <div class="modal fade" id="validStockCart" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Perhatian...</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paramItem" value="">
                    <input type="hidden" id="paramQty" value="">
                    <input type="hidden" id="paramPrice" value="">  
                    <ul  class="list-group" style="border-radius: 18px;">
                        <li id="body_alert_cart" class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                           
                        </li>
                        <li class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                            <small>
                                <p class="mt-2 text-danger"><b>*</b> Jika melanjutkan pesanan, kemungkinan pengiriman akan mengalami keterlamabatan. </p>
                            </small>  
                        </li>
                        
                    </ul>
                        
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" 
                    class="btn btn-block button_add_to_cart text-white py-2"
                    style=" border-radius:0;
                            border-top-left-radius: 20px;
                            border-top-right-radius : 20px;
                            background-color:  #FF0000  !important;
                            border:none;
                            font-weight:700;"
                            onclick="continueCart()">Lanjut Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal validasi stok plus quantity in cart -->
    <div class="modal fade" id="validStockCartPlus" role="dialog" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content" style="">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Perhatian...</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paramItemPlus" value="">
                    <input type="hidden" id="paramQtyPlus" value="">
                    <input type="hidden" id="paramPricePlus" value="">  
                    <ul  class="list-group" style="border-radius: 18px;">
                        <li id="body_alert_cartPlus" class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                           
                        </li>
                        <li class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                            <small>
                                <p class="mt-2 text-danger"><b>*</b> Jika melanjutkan pesanan, kemungkinan pengiriman akan mengalami keterlamabatan. </p>
                            </small>  
                        </li>
                        
                    </ul>
                        
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" 
                    class="btn btn-block button_add_to_cart text-white py-2"
                    style=" border-radius:0;
                            border-top-left-radius: 20px;
                            border-top-right-radius : 20px;
                            background-color:  #FF0000  !important;
                            border:none;
                            font-weight:700;"
                            onclick="continueCartPlus()">Lanjut Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal validasi stok cart paket -->
    <div class="modal fade child-modal" id="validStockCartPaket" role="dialog" tabindex="-1" aria-hidden="true" 
        style="z-index: 10000000 !important;" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" >
            <!-- Modal content-->
            <div class="modal-content " style="background-color: #f7f7f7">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Perhatian...</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paramItemPaket" value="">
                    <input type="hidden" id="groupIdPaket" value="">
                    <input type="hidden" id="paramjumlahValPaket" value="">
                    <input type="hidden" id="paramQtyPaket" value="">
                    <input type="hidden" id="paramPricePaket" value="">
                    <input type="hidden" id="bnsTotalPaket" value="">
                    

                    <ul  class="list-group" style="border-radius: 18px;">
                        <li id="body_alert_cartPaket" class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                           
                        </li>
                        <li class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                            <small>
                                <p class="mt-2 text-danger"><b>*</b> Jika melanjutkan pesanan, kemungkinan pengiriman akan mengalami keterlamabatan. </p>
                            </small>  
                        </li>
                        
                    </ul>
                        
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" 
                    class="btn btn-block button_add_to_cart text-white py-2"
                    style=" border-radius:0;
                            border-top-left-radius: 20px;
                            border-top-right-radius : 20px;
                            background-color:  #FF0000  !important;
                            border:none;
                            font-weight:700;"
                            onclick="continueCartPaket()">Lanjut Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal validasi stok cart bonus -->
    <div class="modal fade child-modal" id="validStockCartBonus" role="dialog" tabindex="-1" aria-hidden="true" 
        style="z-index: 10000000 !important;" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" >
            <!-- Modal content-->
            <div class="modal-content " style="background-color: #f7f7f7">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Perhatian...</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paramItemBonus" value="">
                    <input type="hidden" id="groupIdBonus" value="">
                    <input type="hidden" id="paramjumlahValBonus" value="">
                    <input type="hidden" id="paramQtyBonus" value="">
                    <input type="hidden" id="paramPriceBonus" value="">
                    <input type="hidden" id="paramPaketId" value="">
                    <input type="hidden" id="paramPurchaseQuantity" value="">
                    <input type="hidden" id="paramBonusQuantity" value="">
                    <input type="hidden" id="bnsTotalBonus" value="">
                    <input type="hidden" id="bnsMax" value="">

                    <ul  class="list-group" style="border-radius: 18px;">
                        <li id="body_alert_cartBonus" class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                           
                        </li>
                        <li class="list-group-item d-flex list-group-item-warning justify-content-between align-items-center">
                            <small>
                                <p class="mt-2 text-danger"><b>*</b> Jika melanjutkan pesanan, kemungkinan pengiriman akan mengalami keterlamabatan. </p>
                            </small>  
                        </li>
                        
                    </ul>
                        
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" 
                    class="btn btn-block button_add_to_cart text-white py-2"
                    style=" border-radius:0;
                            border-top-left-radius: 20px;
                            border-top-right-radius : 20px;
                            background-color:  #FF0000  !important;
                            border:none;
                            font-weight:700;"
                            onclick="continueCartBonus()">Lanjut Simpan</button>
                </div>
            </div>
        </div>
    </div>

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
                <li>
                    <a href="{{$paket != null ? URL::route('home_paket',[$vendor]) : '' }}">Paket</a>
                </li>
                
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

                <li>
                    <a class="btn logout mt-4" data-toggle="modal" onclick="show_modal_chekout()">
                        Check Out 
                    </a>
                    
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
                    <i class="fas fa-bars fa-2x d-none d-md-block d-md-none" style="color:#ffffff;"></i>
                    <i class="fas fa-bars fa-1x d-md-none" style="color:#ffffff;"></i>
                </button>
                @if (\Route::currentRouteName() == 'home_customer' || \Route::currentRouteName() == 'search_keyword')
                    <form class="searchbar form-inline ml-auto mt-n4 mb-n4" action="{{route('search_product',[$vendor])}}"> 
                        <input type="search" placeholder="Cari Produk" value="{{old('keyword')}}" 
                            name="keyword" class="searchbar-input pl-3 px-0 rounded-pill" onkeyup="buttonUp();" required /> 
                        <input type="submit" class="searchbar-submit rounded-circle p-0" value="GO&nbsp;"> <span class="searchbar-icon rounded-circle p-0">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </span> 
                    </form>
                @endif
                
                <div class="pb-n5 bell-icon">
                    <div class="nav-item dropdown mb-n5 mt-n4 mr-n2 {{\Route::currentRouteName() == 'home_customer' ? '' : 'bell-icon-right'}}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell text-white fa-2x bell-icon" aria-hidden="true" ></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-nav dropdown-menu-right" 
                            aria-labelledby="navbarDropdown" style="border-radius: 10px;">
                            <li class="notification-box">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-3 col-3 text-center">
                                        <img class="ml-2" src="{{asset('assets/image/store-80.png')}}" alt="" width="25">
                                    </div>
                                    <div class="col-lg-10 col-sm-8 col-8 ml-0">
                                        @if(session()->has('ses_order'))
                                            <strong class="text-info">
                                                {{
                                                    $store_name->store_name != null ? 
                                                    $store_name->store_name : 
                                                    App\Http\Controllers\PointInfoController::StoreInfo($store_name->customer_id)
                                                }}
                                            </strong>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-2 col-sm-3 col-3 text-center">
                                        <img class="ml-2" src="{{asset('assets/image/medal-64.png')}}" alt="" width="27">
                                    </div>
                                    <div class="col-lg-10 col-sm-8 col-8 ml-0">
                                        @if(session()->has('ses_order'))
                                            <strong class="text-info">{{number_format($amount_claim,1)}} / {{number_format($point,1)}}</strong>
                                            <a href="#" data-toggle="modal" data-target="#DetailPoinModal">
                                                <i class="fas fa-info-circle" style="color: turquoise"></i>
                                            </a>
                                            @if($store_name->customer_id != null && $amount_claim > 0)
                                                
                                                <div class="float-right btn-claim mr-2">
                                                    <input type="hidden" value="{{$store_name->customer_id}}" id="CsIdClaim">
                                                    <button class="btn btn-success btn-sm py-0" data-toggle="modal" data-target="#TukarPoinModal">Klaim</button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </div>
                      </div> 
                </div>
                
            </div>
        </nav>
        
        <!--hero-->
        <div id="hero_cools">
            <!-- BANNER -->
            <div role="main" style="background-color:#ffffff">
                <div id="bannerSlide" class="carousel slide" data-ride="carousel" data-interval="5000">
                    <ol class="carousel-indicators" style="z-index: 1;">
                        @foreach($banner as $carousel)
                            <li data-target="#bannerSlide" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}" ></li>
                        @endforeach
                    </ol>
                    
                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        @foreach($banner as $k => $v)
                            <div class="carousel-item {{$v->position == '1' ? 'active' : ''}}">
                                <img src="{{asset('storage/'.$v->image)}}" class="w-100 h-100" style="margin-top:-5px;z-index:1;">
                            </div>
                        @endforeach
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#bannerSlide" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#bannerSlide" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <!--content-->
        <div id="content">
           @yield('content')
        </div>

        <!-- Footer section -->
        <div id="footer">
            <div class="d-flex justify-content-center">
                <div class="col-md-2">
                    <img src="{{ asset('assets/image'.$client->client_image) }}" class="img-thumbnail" style="background-color:transparent; border:none;" alt="image-logo"> 
                </div>
            </div>
            <br><br>
            <div class="row justify-content-center mx-auto" > 
                   <div class="col-md-12 text-center">
                       <p>Follow Us</p>
                   </div>
                <div class="social-icons">
                    
                    <a href="{{$client->fb_url != null ? $client->fb_url : '#'}}" 
                        {{$client->fb_url != null ? 'target="_blank"' : ''}}>
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{$client->inst_url != null ? $client->inst_url : '#'}}" 
                        {{$client->inst_url != null ? 'target="_blank"' : ''}}>
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{$client->ytb_url != null ? $client->ytb_url : '#'}}" 
                        {{$client->ytb_url != null ? 'target="_blank"' : ''}}>
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="{{$client->twt_url != null ? $client->twt_url : '#'}}"
                        {{$client->twt_url != null ? 'target="_blank"' : ''}}>
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
            <div class="copyright text-center">
                <p>&copy;Copyright 2021</p>
            </div>
        </div>
        
    
    </div>
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!--<script src="{{ asset('assets/js/jquery.firstVisitPopup.js')}}"></script>-->
    
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>-->
    <!--@include('sweetalert::alert')-->
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSWC453"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script type="text/javascript">
        //style column new toko form
        if($(window).width()> 1367 ){
            $('.col-label').removeClass('col-lg-3').addClass('col-lg-2');
        }
        if($(window).width()< 769 ){
            $('.col-new-toko').removeClass('col-md-5').addClass('col-md-10');
            $('.col-select').removeClass('pl-0');
            $('.p-label').removeClass('text-left').addClass('text-center');
            $('.btn-claim').removeClass('mr-2').addClass('mr-n2');
        }
        if($(window).width()< 759 ){
            $('.bell-icon').removeClass('fa-2x');
        }

        if($(window).width() < 601 ){
            $('.grip-on').removeClass('mt-n2').addClass('mt-n1');
        }
        if($(window).width() < 426 ){
            $('.btn-new-toko').addClass('btn-block').addClass('mb-2');
            $('.content-new-toko').addClass('mt-n3');
            $('.img-logo-loc').removeClass('pt-4').addClass('pt-3');
        }
        
        //disable button submit point claim
        var inputElems = document.getElementsByClassName("radio-claim");
        for (var i = inputElems.length - 1; i >= 0; --i) {
            var elem = inputElems[i];
            elem.onchange = function () {
                document.getElementById("submitClaim").removeAttribute("disabled");
            };
        }

        //add claim point
        $("#submitClaim").click(function() {
        if ($('input[name="selectClaim"]:checked').length == 0) {
            const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            icon: 'error',
            title: 'Jenis poin belum dipilih'
            });
            return false; 
        }else {
            var reward_id = $(".radio-claim:checked").val();
            var customer_id = $("#CsIdClaim").val();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url : '{{URL::to('/claim/post')}}',
                type:'POST',
                data:{
                    reward_id : reward_id,
                    customer_id : customer_id,
                },
                                
                success: function (){
                    Swal.fire({
                        title: 'Berhasil',
                        text: "Permintaan klaim terkirim",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: "OK",
                        confirmButtonColor: '#4db849'
                        }).then(function(){ 
                            location.reload();
                        });
                },
            })
        }
        return false;
        });
        
        //nav bar behavior
        $(document).ready(function(){
            $(window).scroll(function(){
                var scroll = $(window).scrollTop();
                if (scroll > 200) {
                    $(".navbar").css("background" , "#1A4066");
                    $(".navbar").css("opacity" , "0.9");
                }

                else{
                    $(".navbar").css("background" , "transparent");  	
                }
            })
        });

        //fa icon select
        function formatText (icon) {
            return $('<span><i class="fas ' + $(icon.element).data('icon') + '" style="color:green;"></i> ' + icon.text + '</span>');
        };

        //trigger fa icon select
        $('#check_tunai').select2({
            minimumResultsForSearch: -1,
            templateSelection: formatText,
            templateResult: formatText
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
        
        //onchange select city
        function getval(sel)
        {
            $( '#city_id_select' ).val(sel.value);
        }

        //onchange select store
        function getct(sel)
        {
            $( '#store_id_select' ).val(sel.value);
            //var store_id = ();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            $.ajax({
                url: '{{URL::to('/ajax/latlon/search')}}',
                type: 'get',
                data: {
                    lat : lat,
                    lng : lng,
                    store_id: sel.value,
                },
                success: function(response){
                    //$('#lat').val(response);
                    if (response == 'taken') {
                        $("#on_location").prop("checked", true);
                        $('#on_location').prop('disabled', false);
                        $('#off_location').prop('disabled', true);
                    }
                    else if(response == 'not_taken') {
                        $("#on_location").prop("checked", false);
                        $('#on_location').prop('disabled', true);
                        $('#off_location').prop('checked', true);
                    }
                }
            });
        }

        //Select2 city
        $('#city_id').each(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            //var city_id = $('#city_id_select' ).val();
            //var city_id = $( '#city_id_select' ).val();//$('#city_id option:selected');//.find(":selected").val();
            $(this).select2({
                placeholder: 'Pilih Kota',
                language: {
                    noResults: function() {
                        return '&nbsp;Data Tidak Ditemukan';
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                ajax: {
                        url: '{{URL::to('/ajax/city')}}',
                        type: "post",
                        dataType: 'json',
                        data: function (params){
                            return {
                            _token: CSRF_TOKEN,
                            search: params.term, // search term
                            store_id: $('#store_id_select' ).val(),
                            };
                        },
                        processResults: function (response) {
                        return {
                            results: response
                            };
                        },
                        cache: true
                }

            });
        });

        //select2 customer
        $('#customer_id').each(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            //var city_id = $('#city_id_select' ).val();
            //var city_id = $( '#city_id_select' ).val();//$('#city_id option:selected');//.find(":selected").val();
            $(this).select2({
                placeholder: 'Pilih Toko',
                language: {
                noResults: function() {
                    return '&nbsp;Data Tidak Ditemukan<br><button id="no-results-btn" onclick="noResultsButtonClicked()">Tambah Toko Baru...</button>';
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                ajax: {
                        url: '{{URL::to('/ajax/store')}}',
                        type: "post",
                        dataType: 'json',
                        data: function (params){
                            return {
                            _token: CSRF_TOKEN,
                            search: params.term, // search term
                            city_id: $('#city_id_select' ).val(),
                            user_id: $('#user_id_sales' ).val(),
                            };
                        },
                        processResults: function (response) {
                        return {
                            results: response
                            };
                        },
                        cache: true
                }

            });
        });
        
        /*$('#customer_id').select2({
        placeholder: 'Pilih Toko',
        language: {
        noResults: function() {
            return '&nbsp;Data Tidak Ditemukan<br><button id="no-results-btn" onclick="noResultsButtonClicked()">Tambah Toko Baru...</button>';
            },
        },
        escapeMarkup: function(markup) {
            return markup;
        },
       
        ajax: {
                url: '{{URL::to('/ajax/store')}}',
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                                id: item.id,
                                text: item.store_code+' - '+item.store_name
                        }
                        
                    })
                };
                
            }
        }
            
        });*/

        //onclick no-result-customer
        function noResultsButtonClicked()
        {
            $("#storeForm").modal('show');
            $("#customer_id").select2().on("select2-open", function(e) {
                    $('.select2-drop-active .select2-input').blur();
            });
           
        }

        //trigger new toko
        $("#btn_new_toko").on("click", function(){
            var newTokoVal = $("#new_store_name").val();
            var newnameVal = $("#new_name").val();
            var newtelpVal = $("#new_telp").val();
            var newtelpownerVal = $("#new_telp_owner").val();
            var newtelptokoVal = $("#new_telp_toko").val();
            var newaddressVal = $("#new_address").val();
            if (newTokoVal != "" && newnameVal!="" && newtelpVal !="" && newtelptokoVal !="" && newaddressVal !="" && newtelpownerVal !="" ){
                var newToko = new Option(newTokoVal, newTokoVal, true, true);
                $("#customer_id").append(newToko).trigger("change");
                $("#nm-toko-hide").val(newTokoVal);
                $("#nm-cust-hide").val(newnameVal);
                $("#no-telp-hide").val(newtelpVal);
                $("#no-owner-hide").val(newtelpownerVal);
                $("#no-toko-hide").val(newtelptokoVal);
                $("#alamat-hide").val(newaddressVal); 
                $("#storeForm").modal('hide');
            }
            else{
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Anda harus mengisi data dengan lengkap dan benar'
                    });
            }
            
        });  
        
        
        //$('#accordion').collapse('show').height('auto');
        

        //=======================================top product scroll horizontal============================================//
        // duration of scroll animation
        var scrollDuration = 800;
        // paddles
        var leftPaddle = document.getElementsByClassName("left-paddle");
        var rightPaddle = document.getElementsByClassName("right-paddle");
        // get items dimensions
        var itemsLength = $(".item").length;
        var itemSize = $(".item").outerWidth(true);
        // get some relevant size for the paddle triggering point
        var paddleMargin = 10;

        // get wrapper width
        var getMenuWrapperSize = function () {
            return $(".menu-wrapper").outerWidth()-20;
        };
        var menuWrapperSize = getMenuWrapperSize();
        // the wrapper is responsive
        $(window).on("resize", function () {
            menuWrapperSize = getMenuWrapperSize();
        });
        // size of the visible part of the menu is equal as the wrapper size
        var menuVisibleSize = menuWrapperSize;

        // get total width of all menu items
        var getMenuSize = function () {
            return itemsLength * itemSize;
        };
        var menuSize = getMenuSize();
        // get how much of menu is invisible
        var menuInvisibleSize = menuSize - menuWrapperSize;

        // get how much have we scrolled to the left
        var getMenuPosition = function () {
            return $(".menu").scrollLeft();
        };

        // finally, what happens when we are actually scrolling the menu
        $(".menu").on("scroll", function () {
            // get how much of menu is invisible
            menuInvisibleSize = menuSize - menuWrapperSize;
            // get how much have we scrolled so far
            var menuPosition = getMenuPosition();

            var menuEndOffset = menuInvisibleSize - paddleMargin;

            // show & hide the paddles
            // depending on scroll position
            if (menuPosition <= paddleMargin) {
                $(leftPaddle).addClass("paddles_hide");
                $(rightPaddle).removeClass("paddles_hide");
            } else if (menuPosition < menuEndOffset) {
                // show both paddles in the middle
                $(leftPaddle).removeClass("paddles_hide");
                $(rightPaddle).removeClass("paddles_hide");
            } else if (menuPosition >= menuEndOffset) {
                $(leftPaddle).removeClass("paddles_hide");
                $(rightPaddle).addClass("paddles_hide");
            }
        });

        // scroll to left
        $(rightPaddle).on("click", function () {
            $(".menu").animate({ scrollLeft: menuInvisibleSize }, scrollDuration);
        });

        // scroll to right
        $(leftPaddle).on("click", function () {
            $(".menu").animate({ scrollLeft: "0" }, scrollDuration);
        });
        //=======================================end scroll top product============================================//


        //=======================================scroll popup paket================================================//
        // duration of scroll animation
        var scrollDuration_pop = 800;
        // paddles
        var leftPaddle_pop = document.getElementsByClassName("left-paddle_pop");
        var rightPaddle_pop = document.getElementsByClassName("right-paddle_pop");
        // get items dimensions
        var itemsLength_pop = $(".item_pop").length;
        var itemSize_pop = $(".item_pop").outerWidth(true);
        // get some relevant size for the paddle triggering point
        var paddleMargin_pop = 20;

        // get wrapper width
        var getMenuWrapperSize_pop = function () {
            return $(".menu-wrapper_pop").outerWidth();
        };
        var menuWrapperSize_pop = getMenuWrapperSize_pop();
        // the wrapper is responsive
        $(window).on("resize", function () {
            menuWrapperSize_pop = getMenuWrapperSize_pop();
        });
        // size of the visible part of the menu is equal as the wrapper size
        var menuVisibleSize_pop = menuWrapperSize_pop;

        // get total width of all menu items
        var getMenuSize_pop = function () {
            return itemsLength_pop * itemSize_pop;
        };
        var menuSize_pop = getMenuSize_pop();
        // get how much of menu is invisible
        var menuInvisibleSize_pop = menuSize_pop - menuWrapperSize_pop;

        // get how much have we scrolled to the left
        var getMenuPosition_pop = function () {
            return $(".menu_pop").scrollLeft();
        };

        // finally, what happens when we are actually scrolling the menu
        $(".menu_pop").on("scroll", function () {
            // get how much of menu is invisible
            menuInvisibleSize_pop = menuSize_pop - menuWrapperSize_pop;
            // get how much have we scrolled so far
            var menuPosition_pop = getMenuPosition_pop();

            var menuEndOffset_pop = menuInvisibleSize_pop - paddleMargin_pop;

            // show & hide the paddles
            // depending on scroll position
            /*if (menuPosition_pop <= paddleMargin_pop) {
                $(leftPaddle_pop).addClass("paddles_hide_pop");
                $(rightPaddle_pop).removeClass("paddles_hide_pop");
            } else if (menuPosition_pop < menuEndOffset_pop) {
                // show both paddles in the middle
                $(leftPaddle_pop).removeClass("paddles_hide_pop");
                $(rightPaddle_pop).removeClass("paddles_hide_pop");
            } else if (menuPosition_pop >= menuEndOffset_pop) {
                $(leftPaddle_pop).removeClass("paddles_hide_pop");
                $(rightPaddle_pop).addClass("paddles_hide_pop");
            }*/
        });

        var scrollAmount = 0;
        // scroll to left
        $(rightPaddle_pop).on("click", function () {
            $(".menu_pop").animate({ scrollLeft: scrollAmount += 300  }, scrollDuration_pop);
        });

        // scroll to right
        $(leftPaddle_pop).on("click", function () {
            $(".menu_pop").animate({ scrollLeft: scrollAmount -= 300 }, scrollDuration_pop);
        });
        //=======================================end scroll popup paket============================================//


        //=======================================scroll popup paket bonus================================================//
        // duration of scroll animation
        var scrollDuration_pop_bonus = 800;
        // paddles
        var leftPaddle_pop_bonus = document.getElementsByClassName("left-paddle_pop_bonus");
        var rightPaddle_pop_bonus = document.getElementsByClassName("right-paddle_pop_bonus");
        // get items dimensions
        var itemsLength_pop_bonus = $(".item_pop_bonus").length;
        var itemSize_pop_bonus = $(".item_pop_bonus").outerWidth(true);
        // get some relevant size for the paddle triggering point
        var paddleMargin_pop_bonus = 20;

        // get wrapper width
        var getMenuWrapperSize_pop_bonus = function () {
            return $(".menu-wrapper_pop_bonus").outerWidth();
        };
        var menuWrapperSize_pop_bonus = getMenuWrapperSize_pop_bonus();
        // the wrapper is responsive
        $(window).on("resize", function () {
            menuWrapperSize_pop_bonus = getMenuWrapperSize_pop_bonus();
        });
        // size of the visible part of the menu is equal as the wrapper size
        var menuVisibleSize_pop_bonus = menuWrapperSize_pop_bonus;

        // get total width of all menu items
        var getMenuSize_pop_bonus = function () {
            return itemsLength_pop_bonus * itemSize_pop_bonus;
        };
        var menuSize_pop_bonus = getMenuSize_pop_bonus();
        // get how much of menu is invisible
        var menuInvisibleSize_pop_bonus = menuSize_pop_bonus - menuWrapperSize_pop_bonus;

        // get how much have we scrolled to the left
        var getMenuPosition_pop_bonus = function () {
            return $(".menu_pop_bonus").scrollLeft();
        };

        // finally, what happens when we are actually scrolling the menu
        $(".menu_pop_bonus").on("scroll", function () {
            // get how much of menu is invisible
            menuInvisibleSize_pop_bonus = menuSize_pop_bonus - menuWrapperSize_pop_bonus;
            // get how much have we scrolled so far
            var menuPosition_pop_bonus = getMenuPosition_pop_bonus();

            var menuEndOffset_pop_bonus = menuInvisibleSize_pop_bonus - paddleMargin_pop_bonus;

            // show & hide the paddles
            // depending on scroll position
            /*if (menuPosition_pop_bonus <= paddleMargin_pop_bonus) {
                $(leftPaddle_pop_bonus).addClass("paddles_hide_pop_bonus ");
                $(rightPaddle_pop_bonus).removeClass("paddles_hide_pop_bonus");
            } else if (menuPosition_pop_bonus < menuEndOffset_pop_bonus) {
                // show both paddles in the middle
                $(leftPaddle_pop_bonus).removeClass("paddles_hide_pop_bonus");
                $(rightPaddle_pop_bonus).removeClass("paddles_hide_pop_bonus");
            } else if (menuPosition_pop_bonus >= menuEndOffset_pop_bonus) {
                $(leftPaddle_pop_bonus).removeClass("paddles_hide_pop_bonus");
                $(rightPaddle_pop_bonus).addClass("paddles_hide_pop_bonus");
            }*/
        });
        var scrollAmount_bonus = 0;
        // scroll to left
        $(rightPaddle_pop_bonus).on("click", function () {
            $(".menu_pop_bonus").animate({ scrollLeft: scrollAmount_bonus += 330 }, scrollDuration_pop_bonus);
        });

        // scroll to right
        $(leftPaddle_pop_bonus).on("click", function () {
            $(".menu_pop_bonus").animate({ scrollLeft: scrollAmount_bonus -= 330 }, scrollDuration_pop_bonus);
        });
        //=======================================end scroll popup paket bonus============================================//
        
        //popup first page
        $(document).ready(function(){
            $("#LocationForm").modal('show');
        });

       //=======geolocation========//
       $('#LocationForm').on('show.bs.modal', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
        } else {
            alert ('Geolocation is not supported by this browser')
        }
            

            // handle the error here
            function positionError(error) {
                var errorCode = error.code;
                var message = error.message;

                alert(message);
            }

            function savePosition(position) {
                        //$.post("geocoordinates.php", {lat: position.coords.latitude, lng: position.coords.longitude});
                $('#lat').val(position.coords.latitude);
                $('#lng').val(position.coords.longitude);
                //$("#LocationForm").modal('hide');    
            }
        });

        /*
        $(function () {
				$('#my-welcome-message').firstVisitPopup({
					cookieName : 'homepage',
					showAgainSelector: '#show-message'
				});
            });
        */ 

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
        //end sidebar

        //disbaled button - paket //
       /* $(document).ready(function () {
            $('.button_minus_pkt').attr('disabled', true);
        });*/

        /*function btn_code(){
            var voucher_code = document.getElementById("voucher_code").value;
            var x = document.getElementById("desc_code");
            if(voucher_code ==""){
                $("#voucher_code").focus(),
                Swal.fire({
                text: "Harap Masukkan Kode",
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: "Tutup",
                confirmButtonColor: '#6a3137'
                });
                $(".swal2-modal").css('background-color', ' #FDD8AF')
            }
            else
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/search_vcode')}}',
                    type:'POST',
                    data:{
                        code : voucher_code
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (response){
                        if (response == 'taken'){
                            $.ajax({
                                url : '{{URL::to('/keranjang/apply_code')}}',
                                type: 'POST',
                                data:{
                                    code : voucher_code
                                },
                                success: function (response){
                                $( '#accordion' ).html(response);
                                $('#collapse-4').addClass('show');
                                var totpesan_val_code = $("#total_pesan_val_code").val();
                                var voucher_no = $("#total_novoucher_val_code").val();
                                $( '#voucher_code_hide' ).val(voucher_code);
                                $( '#voucher_code_hide_modal' ).val(voucher_code);
                                $( '#total_pesan_val' ).val(totpesan_val_code);
                                $( '#total_novoucher_val' ).val(voucher_no);
                                //x.style.display = "block";
                                var objDiv = document.getElementById("collapse-4");
                                objDiv.scrollTop = objDiv.scrollHeight;
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                                }
                            });
                        }
                        else if (response == 'full_uses'){
                            $('#loader').addClass('hidden'),
                            $("#voucher_code").focus(),
                                Swal.fire({
                                text: "Maaf, kode tidak dapat gunakan,karena sudah mencapai batas maximum penggunaan",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Tutup",
                                confirmButtonColor: '#6a3137'
                                });
                            $(".swal2-modal").css('background-color', ' #FDD8AF')
                        }
                        else if(response == 'not_taken'){
                            $('#loader').addClass('hidden'),
                            $("#voucher_code").focus(),
                                Swal.fire({
                                text: "Kode Tidak Cocok",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: "Tutup",
                                confirmButtonColor: '#6a3137'
                                });
                            $(".swal2-modal").css('background-color', ' #FDD8AF')
                        }
                    },
                    error: function (response) {
                    console.log('Error:', response);
                    }
                });
            }
        }*/

        /*function reset_promo(){
            var x = document.getElementById("desc_code");
            $('#loader').removeClass('hidden');
            $.ajax({
                url : '{{URL::to('/home_cart')}}',
                type : 'GET',
                success: function (response) {
                // We get the element having id of display_info and put the response inside it
                $( '#accordion' ).html(response);
                $('#collapse-4').addClass('show');
                document.getElementById("voucher_code_hide_modal").value=null;
                x.style.display = "none";
                var objDiv = document.getElementById("collapse-4");
                objDiv.scrollTop = objDiv.scrollHeight;
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loader').addClass('hidden')
                }
            });
        }*/

        function hanyaAngka(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
        
            return false;
            return true;
        }
        
        /*function pesan_wa()
        {
            //var name = document.getElementById("name").value;
            //var email = document.getElementById("email").value;
            //var address = document.getElementById("address").value;
            //var phone = document.getElementById("phone").value;
            var order_id = $('#order_id_cek').val();
            //if (name != "" && email!="" && address !="" && phone !="" && phone.length > 9) {
                
                /*$.ajax({
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
                                var desc = response['data'][i].Product_name;
                                
                                var tr_str = "<li class='text-center'><small>"+desc+"</small></li>";
                                $("#body_alert").append(tr_str);
                            }
                            $("#modal_validasi").modal('show');
                        }
                        else
                        {
                    */      /*Swal.fire({
                            title: 'Berhasil',
                            text: "Anda melakukan pesanan melalui whatsapp",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonText: "OK",
                            confirmButtonColor: '#4db849'
                            }).then(function(){ 
                                window.location.href = '{{URL::to('/success/send/order')}}';
                            });
                        /*}
                    }
                });*/
                
            
        //}

        function cancel_wa()
        {
            var order_id = $('#order_id_cek').val();
            Swal.fire({
                title: 'Apakah anda yakin ?',
                text: "Membatalkan pesanan akan menghapus semua produk yang sudah dimasukkan kedalam keranjang",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '\u00A0\u00A0\u00A0\u00A0Ya\u00A0\u00A0\u00A0\u00A0',
                cancelButtonText:  '\u00A0Tidak\u00A0',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                    if (result.isConfirmed){
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/delete_allcart')}}',
                            type:'POST',
                            data:{
                                order_id : order_id,
                            },
                            success: function (){
                                Swal.fire({
                                        //title: 'Apakah anda yakin ?',
                                        text: "Pesanan berhasil dibatalkan",
                                        type: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok',
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                        }).then(function(){ 
                                            location.reload();
                                        })
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                })
        }

        function input_qty_top(id){
            
            var jumlah = $('#show_top'+id).val();
            
            if (jumlah == ""){
                var jumlah = $('#jumlah_top'+id).val(0);
                var harga = $('#harga_top'+id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                $('#productPrice_top'+id).text(harga);
            }else{
                var jumlah = parseInt(jumlah);
                // AMBIL NILAI HARGA
                var harga = $('#harga_top'+id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                // alert(jumlah)
                if (jumlah<1) {
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                    });
                    $('#jumlah_top'+id).val(0);
                    $('#show_top'+id).val("");
                } else {
                    $('#jumlah_top'+id).val(jumlah)
                    $('#show_top'+id).val(jumlah)
                    $('#productPrice_top'+id).text(harga);
                    
                }
            }
        }

        function input_qty(id){
            
            var jumlah = $('#show_'+id).val();
            
            if (jumlah == ""){
                var jumlah = $('#jumlah'+id).val(0);
                var harga = $('#harga'+id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                $('#productPrice'+id).text(harga);
            }else{
                var jumlah = parseInt(jumlah);
                // AMBIL NILAI HARGA
                var harga = $('#harga'+id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                // alert(jumlah)
                if (jumlah<1) {
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                    });
                    $('#jumlah'+id).val(0);
                    $('#show_'+id).val("");
                } else {
                    $('#jumlah'+id).val(jumlah)
                    $('#show_'+id).val(jumlah)
                    $('#productPrice'+id).text(harga);
                    
                }
            }
        }
        
        function input_qty_pkt(id,group_id){
            
            var jumlah = $('#show_pkt'+id+'_'+group_id).val();
            if (jumlah == ""){
                $('#button_minus_pkt'+id+'_'+group_id).attr('disabled', true);
                var jumlah = $('#jumlah_pkt'+id+'_'+group_id).val(0);
                var harga = $('#harga_pkt'+id+'_'+group_id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                $('#productPrice_pkt'+id+'_'+group_id).text(harga);
            }else{
                var jumlah = parseInt(jumlah);
                // AMBIL NILAI HARGA
                var harga = $('#harga_pkt'+id+'_'+group_id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                // alert(jumlah)
                if (jumlah<0) {
                    $('#button_minus_pkt'+id+'_'+group_id).attr('disabled', true);
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 0'
                    });
                    $('#jumlah_pkt'+id+'_'+group_id).val(0);
                    $('#show_pkt'+id+'_'+group_id).val("");
                } else {
                    $('#button_minus_pkt'+id+'_'+group_id).attr('disabled', false);
                    $('#jumlah_pkt'+id+'_'+group_id).val(jumlah)
                    $('#show_pkt'+id+'_'+group_id).val(jumlah)
                    $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                    
                }
            }
        }

        function input_qty_bns(id,group_id){
            
            var jumlah = $('#show_bns'+id+'_'+group_id).val();
            
            if (jumlah == ""){
                $('#button_minus_bns'+id+'_'+group_id).attr('disabled', true);
                var jumlah = $('#jumlah_bns'+id+'_'+group_id).val(0);
                var harga = $('#harga_bns'+id+'_'+group_id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                $('#productPrice_bns'+id+'_'+group_id).text(harga);
            }else{
                var jumlah = parseInt(jumlah);
                // AMBIL NILAI HARGA
                var harga = $('#harga_bns'+id+'_'+group_id).val();
                var harga = parseInt(harga) * jumlah;

                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                // alert(jumlah)
                if (jumlah<0) {
                    $('#button_minus_bns'+id+'_'+group_id).attr('disabled', true);
                    const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 0'
                    });
                    $('#jumlah_bns'+id+'_'+group_id).val(0);
                    $('#show_bns'+id+'_'+group_id).val("");
                } else {
                    $('#button_minus_bns'+id+'_'+group_id).attr('disabled', false);
                    $('#jumlah_bns'+id+'_'+group_id).val(jumlah)
                    $('#show_bns'+id+'_'+group_id).val(jumlah)
                    $('#productPrice_bns'+id+'_'+group_id).text(harga);
                    
                }
            }
        }

        function button_plus_top(id)
        {
            var jumlah = $('#jumlah_top'+id).val();
            var jumlah = parseInt(jumlah) + 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_top'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";
            
            var text_harga = $('#harga_top'+id).val();
            var	text_string = text_harga.toString();
            var hasil = text_string.length;
            // alert(jumlah)
            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kosong')
            } else {
                //$('#button_minus_pkt'+id).attr('disabled', false);
                $('#jumlah_top'+id).val(jumlah)
                $('#show_top'+id).val(jumlah)
                $('#productPrice_top'+id).text(harga);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_top'+id).style.fontSize = "small";
                    } 
                }
            }
        }

        function button_plus(id)
        {
            var jumlah = $('#jumlah'+id).val();
            var jumlah = parseInt(jumlah) + 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";
            
            var text_harga = $('#harga'+id).val();
            var	text_string = text_harga.toString();
            var hasil = text_string.length;
            // alert(jumlah)
            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kosong')
            } else {
                //$('#button_minus_pkt'+id).attr('disabled', false);
                $('#jumlah'+id).val(jumlah)
                $('#show_'+id).val(jumlah)
                $('#productPrice'+id).text(harga);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice'+id).style.fontSize = "small";
                    } 
                }
            }
        }

        function button_plus_pkt(id,group_id)
        {
            var jumlah = $('#jumlah_pkt'+id+'_'+group_id).val();
            var jumlah = parseInt(jumlah) + 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_pkt'+id+'_'+group_id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";
            
            var text_harga = $('#harga_pkt'+id+'_'+group_id).val();
            var	text_string = text_harga.toString();
            var hasil = text_string.length;
            // alert(jumlah)
            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kosong')
            } else {
                $('#button_minus_pkt'+id+'_'+group_id).attr('disabled', false);
                $('#jumlah_pkt'+id+'_'+group_id).val(jumlah)
                $('#show_pkt'+id+'_'+group_id).val(jumlah)
                $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_pkt'+id+'_'+group_id).style.fontSize = "small";
                    } 
                }
            }
        }

        function button_plus_bns(id,group_id)
        {
            var jumlah = $('#jumlah_bns'+id+'_'+group_id).val();
            var jumlah = parseInt(jumlah) + 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_bns'+id+'_'+group_id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";
            
            var text_harga = $('#harga_bns'+id+'_'+group_id).val();
            var	text_string = text_harga.toString();
            var hasil = text_string.length;
            // alert(jumlah)
            if (jumlah<1) {
            alert('Jumlah Tidak Boleh Kosong')
            } else {
                $('#button_minus_bns'+id+'_'+group_id).attr('disabled', false);
                $('#jumlah_bns'+id+'_'+group_id).val(jumlah);
                $('#show_bns'+id+'_'+group_id).val(jumlah);
                $('#productPrice_bns'+id+'_'+group_id).text(harga);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_bns'+id+'_'+group_id).style.fontSize = "small";
                    } 
                }
            }
        }

        function button_minus_top(id)
        {
            var jumlah = $('#jumlah_top'+id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_top'+id).val();;
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah+ ",-";

            if (jumlah<1) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
            } 
            else 
            {
            $('#jumlah_top'+id).val(jumlah);
            $('#show_top'+id).val(jumlah);
            $('#productPrice_top'+id).text(harga);
            }
        }
        
        function button_minus(id)
        {
            var jumlah = $('#jumlah'+id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga'+id).val();;
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah+ ",-";

            if (jumlah<1) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
            } 
            else 
            {
            $('#jumlah'+id).val(jumlah);
            $('#show_'+id).val(jumlah);
            $('#productPrice'+id).text(harga);
            }
        }

        function button_minus_pkt(id,group_id)
        {
            var jumlah = $('#jumlah_pkt'+id+'_'+group_id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_pkt'+id+'_'+group_id).val();;
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah+ ",-";

            if (jumlah<0) {
                $('#button_minus_pkt'+id+'_'+group_id).attr('disabled', true);
                /*const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 0'
                });*/
            } 
            else 
            {
            $('#jumlah_pkt'+id+'_'+group_id).val(jumlah);
            $('#show_pkt'+id+'_'+group_id).val(jumlah);
            $('#productPrice_pkt'+id+'_'+group_id).text(harga);
            }
        }

        function button_minus_bns(id,group_id)
        {
            var jumlah = $('#jumlah_bns'+id+'_'+group_id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_bns'+id+'_'+group_id).val();;
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah+ ",-";

            if (jumlah<0) {
                $('#button_minus_bns'+id+'_'+group_id).attr('disabled', true);
                /*const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 0'
                });*/
            } 
            else 
            {
            $('#jumlah_bns'+id+'_'+group_id).val(jumlah);
            $('#show_bns'+id+'_'+group_id).val(jumlah);
            $('#productPrice_bns'+id+'_'+group_id).text(harga);
            }
        }

        
        function add_tocart_top(id)
        {
            var Product_id = $('#top'+id).val();
            var quantity = $('#jumlah_top'+id).val();
            var price = $('#harga_top'+id).val();
            var getStock = $('#stok_top'+id).text();
            var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            if (quantity <= 0 || quantity ==""){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
            }
            else{
                if(parseInt(quantity) > parseInt(getStock)){
                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                    Jumlah pesanan melebihi stok.\
                                </span>";
                                $("#body_alert_cart").append(tr_str);

                                $('#paramItem').val(id);
                                $('#paramQty').val(quantity);
                                $('#paramPrice').val(price);
                                
                                $("#validStockCart").modal('show');
                }else{
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                    $.ajax({
                        url : '{{URL::to('/keranjang/checkForCart')}}',
                        type: 'POST',
                        data:{
                            ProductId: Product_id,
                            quantity : quantity,
                        },
                        success: function(dataStok){
                            if(dataStok != null){
                                //console.log(dataStok);
                                if(parseInt(quantity) > parseInt(dataStok)){
                                    if(dataStok > 0){
                                        var viewStock = dataStok;
                                    }else{
                                        var viewStock = 0;
                                    }
                                    
                                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                    Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                </span>";
                                    $("#body_alert_cart").append(tr_str);

                                    $('#paramItem').val(id);
                                    $('#paramQty').val(quantity);
                                    $('#paramPrice').val(price);

                                    $("#validStockCart").modal('show');
                                }else{
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/simpan')}}',
                                        type:'POST',
                                        data:{
                                            Product_id : Product_id,
                                            quantity : quantity,
                                            price : price
                                        },
                                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                            $('#loader').removeClass('hidden')
                                        },              
                                        success: function (data){
                                            //console.log(data);
                                            //$('#'+id).val(jumlah);
                                            //$('#show_'+id).html(jumlah);
                                            // UBAH FORMAT UANG INDONESIA
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'center',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                                })

                                                Toast.fire({
                                                icon: 'success',
                                                title: 'Produk berhasil dimasukkan keranjang'
                                            });
                                            var	number_string = price.toString();
                                            var sisa 	= number_string.length % 3;
                                            var rupiah 	= number_string.substr(0, sisa);
                                            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                                            if (ribuan) {
                                            separator = sisa ? '.' : '';
                                            rupiah += separator + ribuan.join('.');
                                            }

                                            price = "Rp. " + rupiah +",-";
                                            $('#jumlah_top'+id).val(1);
                                            $('#show_top'+id).val(1);
                                            $('#productPrice_top'+id).text(price);

                                            $.ajax({
                                                url : '{{URL::to('/keranjang/checkForCart')}}',
                                                type: 'POST',
                                                data:{
                                                    ProductId: Product_id,
                                                },
                                                success: function(dataStok){
                                                    //console.log(dataStok);
                                                    if(dataStok != null){
                                                        if(parseInt(dataStok) > 0){
                                                            var viewStockItem = dataStok;
                                                        }else{
                                                            var viewStockItem = 0;
                                                        }
                                                        
                                                        $('#stok'+id).text(viewStockItem);
                                                        $('#stok_top'+id).text(viewStockItem);
                                                    }
                                                },
                                            }),
                                            /*if(voucher_code_hide !=""){
                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/apply_code')}}',
                                                    type: 'POST',
                                                    data:{
                                                        code : voucher_code_hide
                                                    },
                                                    success: function (response){
                                                    $( '#accordion' ).html(response);
                                                    //$('#collapse-4').addClass('show');
                                                    //$( '#total_kr_' ).html(response);
                                                    var total_novoucher_val = $('#total_novoucher_val_code').val();
                                                    $('#total_novoucher_val').val(total_novoucher_val);
                                                    $('#voucher_code_hide').val(voucher_code_hide);
                                                    $('#voucher_code_hide_modal').val(voucher_code_hide);
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                    $('#loader').addClass('hidden')
                                                    }
                                                });
                                            }
                                            else{*/
                                                $.ajax({
                                                    url : '{{URL::to('/home_cart')}}',
                                                    type : 'GET',
                                                    success: function (response) {
                                                    // We get the element having id of display_info and put the response inside it
                                                    $('#accordion' ).html(response);
                                                        if ($(window).width() < 601) {
                                                        $('#div_total').removeClass('float-left');
                                                        //$('#div_total').addClass('justify-content-center');
                                                        $('#div_total').removeClass('mt-2');
                                                        $('#div_total').addClass('mb-2');
                                                        $('#beli_sekarang').removeClass('float-right');
                                                        $('#beli_sekarang').addClass('btn-block');
                                                        $('#beli_sekarang').addClass('mb-0');
                                                        $('#chk-bl-btn').removeClass('justify-content-end');
                                                        $('#chk-bl-btn').addClass('justify-content-center');
                                                        $('#divchecktunai').addClass('mb-2');
                                                        $('.dropfilter').removeClass('mt-3');
                                                        $('#p-title1').addClass('ml-n3');
                                                        $('#p-title2').addClass('ml-n3');
                                                        }
                                                        if ($(window).width() <= 480) {
                                                            $('#cont-collapse').removeClass('container');
                                                            
                                                        }
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                        $('#loader').addClass('hidden')
                                                    }
                                                });
                                            //}                                
                                        },
                                        
                                        error: function (data) {
                                        console.log('Error:', data);
                                        }
                                    });
                                }
                                
                            }
                        },
                    })
                }

            }
        }

        
        $("#validStockCart").on("hidden.bs.modal", function () {
            $("#body_alert_cart").text('');
        });

        $("#validStockCartPlus").on("hidden.bs.modal", function () {
            $("#body_alert_cartPlus").text('');
        });

        $("#validStockCartPaket").on("hidden.bs.modal", function () {
            $("#body_alert_cartPaket").text('');
            $('body').css('overflow','hidden')
        });

        $("#validStockCartBonus").on("hidden.bs.modal", function () {
            $("#body_alert_cartBonus").text('');
            $('body').css('overflow','hidden')
        });

        $(".modal-paket").on("hidden.bs.modal", function () {
            $('body').css('overflow-y','scroll');
        });

        $(".modal-paket").on("show.bs.modal", function () {
            $('body').css('overflow-y','hidden');
        });

        function continueCart(){
            var id = $('#paramItem').val();
            var quantity = $('#paramQty').val();
            var price = $('#paramPrice').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/simpan')}}',
                type:'POST',
                data:{
                    Product_id : id,
                    quantity : quantity,
                    price : price
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },              
                success: function (data){
                    
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })

                        Toast.fire({
                        icon: 'success',
                        title: 'Produk berhasil dimasukkan keranjang'
                    });
                    var	number_string = price.toString();
                    var sisa 	= number_string.length % 3;
                    var rupiah 	= number_string.substr(0, sisa);
                    var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                    if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                    }

                    price = "Rp. " + rupiah +",-";
                    $('#jumlah'+id).val(1);
                    $('#show_'+id).val(1);
                    $('#productPrice'+id).text(price);
                    //$('#stok'+id).text(0);
                    
                    $("#validStockCart").modal('hide');

                    $.ajax({
                        url : '{{URL::to('/keranjang/checkForCart')}}',
                        type: 'POST',
                        data:{
                            ProductId : id,
                        },
                        success: function(dataStok){
                            if(dataStok != null){
                                if(parseInt(dataStok) > 0){
                                    var viewStockItem = dataStok;
                                }else{
                                    var viewStockItem = 0;
                                }
                                
                                $('#stok'+id).text(viewStockItem);
                                $('#stok_top'+id).text(viewStockItem);
                            }
                        },
                    }),
                    
                    $.ajax({
                        url : '{{URL::to('/home_cart')}}',
                        type : 'GET',
                        success: function (response) {
                        // We get the element having id of display_info and put the response inside it
                        $('#accordion' ).html(response);
                            if ($(window).width() < 601) {
                            $('#div_total').removeClass('float-left');
                            //$('#div_total').addClass('justify-content-center');
                            $('#div_total').removeClass('mt-2');
                            $('#div_total').addClass('mb-2');
                            $('#beli_sekarang').removeClass('float-right');
                            $('#beli_sekarang').addClass('btn-block');
                            $('#beli_sekarang').addClass('mb-0');
                            $('#chk-bl-btn').removeClass('justify-content-end');
                            $('#chk-bl-btn').addClass('justify-content-center');
                            $('#divchecktunai').addClass('mb-2');
                            $('.dropfilter').removeClass('mt-3');
                            $('#p-title1').addClass('ml-n3');
                            $('#p-title2').addClass('ml-n3');
                            }
                            if ($(window).width() <= 480) {
                                $('#cont-collapse').removeClass('container');
                                
                            }
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').addClass('hidden')
                        }
                    });
                                                 
                },
                
                error: function (data) {
                console.log('Error:', data);
                }
            });
        }

        function continueCartPlus(){
            var id = $('#paramItemPlus').val();
            

            var getStock = $('#stok'+id).text();
            var jumlah = $('#jmlkr_'+id).val();
            var jumlah = parseInt(jumlah) + 1;
            var price = $('#harga_kr'+id).val();
            var stock = $('#stock'+id).val();
            // AMBIL NILAI HARGA
            var harga = $('#harga_kr'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }
            harga = "Rp. " + rupiah+",-";

            $('#jmlbrg_'+id).val(jumlah);
            //$('#show_'+id).html(jumlah);
            $('#jmlkr_'+id).val(jumlah);
            $('#show_kr_'+id).html(jumlah);
            $('#productPrice_kr'+id).text(harga);
            //$('#totalKr_'+id).text(totalkr);
            var id_detil = $('#id_detil'+id).val();
            var order_id = $('#order_id'+id).val();
            var price = $('#harga_kr'+id).val();
            var tot = parseInt($('#harga_kr'+id).val()) + parseInt($('#total_kr_val').val());
            var tot_val = tot;
            var	number_string = tot.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
            var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            //var total_pesan_val_hide = document.getElementById("total_pesan_val_hide").value;
            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            tot = "Rp. " + rupiah+",-";
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/tambah')}}',
                type:'POST',
                data:{
                    id_detil : id_detil,
                    order_id : order_id,
                    price : price
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },              
                success: function (data) {
                    $('#quantity_delete'+id).val(jumlah);
                    $('#total_kr_').html(tot);
                    $('#total_kr_val').val(tot_val);
                    $('#total_pesan_val').val(tot_val);
                    //$('#total_novoucher_val').val(total_pesan_val_hide);
                    $('#total_pesan_val_hide').val(tot_val);
                    $("#validStockCartPlus").modal('hide');
                    
                    $.ajax({
                        url : '{{URL::to('/keranjang/checkForCart')}}',
                        type: 'POST',
                        data:{
                            ProductId: id,
                        },
                        success: function(dataStok){
                            if(dataStok != null){
                                if(parseInt(dataStok) > 0){
                                    var viewStockItem = dataStok;
                                }else{
                                    var viewStockItem = 0;
                                }
                                
                                $('#stok'+id).text(viewStockItem);
                                $('#stok_top'+id).text(viewStockItem);
                            }
                        },
                    }),

                    $.ajax({
                        url : '{{URL::to('/home_cart')}}',
                        type : 'GET',
                        
                        success: function (response) {
                        // We get the element having id of display_info and put the response inside it
                        //$( '#accordion').html(response);
                        //$('#collapse-4').addClass('show');
                        },
                        complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                            $('#loader').addClass('hidden')
                        }
                    });
                    
                    
                },
                error: function (data) {
                console.log('Error:', data);
                }
            });
        }

        function continueCartPaket()
        {
            var id = $('#paramItemPaket').val();
            var group_id = $('#groupIdPaket').val();

            var Product_id = $('#paramItemPaket').val();
            var jml_val = $('#paramjumlahValPaket').val();
            var quantity = $('#paramQtyPaket').val();
            var price = $('#paramPricePaket').val();
            var getStock = $('#stok_pkt'+id).text();
            var bns_total = $('#bnsTotalPaket').val();
            
            
            if(bns_total > 0){

                //var paket_id = $('#paket_id'+group_id).val();
                //var purchase_qty = $('#purchase_qty'+group_id).val();
                //var bonus_qty =  $('#bonus_qty'+group_id).val();
                var total_val_qty = $('#total_produk'+group_id).val();
                //var a = parseInt(bns_total) * parseInt(purchase_qty);
                var b = parseInt(total_val_qty) + (parseInt(quantity) - parseInt(jml_val));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                    type:'POST',
                    dataType: 'json',
                    data:{
                        total_qty : b,
                    },
                    success: function(response){
                        if(response['data'] == null){
                            var c = 0;
                        }else{
                            var c = response['data'].bonus_quantity;
                        }
                        
                        if( bns_total > c){
                            $("#validStockCartPaket").modal('hide');
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                })

                                Toast.fire({
                                icon: 'error',
                                title: 'Gagal !, Total quantity tidak sesuai dengan bonus input',
                            });
                            var jumlah = parseInt(jml_val);

                            // AMBIL NILAI HARGA
                            var harga = $('#harga_pkt'+id+'_'+group_id).val();
                            var harga = parseInt(harga) * jumlah;

                            // UBAH FORMAT UANG INDONESIA
                            var	number_string = harga.toString();
                            var sisa 	= number_string.length % 3;
                            var rupiah 	= number_string.substr(0, sisa);
                            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                            if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                            }

                            var text_harga = $('#harga_pkt'+id+'_'+group_id).val();
                            var	text_string = text_harga.toString();
                            var hasil = text_string.length;

                            harga = "Rp. " + rupiah +",-";
                            $('#jumlah_pkt'+id+'_'+group_id).val(jumlah);
                            $('#show_pkt'+id+'_'+group_id).val(jumlah);
                            $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                            if(hasil > 8){
                                if ($(window).width() <= 480) {
                                    $('#productPrice_pkt'+id).style.fontSize = "small";
                                } 
                            }
                        }
                        else{
                            $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                            });
                            //simpan paket
                            $.ajax({
                                url : '{{URL::to('/keranjang/paket/simpan')}}',
                                type:'POST',
                                data:{
                                    Product_id : Product_id,
                                    quantity : quantity,
                                    price : price,
                                    //paket_id : paket_id,
                                    group_id : group_id
                                },
                                success: function (data){
                                    $('#orderid_delete_pkt'+id+'_'+group_id).val(data);
                                    $('#orderid_addcart'+group_id).val(data);
                                    $("#validStockCartPaket").modal('hide');
                                    $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                    });

                                    $.ajax({
                                        url : '{{URL::to('/keranjang/checkForCart')}}',
                                        type: 'POST',
                                        data:{
                                            ProductId: Product_id,
                                        },
                                        success: function(dataStok){
                                            if(dataStok != null){
                                                if(parseInt(dataStok) > 0){
                                                    var viewStockItem = dataStok;
                                                }else{
                                                    var viewStockItem = 0;
                                                }
                                                if(viewStockItem <= 0){
                                                    $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                                }
                                                $('.stok_pkt'+id).text(viewStockItem);
                                                $('.stok_bns'+id).text(viewStockItem);
                                            }
                                        },
                                    }),

                                    $.ajax({
                                        url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                                        type:'POST',
                                        data:{
                                            Product_id : Product_id,
                                            quantity : quantity,
                                            price : price,
                                            //paket_id : paket_id,
                                            group_id : group_id,
                                            order_id : data
                                        },
                                        success: function (data2) {
                                        // We get the element having id of display_info and put the response inside it
                                        $('#jumlah_val_pkt'+id+'_'+group_id).val(quantity);
                                        $('#total_qty'+group_id).text(data2);
                                        $('#total_produk'+group_id).val(data2);
                                        $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                                        $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                                type:'POST',
                                                dataType: 'json',
                                                data:{
                                                    total_qty : data2,
                                                },
                                                success: function(response){
                                                    var total_qty = parseInt(data2);
                                                    if(response['data'] != null){
                                                        var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                                        var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                                        $('#paket_id'+group_id).val(response['data'].id);
                                                        $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                                        $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                                        $('#bonus_max'+group_id).text(desimal_kali);
                                                        $('#max_bonus'+group_id).val(desimal_kali);
                                                    }
                                                    else{
                                                        var bonus_kali = 0;
                                                        var desimal_kali = 0;
                                                        $('#paket_id'+group_id).val('');
                                                        $('#purchase_qty'+group_id).val('');
                                                        $('#bonus_qty'+group_id).val('');
                                                        $('#bonus_max'+group_id).text(desimal_kali);
                                                        $('#max_bonus'+group_id).val(desimal_kali);
                                                    }
                                                },
                                                error: function (response) {
                                                console.log('Error:', response);
                                                }
                                            });
                                        },
                                        error: function (data2) {
                                        console.log('Error:', data2);
                                        }
                                    });
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'center',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                        })

                                        Toast.fire({
                                        icon: 'success',
                                        title: 'Paket berhasil disimpan'
                                    });
                                },
                                
                                error: function (data) {
                                console.log('Error:', data);
                                }
                            });
                        }
                    },
                    error: function (response) {
                    console.log('Error:', response);
                    }
                });
            }else{
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });
                
                //simpan paket
                $.ajax({
                    url : '{{URL::to('/keranjang/paket/simpan')}}',
                    type:'POST',
                    data:{
                        Product_id : Product_id,
                        quantity : quantity,
                        price : price,
                        //paket_id : paket_id,
                        group_id : group_id
                    },
                    success: function (data){
                        $('#orderid_delete_pkt'+id+'_'+group_id).val(data);
                        $('#orderid_addcart'+group_id).val(data);
                        $("#validStockCartPaket").modal('hide');
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: Product_id,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    if(viewStockItem <= 0){
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                    }
                                    $('.stok_pkt'+id).text(viewStockItem);
                                    $('.stok_bns'+id).text(viewStockItem);

                                    //console.log(viewStockItem);
                                }
                            },
                        }),

                        $.ajax({
                            url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                            type:'POST',
                            data:{
                                Product_id : Product_id,
                                quantity : quantity,
                                price : price,
                                //paket_id : paket_id,
                                group_id : group_id,
                                order_id : data
                            },
                            success: function (data2) {
                            // We get the element having id of display_info and put the response inside it
                            $('#jumlah_val_pkt'+id+'_'+group_id).val(quantity);
                            $('#total_qty'+group_id).text(data2);
                            $('#total_produk'+group_id).val(data2);
                            $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                            $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                    dataType: 'json',
                                    type:'POST',
                                    data:{
                                        total_qty : data2,
                                    },
                                    success: function(response){
                                        var total_qty = parseInt(data2);
                                        if(response['data'] != null){
                                            var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                            var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                            $('#paket_id'+group_id).val(response['data'].id);
                                            $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                            $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                            $('#bonus_max'+group_id).text(desimal_kali);
                                            $('#max_bonus'+group_id).val(desimal_kali);
                                        }
                                        else{
                                            var bonus_kali = 0;
                                            var desimal_kali = 0;
                                            $('#paket_id'+group_id).val('');
                                            $('#purchase_qty'+group_id).val('');
                                            $('#bonus_qty'+group_id).val('');
                                            $('#bonus_max'+group_id).text(desimal_kali);
                                            $('#max_bonus'+group_id).val(desimal_kali);
                                        }
                                    },
                                    error: function (response) {
                                    console.log('Error:', response);
                                    }
                                });
                            },
                            error: function (data2) {
                            console.log('Error:', data2);
                            }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: 'Paket berhasil disimpan'
                        });
                    },
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
                });
            }
            
        }

        //edit s/d februari
        function continueCartBonus()
        {
            var id = $('#paramItemBonus').val();
            var group_id = $('#groupIdBonus').val();

            var Product_id = $('#product_bns'+id+'_'+group_id).val();
            var jml_val = $('#paramjumlahValBonus').val();
            var quantity = $('#paramQtyBonus').val();
            var price = $('#paramPriceBonus').val();
            var paket_id = $('#paramPaketId').val();
            var purchase_qty = $('#paramPurchaseQuantity').val();
            var bonus_qty =  $('#paramBonusQuantity').val();
            var bns_total = $('#bnsTotalBonus').val();
            var bns_max =  $('#bnsMax').val();
            var getStock = $('#stok_bns'+id).text();
            //var bns_max = parseInt(bns_max);
            //var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            
            var hitung_total_bonus = (parseInt(quantity) - parseInt(jml_val))+ parseInt(bns_total);
            //console.log(bns_max);
            if(hitung_total_bonus > bns_max){
                $("#validStockCartBonus").modal('hide');
                const Toast = Swal.mixin({
                toast: true,
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'error',
                title: 'Gagal simpan!, Total quantity bonus melebihi jumlah max. bonus'
                });
                var harga = $('#harga_bns'+id+'_'+group_id).val();
                if(jml_val <= 0){
                    var harga = parseInt(harga);
                }else{
                    var harga = parseInt(harga) * parseInt(jml_val);
                }
                
                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                var text_harga = $('#harga_bns'+id+'_'+group_id).val();
                var	text_string = text_harga.toString();
                var hasil = text_string.length;
                $('#productPrice_bns'+id+'_'+group_id).text(harga);
                $('#jumlah_bns'+id+'_'+group_id).val(jml_val);
                $('#show_bns'+id+'_'+group_id).val(jml_val);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_bns'+id+'_'+group_id).style.fontSize = "small";
                    } 
                }
            }
            else{
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });
                //simpan bonus
                $.ajax({
                    url : '{{URL::to('/keranjang/bonus/simpan')}}',
                    type:'POST',
                    data:{
                        Product_id : Product_id,
                        quantity : quantity,
                        price : price,
                        paket_id : paket_id,
                        group_id : group_id
                    },
                    success: function (data){
                        $('#orderid_delete_bns'+id+'_'+group_id).val(data);
                        $('#jumlah_val_bns'+id+'_'+group_id).val(quantity);
                        $("#validStockCartBonus").modal('hide');
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });

                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: Product_id,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    if(viewStockItem <= 0){
                                       // $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                    }
                                    $('.stok_pkt'+id).text(viewStockItem);
                                    $('.stok_bns'+id).text(viewStockItem);
                                }
                            },
                        }),

                        $.ajax({
                            url : '{{URL::to('/keranjang/bonus/totalquantity')}}',
                            type:'POST',
                            data:{
                                Product_id : Product_id,
                                quantity : quantity,
                                price : price,
                                paket_id : paket_id,
                                group_id : group_id,
                                order_id : data
                            },
                                success: function (data2) {
                                // We get the element having id of display_info and put the response inside it
                                $('#total_bns'+group_id).text(data2);
                                $('#bns_total'+group_id).val(data2);
                                $('#checkbox_bns'+id+'_'+group_id).attr("disabled", false);
                                $('#checkbox_bns'+id+'_'+group_id).prop('checked', true);
                                },
                                error: function (data2) {
                                console.log('Error:', data2);
                                }
                        });
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Bonus berhasil disimpan'
                        });
                    },
                    
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
                
            }
            
        }

        function add_tocart(id)
        {
            var Product_id = $('#'+id).val();
            var quantity = $('#jumlah'+id).val();
            var price = $('#harga'+id).val();
            var getStock = $('#stok'+id).text();
            var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            if (quantity <= 0 || quantity ==""){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
            }
            else{
                //console.log(quantity);
                if(parseInt(quantity) > parseInt(getStock)){
                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                    Jumlah pesanan melebihi stok.\
                                </span>";
                                $("#body_alert_cart").append(tr_str);

                                $('#paramItem').val(id);
                                $('#paramQty').val(quantity);
                                $('#paramPrice').val(price);
                                
                                $("#validStockCart").modal('show');
                }else{
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                    $.ajax({
                        url : '{{URL::to('/keranjang/checkForCart')}}',
                        type: 'POST',
                        data:{
                            ProductId: Product_id,
                            quantity : quantity,
                        },
                        success: function(dataStok){
                            if(dataStok != null){
                                //console.log(dataStok);
                                if(parseInt(quantity) > parseInt(dataStok)){
                                    if(dataStok > 0){
                                        var viewStock = dataStok;
                                    }else{
                                        var viewStock = 0;
                                    }
                                    
                                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                    Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                </span>";
                                    $("#body_alert_cart").append(tr_str);

                                    $('#paramItem').val(id);
                                    $('#paramQty').val(quantity);
                                    $('#paramPrice').val(price);

                                    $("#validStockCart").modal('show');
                                }else{
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/simpan')}}',
                                        type:'POST',
                                        data:{
                                            Product_id : Product_id,
                                            quantity : quantity,
                                            price : price
                                        },
                                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                            $('#loader').removeClass('hidden')
                                        },              
                                        success: function (data){
                                            
                                            //console.log(data);
                                            //$('#'+id).val(jumlah);
                                            //$('#show_'+id).html(jumlah);
                                            // UBAH FORMAT UANG INDONESIA
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'center',
                                                showConfirmButton: false,
                                                timer: 1000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                                })

                                                Toast.fire({
                                                icon: 'success',
                                                title: 'Produk berhasil dimasukkan keranjang'
                                            });
                                            var	number_string = price.toString();
                                            var sisa 	= number_string.length % 3;
                                            var rupiah 	= number_string.substr(0, sisa);
                                            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                                            if (ribuan) {
                                            separator = sisa ? '.' : '';
                                            rupiah += separator + ribuan.join('.');
                                            }

                                            price = "Rp. " + rupiah +",-";
                                            $('#jumlah'+id).val(1);
                                            $('#show_'+id).val(1);
                                            $('#productPrice'+id).text(price);
                                            //$('#stok'+id).text(parseInt(dataStok)-parseInt(quantity));
                                            $.ajax({
                                                url : '{{URL::to('/keranjang/checkForCart')}}',
                                                type: 'POST',
                                                data:{
                                                    ProductId: Product_id,
                                                },
                                                success: function(dataStok){
                                                    if(dataStok != null){
                                                        if(parseInt(dataStok) > 0){
                                                            var viewStockItem = dataStok;
                                                        }else{
                                                            var viewStockItem = 0;
                                                        }
                                                        
                                                        $('#stok'+id).text(viewStockItem);
                                                        $('#stok_top'+id).text(viewStockItem);
                                                    }
                                                },
                                            }),
                                            /*
                                            if(voucher_code_hide !=""){
                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/apply_code')}}',
                                                    type: 'POST',
                                                    data:{
                                                        code : voucher_code_hide
                                                    },
                                                    success: function (response){
                                                    $( '#accordion' ).html(response);
                                                    //$('#collapse-4').addClass('show');
                                                    //$( '#total_kr_' ).html(response);
                                                    var total_novoucher_val = $('#total_novoucher_val_code').val();
                                                    $('#total_novoucher_val').val(total_novoucher_val);
                                                    $('#voucher_code_hide').val(voucher_code_hide);
                                                    $('#voucher_code_hide_modal').val(voucher_code_hide);
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                    $('#loader').addClass('hidden')
                                                    }
                                                });
                                            }
                                            else{
                                                */
                                                $.ajax({
                                                    url : '{{URL::to('/home_cart')}}',
                                                    type : 'GET',
                                                    success: function (response) {
                                                    // We get the element having id of display_info and put the response inside it
                                                    $('#accordion' ).html(response);
                                                        if ($(window).width() < 601) {
                                                        $('#div_total').removeClass('float-left');
                                                        //$('#div_total').addClass('justify-content-center');
                                                        $('#div_total').removeClass('mt-2');
                                                        $('#div_total').addClass('mb-2');
                                                        $('#beli_sekarang').removeClass('float-right');
                                                        $('#beli_sekarang').addClass('btn-block');
                                                        $('#beli_sekarang').addClass('mb-0');
                                                        $('#chk-bl-btn').removeClass('justify-content-end');
                                                        $('#chk-bl-btn').addClass('justify-content-center');
                                                        $('#divchecktunai').addClass('mb-2');
                                                        $('.dropfilter').removeClass('mt-3');
                                                        $('#p-title1').addClass('ml-n3');
                                                        $('#p-title2').addClass('ml-n3');
                                                        }
                                                        if ($(window).width() <= 480) {
                                                            $('#cont-collapse').removeClass('container');
                                                            
                                                        }
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                        $('#loader').addClass('hidden')
                                                    }
                                                });
                                            //}                                
                                        },
                                        
                                        error: function (data) {
                                        console.log('Error:', data);
                                        }
                                    });
                                }
                                
                            }
                        },
                    })
                }
                    
            }
        }
        
        function add_tocart_pkt(id,group_id)
        {
            var Product_id = $('#product_pkt'+id+'_'+group_id).val();
            var jml_val = $('#jumlah_val_pkt'+id+'_'+group_id).val();
            var quantity = $('#jumlah_pkt'+id+'_'+group_id).val();
            var price = $('#harga_pkt'+id+'_'+group_id).val();
            var getStock = $('#stok_pkt'+id).text();
            //var paket_id = $('#paket_id').val();
            //var purchase_qty = $('#purchase_qty').val();
            //var bonus_qty =  $('#bonus_qty').val();
            var bns_total = $('#bns_total'+group_id).val();
            
            //var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            if (quantity <= 0 || quantity ==""){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
                var harga = $('#harga_pkt'+id+'_'+group_id).val();
                if(jml_val <= 0){
                    var harga = parseInt(harga);
                }else{
                    var harga = parseInt(harga) * parseInt(jml_val);
                }
                
                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                var text_harga = $('#harga_bns'+id+'_'+group_id).val();
                var	text_string = text_harga.toString();
                var hasil = text_string.length;

                $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                $('#jumlah_pkt'+id+'_'+group_id).val(jml_val);
                $('#show_pkt'+id+'_'+group_id).val(jml_val);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_pkt'+id+'_'+group_id).style.fontSize = "small";
                    } 
                }
            }
            else
            {
                if(parseInt(quantity) > parseInt(getStock)){
                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                    Jumlah pesanan melebihi stok.\
                                </span>";
                                $("#body_alert_cartPaket").append(tr_str);

                                $('#paramItemPaket').val(id);
                                $('#paramjumlahValPaket').val(jml_val);
                                $('#paramQtyPaket').val(quantity);
                                $('#paramPricePaket').val(price);
                                $('#bnsTotalPaket').val(bns_total);
                                $('#groupIdPaket').val(group_id);
                                
                                $("#validStockCartPaket").modal('show');
                                
                }else{
                    if(bns_total > 0){

                        //var paket_id = $('#paket_id'+group_id).val();
                        //var purchase_qty = $('#purchase_qty'+group_id).val();
                        //var bonus_qty =  $('#bonus_qty'+group_id).val();
                        var total_val_qty = $('#total_produk'+group_id).val();
                        //var a = parseInt(bns_total) * parseInt(purchase_qty);
                        
                        var b = parseInt(total_val_qty) + (parseInt(quantity) - parseInt(jml_val));
                        //console.log(bns_total);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                            type:'POST',
                            dataType: 'json',
                            data:{
                                total_qty : b,
                            },
                            success: function(response){
                                //console.log(response['data']);
                                if(response['data'] == null){
                                    var c = 0;
                                }else{
                                    var c = response['data'].bonus_quantity;
                                }
                                
                                
                                if( bns_total > c){
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'center',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                        }
                                        })

                                        Toast.fire({
                                        icon: 'error',
                                        title: 'Gagal !, Total quantity tidak sesuai dengan bonus input',
                                    });
                                    var jumlah = parseInt(jml_val);

                                    // AMBIL NILAI HARGA
                                    var harga = $('#harga_pkt'+id+'_'+group_id).val();
                                    var harga = parseInt(harga) * jumlah;

                                    // UBAH FORMAT UANG INDONESIA
                                    var	number_string = harga.toString();
                                    var sisa 	= number_string.length % 3;
                                    var rupiah 	= number_string.substr(0, sisa);
                                    var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                                    if (ribuan) {
                                    separator = sisa ? '.' : '';
                                    rupiah += separator + ribuan.join('.');
                                    }

                                    var text_harga = $('#harga_pkt'+id+'_'+group_id).val();
                                    var	text_string = text_harga.toString();
                                    var hasil = text_string.length;

                                    harga = "Rp. " + rupiah +",-";
                                    $('#jumlah_pkt'+id+'_'+group_id).val(jumlah);
                                    $('#show_pkt'+id+'_'+group_id).val(jumlah);
                                    $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                                    if(hasil > 8){
                                        if ($(window).width() <= 480) {
                                            $('#productPrice_pkt'+id).style.fontSize = "small";
                                        } 
                                    }
                                }
                                else{
                                    $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                    });
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/checkForCart')}}',
                                        type: 'POST',
                                        data:{
                                            ProductId: Product_id,
                                            quantity : quantity,
                                        },
                                        success: function(dataStok){
                                            if(dataStok != null){
                                                //console.log(dataStok);
                                                if(parseInt(quantity) > parseInt(dataStok)){
                                                    if(dataStok > 0){
                                                        var viewStock = dataStok;
                                                    }else{
                                                        var viewStock = 0;
                                                    }
                                                    
                                                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                                    Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                                </span>";
                                                    $("#body_alert_cartPaket").append(tr_str);

                                                    $('#paramItemPaket').val(id);
                                                    $('#paramjumlahValPaket').val(jml_val);
                                                    $('#paramQtyPaket').val(quantity);
                                                    $('#paramPricePaket').val(price);
                                                    $('#bnsTotalPaket').val(bns_total);
                                                    $('#groupIdPaket').val(group_id);

                                                    $("#validStockCartPaket").modal('show');
                                                }else{
                                                    //simpan paket
                                                    $.ajax({
                                                        url : '{{URL::to('/keranjang/paket/simpan')}}',
                                                        type:'POST',
                                                        data:{
                                                            Product_id : Product_id,
                                                            quantity : quantity,
                                                            price : price,
                                                            //paket_id : paket_id,
                                                            group_id : group_id
                                                        },
                                                        success: function (data){
                                                            $('#orderid_delete_pkt'+id+'_'+group_id).val(data);
                                                            $('#orderid_addcart'+group_id).val(data);
                                                            $.ajaxSetup({
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                    }
                                                            });

                                                            $.ajax({
                                                                url : '{{URL::to('/keranjang/checkForCart')}}',
                                                                type: 'POST',
                                                                data:{
                                                                    ProductId: Product_id,
                                                                },
                                                                success: function(dataStok){
                                                                    if(dataStok != null){
                                                                        if(parseInt(dataStok) > 0){
                                                                            var viewStockItem = dataStok;
                                                                        }else{
                                                                            var viewStockItem = 0;
                                                                        }
                                                                        
                                                                        if(viewStockItem <= 0){
                                                                            $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                                                        }
                                                                        $('.stok_pkt'+id).text(viewStockItem);
                                                                        $('.stok_bns'+id).text(viewStockItem);
                                                                    }
                                                                },
                                                            }),

                                                            $.ajax({
                                                                url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                                                                type:'POST',
                                                                data:{
                                                                    Product_id : Product_id,
                                                                    quantity : quantity,
                                                                    price : price,
                                                                    //paket_id : paket_id,
                                                                    group_id : group_id,
                                                                    order_id : data
                                                                },
                                                                success: function (data2) {
                                                                // We get the element having id of display_info and put the response inside it
                                                                $('#jumlah_val_pkt'+id+'_'+group_id).val(quantity);
                                                                $('#total_qty'+group_id).text(data2);
                                                                $('#total_produk'+group_id).val(data2);
                                                                $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                                                                $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                                                    $.ajaxSetup({
                                                                        headers: {
                                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                        }
                                                                    });
                                                                    $.ajax({
                                                                        url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                                                        type:'POST',
                                                                        dataType: 'json',
                                                                        data:{
                                                                            total_qty : data2,
                                                                        },
                                                                        success: function(response){
                                                                            var total_qty = parseInt(data2);
                                                                            if(response['data'] != null){
                                                                                var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                                                                var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                                                                $('#paket_id'+group_id).val(response['data'].id);
                                                                                $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                                                                $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                                                                $('#bonus_max'+group_id).text(desimal_kali);
                                                                                $('#max_bonus'+group_id).val(desimal_kali);
                                                                            }
                                                                            else{
                                                                                var bonus_kali = 0;
                                                                                var desimal_kali = 0;
                                                                                $('#paket_id'+group_id).val('');
                                                                                $('#purchase_qty'+group_id).val('');
                                                                                $('#bonus_qty'+group_id).val('');
                                                                                $('#bonus_max'+group_id).text(desimal_kali);
                                                                                $('#max_bonus'+group_id).val(desimal_kali);
                                                                            }
                                                                        },
                                                                        error: function (response) {
                                                                        console.log('Error:', response);
                                                                        }
                                                                    });
                                                                },
                                                                error: function (data2) {
                                                                console.log('Error:', data2);
                                                                }
                                                            });
                                                            const Toast = Swal.mixin({
                                                                toast: true,
                                                                position: 'center',
                                                                showConfirmButton: false,
                                                                timer: 3000,
                                                                timerProgressBar: true,
                                                                didOpen: (toast) => {
                                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                                }
                                                                })

                                                                Toast.fire({
                                                                icon: 'success',
                                                                title: 'Paket berhasil disimpan'
                                                            });
                                                        },
                                                        
                                                        error: function (data) {
                                                        console.log('Error:', data);
                                                        }
                                                    });
                                                }
                                                
                                            }
                                        },
                                    })
                                }
                            },
                            error: function (response) {
                            console.log('Error:', response);
                            }
                        });
                    }else{
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });
                        
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: Product_id,
                                quantity : quantity,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    //console.log(dataStok);
                                    if(parseInt(quantity) > parseInt(dataStok)){
                                        if(dataStok > 0){
                                            var viewStock = dataStok;
                                        }else{
                                            var viewStock = 0;
                                        }
                                        
                                        var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                        Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                    </span>";
                                        $("#body_alert_cartPaket").append(tr_str);

                                        $('#paramItemPaket').val(id);
                                        $('#paramjumlahValPaket').val(jml_val);
                                        $('#paramQtyPaket').val(quantity);
                                        $('#paramPricePaket').val(price);
                                        $('#bnsTotalPaket').val(bns_total);
                                        $('#groupIdPaket').val(group_id);

                                        $("#validStockCartPaket").modal('show');
                                    }else{
                                        //simpan paket
                                        $.ajax({
                                            url : '{{URL::to('/keranjang/paket/simpan')}}',
                                            type:'POST',
                                            data:{
                                                Product_id : Product_id,
                                                quantity : quantity,
                                                price : price,
                                                //paket_id : paket_id,
                                                group_id : group_id
                                            },
                                            success: function (data){
                                                $('#orderid_delete_pkt'+id+'_'+group_id).val(data);
                                                $('#orderid_addcart'+group_id).val(data);
                                                
                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/checkForCart')}}',
                                                    type: 'POST',
                                                    data:{
                                                        ProductId: Product_id,
                                                    },
                                                    success: function(dataStok){
                                                        if(dataStok != null){
                                                            if(parseInt(dataStok) > 0){
                                                                var viewStockItem = dataStok;
                                                            }else{
                                                                var viewStockItem = 0;
                                                            }
                                                            if(viewStockItem <= 0){
                                                                $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                                            }
                                                            $('.stok_pkt'+id).text(viewStockItem);
                                                            $('.stok_bns'+id).text(viewStockItem);

                                                            //console.log(viewStockItem);
                                                        }
                                                    },
                                                }),

                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                                                    type:'POST',
                                                    data:{
                                                        Product_id : Product_id,
                                                        quantity : quantity,
                                                        price : price,
                                                        //paket_id : paket_id,
                                                        group_id : group_id,
                                                        order_id : data
                                                    },
                                                    success: function (data2) {
                                                    // We get the element having id of display_info and put the response inside it
                                                    $('#jumlah_val_pkt'+id+'_'+group_id).val(quantity);
                                                    $('#total_qty'+group_id).text(data2);
                                                    $('#total_produk'+group_id).val(data2);
                                                    $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                                                    $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                            }
                                                        });
                                                        $.ajax({
                                                            url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                                            dataType: 'json',
                                                            type:'POST',
                                                            data:{
                                                                total_qty : data2,
                                                            },
                                                            success: function(response){
                                                                var total_qty = parseInt(data2);
                                                                if(response['data'] != null){
                                                                    var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                                                    var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                                                    $('#paket_id'+group_id).val(response['data'].id);
                                                                    $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                                                    $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                                                    $('#bonus_max'+group_id).text(desimal_kali);
                                                                    $('#max_bonus'+group_id).val(desimal_kali);
                                                                }
                                                                else{
                                                                    var bonus_kali = 0;
                                                                    var desimal_kali = 0;
                                                                    $('#paket_id'+group_id).val('');
                                                                    $('#purchase_qty'+group_id).val('');
                                                                    $('#bonus_qty'+group_id).val('');
                                                                    $('#bonus_max'+group_id).text(desimal_kali);
                                                                    $('#max_bonus'+group_id).val(desimal_kali);
                                                                }
                                                            },
                                                            error: function (response) {
                                                            console.log('Error:', response);
                                                            }
                                                        });
                                                    },
                                                    error: function (data2) {
                                                    console.log('Error:', data2);
                                                    }
                                                });
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'center',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                    }
                                                    })

                                                    Toast.fire({
                                                    icon: 'success',
                                                    title: 'Paket berhasil disimpan'
                                                });
                                            },
                                            
                                            error: function (data) {
                                            console.log('Error:', data);
                                            }
                                        });
                                    }
                                    
                                }
                            },
                        })
                    }
                }
            }
        }

        //edit s/d februari
        function add_tocart_bns(id,group_id)
        {
            var Product_id = $('#product_bns'+id+'_'+group_id).val();
            var jml_val = $('#jumlah_val_bns'+id+'_'+group_id).val();
            var quantity = $('#jumlah_bns'+id+'_'+group_id).val();
            var price = $('#harga_bns'+id+'_'+group_id).val();
            var paket_id = $('#paket_id').val();
            var purchase_qty = $('#purchase_qty').val();
            var bonus_qty =  $('#bonus_qty').val();
            var bns_total =  $('#bns_total'+group_id).val();
            var bns_max = $('#max_bonus'+group_id).val();
            var getStock = $('#stok_bns'+id).text();
            //var bns_max = parseInt(bns_max);
            //var voucher_code_hide = document.getElementById("voucher_code_hide").value;
            
            if (quantity <= 0 || quantity ==""){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah tidak boleh kurang dari 1'
                });
                var harga = $('#harga_bns'+id+'_'+group_id).val();
                if(jml_val <= 0){
                    var harga = parseInt(harga);
                }
                else{
                    var harga = parseInt(harga) * parseInt(jml_val);
                }
                var harga = parseInt(harga);
                // UBAH FORMAT UANG INDONESIA
                var	number_string = harga.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                harga = "Rp. " + rupiah +",-";
                
                var text_harga = $('#harga_bns'+id+'_'+group_id).val();
                var	text_string = text_harga.toString();
                var hasil = text_string.length;

                $('#productPrice_bns'+id+'_'+group_id).text(harga);
                $('#jumlah_bns'+id+'_'+group_id).val(jml_val);
                $('#show_bns'+id+'_'+group_id).val(jml_val);
                if(hasil > 8){
                    if ($(window).width() <= 480) {
                        $('#productPrice_bns'+id+'_'+group_id).style.fontSize = "small";
                    } 
                }
            }
            else
            {
                if(parseInt(quantity) > parseInt(getStock)){
                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                    Jumlah bonus melebihi stok.\
                                </span>";
                                $("#body_alert_cartBonus").append(tr_str);

                                $('#paramItemBonus').val(id);
                                $('#groupIdBonus').val(group_id);
                                $('#paramjumlahValBonus').val(jml_val);
                                $('#paramQtyBonus').val(quantity);
                                $('#paramPriceBonus').val(price);
                                $('#paramPaketId').val(paket_id);
                                $('#paramPurchaseQuantity').val(purchase_qty);
                                $('#paramBonusQuantity').val(bonus_qty);
                                $('#bnsTotalBonus').val(bns_total);
                                $('#bnsMax').val(bns_max);
                                
                                
                                $("#validStockCartBonus").modal('show');
                }else{
                    var hitung_total_bonus = (parseInt(quantity) - parseInt(jml_val))+ parseInt(bns_total);
                    //console.log(bns_max);
                    if(hitung_total_bonus > bns_max){
                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        })

                        Toast.fire({
                        icon: 'error',
                        title: 'Gagal simpan!, Total quantity bonus melebihi jumlah max. bonus'
                        });
                        var harga = $('#harga_bns'+id+'_'+group_id).val();
                        if(jml_val <= 0){
                            var harga = parseInt(harga);
                        }else{
                            var harga = parseInt(harga) * parseInt(jml_val);
                        }
                        
                        // UBAH FORMAT UANG INDONESIA
                        var	number_string = harga.toString();
                        var sisa 	= number_string.length % 3;
                        var rupiah 	= number_string.substr(0, sisa);
                        var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                        if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                        }

                        harga = "Rp. " + rupiah +",-";
                        
                        var text_harga = $('#harga_bns'+id+'_'+group_id).val();
                        var	text_string = text_harga.toString();
                        var hasil = text_string.length;
                        $('#productPrice_bns'+id+'_'+group_id).text(harga);
                        $('#jumlah_bns'+id+'_'+group_id).val(jml_val);
                        $('#show_bns'+id+'_'+group_id).val(jml_val);
                        if(hasil > 8){
                            if ($(window).width() <= 480) {
                                $('#productPrice_bns'+id+'_'+group_id).style.fontSize = "small";
                            } 
                        }
                    }
                    else{
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: Product_id,
                                quantity : quantity,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    //console.log(dataStok);
                                    if(parseInt(quantity) > parseInt(dataStok)){
                                        if(dataStok > 0){
                                            var viewStock = dataStok;
                                        }else{
                                            var viewStock = 0;
                                        }
                                        
                                        var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                        Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                    </span>";
                                                    $("#body_alert_cartBonus").append(tr_str);

                                                    $('#paramItemBonus').val(id);
                                                    $('#groupIdBonus').val(group_id);
                                                    $('#paramjumlahValBonus').val(jml_val);
                                                    $('#paramQtyBonus').val(quantity);
                                                    $('#paramPriceBonus').val(price);
                                                    $('#paramPaketId').val(paket_id);
                                                    $('#paramPurchaseQuantity').val(purchase_qty);
                                                    $('#paramBonusQuantity').val(bonus_qty);
                                                    $('#bnsTotalBonus').val(bns_total);
                                                    $('#bnsMax').val(bns_max);


                                                    $("#validStockCartBonus").modal('show');
                                    }else{
                                        //simpan bonus
                                        $.ajax({
                                            url : '{{URL::to('/keranjang/bonus/simpan')}}',
                                            type:'POST',
                                            data:{
                                                Product_id : Product_id,
                                                quantity : quantity,
                                                price : price,
                                                paket_id : paket_id,
                                                group_id : group_id
                                            },
                                            success: function (data){
                                                $('#orderid_delete_bns'+id+'_'+group_id).val(data);
                                                $('#jumlah_val_bns'+id+'_'+group_id).val(quantity);
                                                $.ajaxSetup({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        }
                                                });

                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/checkForCart')}}',
                                                    type: 'POST',
                                                    data:{
                                                        ProductId: Product_id,
                                                        //quantity : quantity,
                                                    },
                                                    success: function(dataStok){
                                                        if(dataStok != null){
                                                            if(parseInt(dataStok) > 0){
                                                                var viewStockItem = dataStok;
                                                            }else{
                                                                var viewStockItem = 0;
                                                            }
                                                            if(viewStockItem <= 0){
                                                                //$( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                                                $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                                            }
                                                            $('.stok_pkt'+id).text(viewStockItem);
                                                            $('.stok_bns'+id).text(viewStockItem);
                                                        }
                                                    },
                                                }),

                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/bonus/totalquantity')}}',
                                                    type:'POST',
                                                    data:{
                                                        Product_id : Product_id,
                                                        quantity : quantity,
                                                        price : price,
                                                        paket_id : paket_id,
                                                        group_id : group_id,
                                                        order_id : data
                                                    },
                                                        success: function (data2) {
                                                        // We get the element having id of display_info and put the response inside it
                                                        $('#total_bns'+group_id).text(data2);
                                                        $('#bns_total'+group_id).val(data2);
                                                        $('#checkbox_bns'+id+'_'+group_id).attr("disabled", false);
                                                        $('#checkbox_bns'+id+'_'+group_id).prop('checked', true);
                                                        },
                                                        error: function (data2) {
                                                        console.log('Error:', data2);
                                                        }
                                                });
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: 'center',
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                    }
                                                })

                                                Toast.fire({
                                                    icon: 'success',
                                                    title: 'Bonus berhasil disimpan'
                                                });
                                            },
                                            
                                            error: function (data) {
                                                console.log('Error:', data);
                                            }
                                        });
                                    }
                                    
                                }
                            },
                        })
                        
                    }
                }
                    
            }
        }

        function addcart_allpaket(id)
        {
            var order_id = $('#orderid_addcart'+id).val();
            var paket_id = $('#paket_id'+id).val();
            //var group_id = id;
            var total_paket = $('#total_produk'+id).val();
            var total_bonus =  $('#bns_total'+id).val();
            var bns_max = $('#max_bonus'+id).val();

            if (order_id == "" || total_paket <= 0){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Belum ada paket yang tersimpan'
                });
            }else if(total_paket > 0 && bns_max <= 0){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah paket belum mencapai min. pembelian paket'
                });
            }else{
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/paket_all/cekBeforeSave')}}',
                    type:'POST',
                    data:{
                        order_id : order_id,
                    },
                    success: function (response){
                        //console.log(response);
                        
                        if(response == 0){
                            Swal.fire({
                            //title: 'Apakah anda yakin ?',
                            text: "Paket telah dihapus, karena lebih dari 30 menit tidak melakukan pesanan",
                            //type: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                            }).then(function(){ 
                                location.reload();
                            })
                        }else{
                            if(total_bonus < bns_max){
                                var sisa = parseInt(bns_max) - parseInt(total_bonus);
                                Swal.fire({
                                title: 'Apakah anda yakin ?',
                                text: "Bonus anda masih tersisa "+sisa+" !",
                                //type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Simpan',
                                cancelButtonText:  '\u00A0\u00A0Batal\u00A0\u00A0',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                                }).then((result) => {
                                    if (result.isConfirmed){
                                        $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                        });
                                        $.ajax({
                                            url : '{{URL::to('/keranjang/paket_all/simpan_cart')}}',
                                            type:'POST',
                                            data:{
                                                order_id : order_id,
                                                paket_id : paket_id,
                                                group_id : id,

                                            },
                                            success: function (){
                                                $.ajaxSetup({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        }
                                                });
                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/paket_all/delete_tmp')}}',
                                                    type:'POST',
                                                    data:{
                                                        order_id : order_id,
                                                        paket_id : paket_id,
                                                        group_id : id,

                                                    },
                                                    success: function (){
                                                        Swal.fire({
                                                        //title: 'Apakah anda yakin ?',
                                                        text: "Paket berhasil dimasukkan keranjang",
                                                        //type: 'success',
                                                        showCancelButton: false,
                                                        confirmButtonColor: '#3085d6',
                                                        confirmButtonText: 'Ok',
                                                        showClass: {
                                                            popup: 'animate__animated animate__fadeInDown'
                                                        },
                                                        hideClass: {
                                                            popup: 'animate__animated animate__fadeOutUp'
                                                        }
                                                        }).then(function(){ 
                                                            location.reload();
                                                        })
                                                    },
                                                    
                                                    error: function (data) {
                                                        console.log('Error:', data);
                                                    }
                                                });
                                            },
                                            error: function (data) {
                                                console.log('Error:', data);
                                            }
                                        });
                                    }
                                })
                            }else{
                                $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                });
                                $.ajax({
                                    url : '{{URL::to('/keranjang/paket_all/simpan_cart')}}',
                                    type:'POST',
                                    data:{
                                        order_id : order_id,
                                        paket_id : paket_id,
                                        group_id : id,

                                    },
                                    success: function (){
                                        $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                        });
                                        $.ajax({
                                            url : '{{URL::to('/keranjang/paket_all/delete_tmp')}}',
                                            type:'POST',
                                            data:{
                                                order_id : order_id,
                                                paket_id : paket_id,
                                                group_id : id,

                                            },
                                            success: function (){
                                                Swal.fire({
                                                //title: 'Apakah anda yakin ?',
                                                text: "Paket berhasil dimasukkan keranjang",
                                                //type: 'success',
                                                showCancelButton: false,
                                                confirmButtonColor: '#3085d6',
                                                confirmButtonText: 'Ok',
                                                showClass: {
                                                    popup: 'animate__animated animate__fadeInDown'
                                                },
                                                hideClass: {
                                                    popup: 'animate__animated animate__fadeOutUp'
                                                }
                                                }).then(function(){ 
                                                    location.reload();
                                                })
                                            },
                                            
                                            error: function (data) {
                                                console.log('Error:', data);
                                            }
                                        });
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                    }
                                });    
                            } 
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }

        }    

        
        function button_minus_kr(id)
        {   
            
            var jumlah = $('#jmlkr_'+id).val();
            var jumlah = parseInt(jumlah) - 1;

            // AMBIL NILAI HARGA
            var harga = $('#harga_kr'+id).val();
            var harga = parseInt(harga) * jumlah;

            //AMBIL NILAI TOTAL
            var totalkr = $('#tt_'+id).val();
            var totalkr = parseInt(totalkr) - harga;
            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";

            if (jumlah<1) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'error',
                    title: 'Jumlah order minimal 1'
                });
            } else {
                $('#jmlbrg_'+id).val(jumlah);
                //$('#show_'+id).html(jumlah);
                $('#jmlkr_'+id).val(jumlah);
                $('#show_kr_'+id).html(jumlah);
                $('#productPrice_kr'+id).text(harga);
                $('#totalKr_'+id).text(totalkr);
                var id_detil = $('#id_detil'+id).val();
                var order_id = $('#order_id'+id).val();
                var price = $('#harga_kr'+id).val();
                var id_detil = $('#id_detil'+id).val();
                var order_id = $('#order_id'+id).val();
                var price = $('#harga_kr'+id).val();
                var tot =  parseInt($('#total_kr_val').val()) - parseInt($('#harga_kr'+id).val());
                var tot_val = tot;
                var	number_string = tot.toString();
                var sisa 	= number_string.length % 3;
                var rupiah 	= number_string.substr(0, sisa);
                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
                }

                tot = "Rp. " + rupiah+",-";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/kurang')}}',
                    type:'POST',
                    data:{
                        id_detil : id_detil,
                        order_id : order_id,
                        price : price
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (data) {
                        $('#quantity_delete'+id).val(jumlah);
                        $('#total_kr_').html(tot);
                        $('#total_kr_val').val(tot_val);
                        $('#total_pesan_val').val(tot_val);
                        $('#total_pesan_val_hide').val(tot_val);

                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: id,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    
                                    $('#stok'+id).text(viewStockItem);
                                    $('#stok_top'+id).text(viewStockItem);
                                }
                            },
                        });
                        /*if(voucher_code_hide !=""){
                            $.ajax({
                                url : '{{URL::to('/keranjang/apply_code')}}',
                                type: 'POST',
                                data:{
                                    code : voucher_code_hide
                                },
                                success: function (response){
                                $( '#accordion' ).html(response);
                                $('#collapse-4').addClass('show');
                                //$( '#total_kr_' ).html(response);
                                var total_novoucher_val = $('#total_novoucher_val_code').val();
                                $('#total_novoucher_val').val(total_novoucher_val);
                                $('#voucher_code_hide').val(voucher_code_hide);
                                $('#voucher_code_hide_modal').val(voucher_code_hide);
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                                }
                            });
                        }
                        else{*/
                        $.ajax({
                            url : '{{URL::to('/home_cart')}}',
                            type : 'GET',
                            success: function (response) {
                            // We get the element having id of display_info and put the response inside it
                            //$( '#accordion' ).html(response);
                            //$('#collapse-4').addClass('show');
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                            }
                        });
                        //}
                    },
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
                });

            }
        }

        
        function button_plus_kr(id)
        {
            var getStock = $('#stok'+id).text();
            var jumlah = $('#jmlkr_'+id).val();
            var jumlah = parseInt(jumlah) + 1;
            var price = $('#harga_kr'+id).val();
            var stock = $('#stock'+id).val();
            // AMBIL NILAI HARGA
            var harga = $('#harga_kr'+id).val();
            var harga = parseInt(harga) * jumlah;

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah+",-";
            
            // alert(jumlah)
            if (jumlah < 1) {
            alert('Jumlah order minimal 1')
            }
            else if (jumlah > stock){
                Swal.fire({
                text: "Maaf, stok produk tidak mencukupi",
                icon: 'info',
                showCancelButton: false,
                confirmButtonText: "Tutup",
                confirmButtonColor: '#6a3137'
                });
                $(".swal2-modal").css('background-color', ' #FDD8AF')
            } 
            else 
            {   
                if(parseInt(getStock) < 1){
                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                    Stok tidak mencukupi.\
                                </span>";
                                $("#body_alert_cartPlus").append(tr_str);

                                $('#paramItemPlus').val(id);
                                $('#paramQtyPlus').val(1);
                                $('#paramPricePlus').val(price);
                                
                                $("#validStockCartPlus").modal('show');
                }else{
                    $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                    $.ajax({
                        url : '{{URL::to('/keranjang/checkForCart')}}',
                        type: 'POST',
                        data:{
                            ProductId: id,
                        },
                        success: function(dataStok){
                            if(dataStok != null){
                                //console.log(dataStok);
                                if(parseInt(dataStok) < 1){
                                    
                                    var viewStock = 0;
                                    var tr_str = "<span class='text-left' style='color:#1A4066;'>\
                                                    Produk ini hanya tersisa "+viewStock+", karena sudah terlebih dahulu diambil oleh sales yang lain.\
                                                </span>";
                                    $("#body_alert_cartPlus").append(tr_str);

                                    $('#paramItemPlus').val(id);
                                    $('#paramQtyPlus').val(1);
                                    $('#paramPricePlus').val(price);

                                    $("#validStockCartPlus").modal('show');
                                }else{
                                    $('#jmlbrg_'+id).val(jumlah);
                                    //$('#show_'+id).html(jumlah);
                                    $('#jmlkr_'+id).val(jumlah);
                                    $('#show_kr_'+id).html(jumlah);
                                    $('#productPrice_kr'+id).text(harga);
                                    //$('#totalKr_'+id).text(totalkr);
                                    var id_detil = $('#id_detil'+id).val();
                                    var order_id = $('#order_id'+id).val();
                                    var price = $('#harga_kr'+id).val();
                                    var tot = parseInt($('#harga_kr'+id).val()) + parseInt($('#total_kr_val').val());
                                    var tot_val = tot;
                                    var	number_string = tot.toString();
                                    var sisa 	= number_string.length % 3;
                                    var rupiah 	= number_string.substr(0, sisa);
                                    var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                                    var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                                    //var total_pesan_val_hide = document.getElementById("total_pesan_val_hide").value;
                                    if (ribuan) {
                                    separator = sisa ? '.' : '';
                                    rupiah += separator + ribuan.join('.');
                                    }

                                    tot = "Rp. " + rupiah+",-";
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        url : '{{URL::to('/keranjang/tambah')}}',
                                        type:'POST',
                                        data:{
                                            id_detil : id_detil,
                                            order_id : order_id,
                                            price : price
                                        },
                                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                            $('#loader').removeClass('hidden')
                                        },              
                                        success: function (data) {
                                            $('#quantity_delete'+id).val(jumlah);
                                            $('#total_kr_').html(tot);
                                            $('#total_kr_val').val(tot_val);
                                            $('#total_pesan_val').val(tot_val);
                                            //$('#total_novoucher_val').val(total_pesan_val_hide);
                                            $('#total_pesan_val_hide').val(tot_val);

                                            $.ajax({
                                                url : '{{URL::to('/keranjang/checkForCart')}}',
                                                type: 'POST',
                                                data:{
                                                    ProductId: id,
                                                },
                                                success: function(dataStok){
                                                    if(dataStok != null){
                                                        if(parseInt(dataStok) > 0){
                                                            var viewStockItem = dataStok;
                                                        }else{
                                                            var viewStockItem = 0;
                                                        }
                                                        
                                                        $('#stok'+id).text(viewStockItem);
                                                        $('#stok_top'+id).text(viewStockItem);
                                                    }
                                                },
                                            }),

                                            /*if(getStock > 0){
                                                var newGetStok = parseInt(getStock) -1
                                                $('#stok'+id).text(newGetStok);
                                                $('#stok_top'+id).text(newGetStok);
                                            }
                                            /*if(voucher_code_hide !=""){
                                                $.ajax({
                                                    url : '{{URL::to('/keranjang/apply_code')}}',
                                                    type: 'POST',
                                                    data:{
                                                        code : voucher_code_hide
                                                    },
                                                    success: function (response){
                                                    $( '#accordion' ).html(response);
                                                    $('#collapse-4').addClass('show');
                                                    var total_novoucher_val = $('#total_novoucher_val_code').val();
                                                    //$( '#total_kr_' ).html(response);
                                                    $('#total_novoucher_val').val(total_novoucher_val);
                                                    $('#voucher_code_hide').val(voucher_code_hide);
                                                    $('#voucher_code_hide_modal').val(voucher_code_hide);
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                    $('#loader').addClass('hidden')
                                                    }
                                                });
                                            }
                                            else{*/
                                                $.ajax({
                                                    url : '{{URL::to('/home_cart')}}',
                                                    type : 'GET',
                                                    
                                                    success: function (response) {
                                                    // We get the element having id of display_info and put the response inside it
                                                    //$( '#accordion').html(response);
                                                    //$('#collapse-4').addClass('show');
                                                    },
                                                    complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                                        $('#loader').addClass('hidden')
                                                    }
                                                });
                                            //}
                                            
                                        },
                                        error: function (data) {
                                        console.log('Error:', data);
                                        }
                                    });
                                }
                                
                            }
                        },
                    })
                }
            }
        }

        
        function delete_kr(id)
        {   
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var quantity_delete = $('#quantity_delete'+id).val();
                var quantity_delete = parseInt(quantity_delete);
                var jumlah = $('#jmlbrg_'+id).val();
                var jumlah = parseInt(jumlah) - quantity_delete;
                var order_id_delete = $('#order_id_delete'+id).val();
                var price_delete = $('#price_delete'+id).val();
                var product_id_delete = $('#product_id_delete'+id).val();
                var id_delete = $('#id_delete'+id).val();
                var price = $('#harga'+id).val();
                var voucher_code_hide = document.getElementById("voucher_code_hide").value;
                
                $.ajax({
                    url : '{{URL::to('/keranjang/delete')}}',
                    type:'POST',
                    data:{
                        id : id_delete,
                        product_id : product_id_delete,
                        order_id : order_id_delete,
                        quantity : quantity_delete,
                        price : price_delete
                    },
                    beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                        $('#loader').removeClass('hidden')
                    },              
                    success: function (data) {
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: product_id_delete,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    
                                    $('#stok'+id).text(viewStockItem);
                                    $('#stok_top'+id).text(viewStockItem);
                                }
                            },
                        });
                        //console.log(data);
                        //$('#'+id).val(jumlah);
                        //$('#jmlbrg_'+id).val(jumlah);
                        //$('#show_'+id).html(jumlah);
                        //$('#productPrice'+id).text(harga);
                        /*if(voucher_code_hide !=""){
                            $.ajax({
                                url : '{{URL::to('/keranjang/apply_code')}}',
                                type: 'POST',
                                data:{
                                    code : voucher_code_hide
                                },
                                success: function (response){
                                $( '#accordion' ).html(response);
                                $('#collapse-4').addClass('show');
                                //$( '#total_kr_' ).html(response);
                                var total_novoucher_val = $('#total_novoucher_val_code').val();
                                $('#total_novoucher_val').val(total_novoucher_val);
                                $('#voucher_code_hide').val(voucher_code_hide);
                                $('#voucher_code_hide_modal').val(voucher_code_hide);
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                                }
                            });
                        }else{*/
                        $.ajax({
                            url : '{{URL::to('/home_cart')}}',
                            type : 'GET',
                            success: function (response) {
                            // We get the element having id of display_info and put the response inside it
                            $( '#accordion' ).html(response);
                            $('#collapse-4').addClass('show');
                            if ($(window).width() < 601) {
                                $('#div_total').removeClass('float-left');
                                //$('#div_total').addClass('justify-content-center');
                                $('#div_total').removeClass('mt-2');
                                $('#div_total').addClass('mb-2');
                                $('#beli_sekarang').removeClass('float-right');
                                $('#beli_sekarang').addClass('btn-block');
                                $('#beli_sekarang').addClass('mb-0');
                                $('#chk-bl-btn').removeClass('justify-content-end');
                                $('#chk-bl-btn').addClass('justify-content-center');
                                $('#divchecktunai').addClass('mb-2');
                                $('.dropfilter').removeClass('mt-3');
                                $('#p-title1').addClass('ml-n3');
                                $('#p-title2').addClass('ml-n3');
                                }
                                if ($(window).width() <= 480) {
                                    $('#cont-collapse').removeClass('container');
                                    
                                }
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden')
                            }
                        });
                            //}
                    },
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
            });
        }

        
        function delete_pkt(id,group_id)
        {   
            var orderid_delete =  $('#orderid_delete_pkt'+id+'_'+group_id).val();
            var jml_val = $('#jumlah_val_pkt'+id+'_'+group_id).val();
            var product_id = $('#product_pkt'+id+'_'+group_id).val();
            var paket_id = $('#paket_id'+group_id).val(); 
            var purchase_qty = $('#purchase_qty'+group_id).val();
            var bonus_qty =  $('#bonus_qty'+group_id).val();
            var bns_total = $('#bns_total'+group_id).val();
            // AMBIL NILAI HARGA
            var harga = $('#harga_pkt'+id+'_'+group_id).val();
            

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";

            if(bns_total > 0){

                var total_val_qty = $('#total_produk'+group_id).val();
                var a = parseInt(total_val_qty) - parseInt(jml_val);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                    type:'POST',
                    dataType: 'json',
                    data:{
                        total_qty : a,
                    },
                    success: function(response){
                        if(response['data'] == null){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                                })

                                Toast.fire({
                                icon: 'error',
                                title: 'Gagal !, Total quantity tidak sesuai dengan bonus input',
                            });
                            $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                            $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                        }else{
                            var c = response['data'].bonus_quantity;
                            if(bns_total > c) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'center',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                    })

                                    Toast.fire({
                                    icon: 'error',
                                    title: 'Gagal !, Total quantity tidak sesuai dengan bonus input',
                                });
                                $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", false);
                                $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                            }
                            else{
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url : '{{URL::to('/keranjang/paket/delete_pkt')}}',
                                    type:'POST',
                                    data:{
                                        order_id : orderid_delete,
                                        product_id : product_id,
                                        //paket_id : paket_id,
                                        group_id : group_id
                                    },
                                    success: function () {
                                        $.ajax({
                                            url : '{{URL::to('/keranjang/checkForCart')}}',
                                            type: 'POST',
                                            data:{
                                                ProductId: product_id,
                                            },
                                            success: function(dataStok){
                                                if(dataStok != null){
                                                    if(parseInt(dataStok) > 0){
                                                        var viewStockItem = dataStok;
                                                    }else{
                                                        var viewStockItem = 0;
                                                    }
                                                    if(viewStockItem <= 0){
                                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                                    }else{
                                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                                    }
                                                    $('.stok_pkt'+id).text(viewStockItem);
                                                    $('.stok_bns'+id).text(viewStockItem);
                                                }
                                            },
                                        }),

                                        $.ajax({
                                                url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                                                type:'POST',
                                                data:{
                                                    product_id : product_id,
                                                    //paket_id : paket_id,
                                                    group_id : group_id,
                                                    order_id : orderid_delete
                                                },
                                                success: function (data) {
                                                // We get the element having id of display_info and put the response inside it
                                                $('#total_qty'+group_id).text(data);
                                                $('#total_produk'+group_id).val(data);
                                                $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", true);
                                                $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                                $('#jumlah_val_pkt'+id+'_'+group_id).val(0);
                                                $('#jumlah_pkt'+id+'_'+group_id).val(0);
                                                $('#show_pkt'+id+'_'+group_id).val(0);
                                                $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                                                    $.ajaxSetup({
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        }
                                                    });
                                                    $.ajax({
                                                        url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                                        type:'POST',
                                                        dataType: 'json',
                                                        data:{
                                                            total_qty : data,
                                                        },
                                                        success: function(response){
                                                            var total_qty = parseInt(data);
                                                            var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                                            var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                                            $('#bonus_max'+group_id).text(desimal_kali);
                                                            $('#max_bonus'+group_id).val(desimal_kali);
                                                            $('#paket_id'+group_id).val(response['data'].id);
                                                            $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                                            $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                                        },
                                                        error: function (response) {
                                                        console.log('Error:', response);
                                                        }
                                                    });
                                                }
                                            });
                                        
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'center',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                            })

                                            Toast.fire({
                                            icon: 'success',
                                            title: 'Produk paket berhasil dihapus'
                                        });    
                                    },
                                    
                                    
                                    error: function (data) {
                                    console.log('Error:', data);
                                    }
                                });
                            }
                        }
                    },
                    error: function (response) {
                    console.log('Error:', response);
                    }
                });
                
            }else{
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/paket/delete_pkt')}}',
                    type:'POST',
                    data:{
                        order_id : orderid_delete,
                        product_id : product_id,
                        //paket_id : paket_id,
                        group_id : group_id
                    },
                    success: function () {
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: product_id,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    if(viewStockItem <= 0){
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                    }else{
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                    }
                                    $('.stok_pkt'+id).text(viewStockItem);
                                    $('.stok_bns'+id).text(viewStockItem);
                                }
                            },
                        }),

                        $.ajax({
                                url : '{{URL::to('/keranjang/paket/totalquantity')}}',
                                type:'POST',
                                data:{
                                    product_id : product_id,
                                    //paket_id : paket_id,
                                    group_id : group_id,
                                    order_id : orderid_delete
                                },
                                success: function (data) {
                                // We get the element having id of display_info and put the response inside it
                                $('#total_qty'+group_id).text(data);
                                $('#total_produk'+group_id).val(data);
                                $('#checkbox_pkt'+id+'_'+group_id).attr("disabled", true);
                                $('#checkbox_pkt'+id+'_'+group_id).prop('checked', true);
                                $('#jumlah_val_pkt'+id+'_'+group_id).val(0);
                                $('#jumlah_pkt'+id+'_'+group_id).val(0);
                                $('#show_pkt'+id+'_'+group_id).val(0);
                                $('#productPrice_pkt'+id+'_'+group_id).text(harga);
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        url : '{{URL::to('/keranjang/paket/cek_max_qty')}}',
                                        type:'POST',
                                        dataType: 'json',
                                        data:{
                                            total_qty : data,
                                        },
                                        success: function(response){
                                            var total_qty = parseInt(data);
                                            if(response['data'] != null){
                                                var bonus_kali = total_qty / parseInt(response['data'].purchase_quantity);
                                                var desimal_kali = Math.floor(bonus_kali) * parseInt(response['data'].bonus_quantity);
                                                $('#bonus_max'+group_id).text(desimal_kali);
                                                $('#max_bonus'+group_id).val(desimal_kali);
                                                $('#paket_id'+group_id).val(response['data'].id);
                                                $('#purchase_qty'+group_id).val(response['data'].purchase_quantity);
                                                $('#bonus_qty'+group_id).val(response['data'].bonus_quantity);
                                            }else{
                                                $('#bonus_max'+group_id).text('0');
                                                $('#max_bonus'+group_id).val('0');
                                                $('#paket_id'+group_id).val('');
                                                $('#purchase_qty'+group_id).val('');
                                                $('#bonus_qty'+group_id).val('');
                                            }
                                        },
                                        error: function (response) {
                                        console.log('Error:', response);
                                        }
                                    });
                                }
                            });
                        
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: 'Produk paket berhasil dihapus'
                        });    
                    },
                    
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
                });
            }
        }

        //delete bonus edit s/d februari
        function delete_bns(id,group_id)
        {   
            var orderid_delete =  $('#orderid_delete_bns'+id+'_'+group_id).val();
            var product_id = $('#product_bns'+id+'_'+group_id).val();
            var paket_id = $('#paket_id').val(); 
            var purchase_qty = $('#purchase_qty').val();
            var bonus_qty =  $('#bonus_qty').val();

            // AMBIL NILAI HARGA
            var harga = $('#harga_bns'+id+'_'+group_id).val();
            

            // UBAH FORMAT UANG INDONESIA
            var	number_string = harga.toString();
            var sisa 	= number_string.length % 3;
            var rupiah 	= number_string.substr(0, sisa);
            var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
            }

            harga = "Rp. " + rupiah +",-";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{URL::to('/keranjang/bonus/delete_bns')}}',
                    type:'POST',
                    data:{
                        order_id : orderid_delete,
                        product_id : product_id,
                        paket_id : paket_id,
                        group_id : group_id
                    },
                    success: function () {
                        $.ajax({
                            url : '{{URL::to('/keranjang/checkForCart')}}',
                            type: 'POST',
                            data:{
                                ProductId: product_id,
                            },
                            success: function(dataStok){
                                if(dataStok != null){
                                    if(parseInt(dataStok) > 0){
                                        var viewStockItem = dataStok;
                                    }else{
                                        var viewStockItem = 0;
                                    }
                                    if(viewStockItem <= 0){
                                        //$( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", true );
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                    }else{
                                        $( '#disabled_button_bonus'+id+'_'+group_id ).prop( "disabled", false );
                                    }
                                    $('.stok_pkt'+id).text(viewStockItem);
                                    $('.stok_bns'+id).text(viewStockItem);
                                }
                            },
                        }),

                        $.ajax({
                                url : '{{URL::to('/keranjang/bonus/totalquantity')}}',
                                type:'POST',
                                data:{
                                    product_id : product_id,
                                    paket_id : paket_id,
                                    group_id : group_id,
                                    order_id : orderid_delete
                                },
                                success: function (data) {
                                // We get the element having id of display_info and put the response inside it
                                $('#total_bns'+group_id).text(data);
                                $('#bns_total'+group_id).val(data);
                                $('#checkbox_bns'+id+'_'+group_id).attr("disabled", true);
                                $('#checkbox_bns'+id+'_'+group_id).prop('checked', true);
                                $('#jumlah_val_bns'+id+'_'+group_id).val(0);
                                $('#jumlah_bns'+id+'_'+group_id).val(0);
                                $('#show_bns'+id+'_'+group_id).val(0);
                                $('#productPrice_bns'+id+'_'+group_id).text(harga);
                                }
                            });
                        
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                            icon: 'success',
                            title: 'Produk bonus berhasil dihapus'
                        });    
                    },
                    
                    
                    error: function (data) {
                    console.log('Error:', data);
                    }
                });
        }

        
        function show_modal()
        {
            //$( "#collapse-4" ).load(window.location.href + " #collapse-4" );
            //var checkBox = document.getElementById("checktunai");
            var order_id = $('#order_id_cek').val();
            var total_pesan_val_hide = $('#total_pesan_val_hide').val();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/paket_all/cekBeforeSave')}}',
                type:'POST',
                data:{
                    order_id : order_id,
                },
                success: function (response){
                    //console.log(response);
                    
                    if(response == 0){
                        Swal.fire({
                        //title: 'Apakah anda yakin ?',
                        text: "Produk telah dihapus, karena lebih dari 30 menit tidak melakukan pesanan",
                        //type: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                        }).then(function(){ 
                            location.reload();
                        })
                    }else{
                        $.ajax({
                            url : '{{URL::to('/keranjang/preview_order')}}',
                            type:'POST',
                            data:{
                                order_id : order_id,
                            },
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#loader').removeClass('hidden')
                            },              
                            success: function (response){
                                //$("#modalDetilList").modal('show');
                                $("#my_modal_content").modal('show');
                                $('#PreviewToko_Produk' ).html(response);
                                var diswa = $('#dsbl_btn_wa' ).val();
                                if (diswa.length > 0) {
                                    $('#ga_pesan').attr("disabled", 'disabled');
                                }
                                $('#total_pesan_val').val(total_pesan_val_hide);
                                $('#order_id_pesan').val(order_id);
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden');
                            },
                            
                            error: function (response) {
                            console.log('Error:', response);
                            }
                        }); 
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            
            /*$.ajax({
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
                            var desc = response['data'][i].Product_name;
                            
                            var tr_str = "<li class='text-left' style='color:#7a7a7a;'><small>"+desc+"</small></li>";
                            $("#body_alert").append(tr_str);
                        }
                        $("#modal_validasi").modal('show');
                    }
                    else
                    { */  
                        /*if (checkBox.checked == true){
                            $('#check_tunai_value').val('Tunai');
                        }
                        else{
                            $('#check_tunai_value').val('');
                        }*/
                        /*
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                        });
                        $.ajax({
                            url : '{{URL::to('/keranjang/preview_order')}}',
                            type:'POST',
                            data:{
                                order_id : order_id,
                            },
                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#loader').removeClass('hidden')
                            },              
                            success: function (response){
                                //$("#modalDetilList").modal('show');
                                $("#my_modal_content").modal('show');
                                $('#PreviewToko_Produk' ).html(response);
                                var diswa = $('#dsbl_btn_wa' ).val();
                                if (diswa.length > 0) {
                                    $('#ga_pesan').attr("disabled", 'disabled');
                                }
                                $('#total_pesan_val').val(total_pesan_val_hide);
                                $('#order_id_pesan').val(order_id);
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#loader').addClass('hidden');
                            },
                            
                            error: function (response) {
                            console.log('Error:', response);
                            }
                        });*/
                        //$("#my_modal_content_ajax").modal('show');
                        //$("#my_modal_content_ajax").modal('show');
                    //}
                //}
            //});
        }
        

        function open_detail_pkt(order_id,paket_id,group_id)
        {
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });
            $.ajax({
                url : '{{URL::to('/keranjang/cek_detail/paket')}}',
                type:'POST',
                dataType: 'json',
                data:{
                    order_id : order_id,
                    paket_id : paket_id,
                    group_id : group_id
                },
                success: function(response){
                        var len = 0;
                        $('#body_detail_pkt').empty();
                        if(response['data'] != null){
                            len = response['data'].length;
                        }

                        if(len > 0){
                            
                            for(var i=0; i<len; i++){
                                var desc = response['data'][i].Product_name;
                                var qty = response['data'][i].quantity;
                                var prc = response['data'][i].price_item;
                                var ttl = parseInt(prc) * parseInt(qty);
                                // UBAH FORMAT UANG INDONESIA
                                var	number_string = ttl.toString();
                                var sisa 	= number_string.length % 3;
                                var rupiah 	= number_string.substr(0, sisa);
                                var ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

                                if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                                }

                                ttl = rupiah +",-";
                                var tr_str = "<tr>\
                                                <td>"+desc+"</td>\
                                                <td>"+qty+"</td>\
                                                <td>"+ttl+"</td>\
                                             </tr>";
                                $("#body_detail_pkt").append(tr_str);
                            }
                            $("#DeatailPaket").modal('show');
                        }
                        
                    }
            });
        }

        function delete_kr_pkt(order_id,paket_id,group_id)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url : '{{URL::to('/keranjang/delete_kr/paket')}}',
                type:'POST',
                dataType: 'json',
                data:{
                    order_id : order_id,
                    paket_id : paket_id,
                    group_id : group_id
                },
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $('#loader').removeClass('hidden')
                },              
                success: function (response) {
                    //console.log(response);
                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    //console.log(len);
                    if(len > 0){
                        
                        for(var i=0; i<len; i++){
                            
                            var idPr = response['data'][i].product_id;
                            var quantity = response['data'][i].quantity;
                            var viewStockItem = parseInt(quantity);
                            var st = $('#stok'+idPr).text();
                            var st_top = $('#stok_top'+idPr).text();
                            var st_pkt = $('.stok_pkt'+idPr).text();
                            var st_bns = $('.stok_bns'+idPr).text();

                            $('#stok'+idPr).text(parseInt(st) + viewStockItem);
                            $('#stok_top'+idPr).text(parseInt(st_top) + viewStockItem);
                            $('.stok_pkt'+idPr).text(parseInt(st_pkt) + viewStockItem);
                            $('.stok_bns'+idPr).text(parseInt(st_bns) + viewStockItem);
                        }
                    }
                    
                    $.ajax({
                        url : '{{URL::to('/keranjang/deleteCartPkt')}}',
                        type:'POST',
                        data:{
                            order_id : order_id,
                            paket_id : paket_id,
                            group_id : group_id
                        },
                        beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                            $('#loader').removeClass('hidden')
                        },              
                        success: function (data) {
                            
                            $.ajax({
                                url : '{{URL::to('/home_cart')}}',
                                type : 'GET',
                                success: function (response) {
                                    // We get the element having id of display_info and put the response inside it
                                    $( '#accordion' ).html(response);
                                    $('#collapse-4').addClass('show');
                                    if ($(window).width() < 601) {
                                        $('#div_total').removeClass('float-left');
                                        //$('#div_total').addClass('justify-content-center');
                                        $('#div_total').removeClass('mt-2');
                                        $('#div_total').addClass('mb-2');
                                        $('#beli_sekarang').removeClass('float-right');
                                        $('#beli_sekarang').addClass('btn-block');
                                        $('#beli_sekarang').addClass('mb-0');
                                        $('#chk-bl-btn').removeClass('justify-content-end');
                                        $('#chk-bl-btn').addClass('justify-content-center');
                                        $('#divchecktunai').addClass('mb-2');
                                        $('.dropfilter').removeClass('mt-3');
                                        $('#p-title1').addClass('ml-n3');
                                        $('#p-title2').addClass('ml-n3');
                                    }
                                    if ($(window).width() <= 480) {
                                        $('#cont-collapse').removeClass('container');
                                        
                                    }
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                    $('#loader').addClass('hidden')
                                }
                            });
                        },
                        
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });

                },
                
                error: function (response) {
                    console.log('Error:', response);
                }
            });
        }

        $(document).ready(function() {  
            $('#btn-yes').on('click', function(){
                var id_modal = $("#modal-input-id").val();
                Swal.fire('Yes!');
            });
        });
        
        function search_paket(group_id){
            var query = $('#src_pkt'+group_id).val();
            var gr_cat = $('#src_groupcat'+group_id).val();
            var order_id = $('#orderid_addcart'+group_id).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{URL::to('/keranjang/paket/product_search')}}',
                method:'POST',
                data:{
                        query:query,
                        group_id:group_id,
                        gr_cat:gr_cat,
                        order_id:order_id,
                        customer_id:$('#ses_order').val(),
                     },
                //dataType:'json',
                //success:function(data)
                success:function(response)
                {
                    $('#paket_cari'+group_id).html(response);
                    //$('#total_records').text(data.total_data);
                }
            });
        }

        function search_bonus(group_id){
            var query = $('#src_bns'+group_id).val();
            var gr_cat = $('#src_groupcatbns'+group_id).val();
            var order_id = $('#orderid_addcart'+group_id).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{URL::to('/keranjang/bonus/product_search')}}',
                method:'POST',
                data:{
                        query:query,
                        group_id:group_id,
                        gr_cat:gr_cat,
                        order_id:order_id
                     },
                //dataType:'json',
                //success:function(data)
                success:function(response)
                {
                    //console.log(order_id);
                    $('#bonus_cari'+group_id).html(response);
                    //$('#total_records').text(data.total_data);
                }
            });
        }

        function open_preview(order_id){
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

        function logout_record(){
            $.ajax({
                url : '{{URL::to('/sales/logout-record')}}',
            });
        }

        /*
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(".alert").slideUp(500); 
        });
        }, 6000);*/
        
        //upload PO
        $(document).ready(function (e) {
            $('#imagePo').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => { 
                        $('#preview-image-before-upload').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });
        });

        //validate upload PO
        var _validFileExtensions = [".jpg", ".jpeg", ".png"];    
        function ValidatePo(oForm) {
            var arrInputs = oForm.getElementsByClassName("imagePo");
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
                                text: 'Maaf,  Jenis file dokumen PO tidak diizinkan...(ekstensi yang diizinkan adalah'+ _validFileExtensions.join(", ")+') ',
                                
                                });
                            return false;
                        }else{
                            Swal.fire({
                                title: 'Berhasil',
                                text: "Anda melakukan pesanan melalui whatsapp",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: "OK",
                                confirmButtonColor: '#4db849'
                                }).then(function(){ 
                                    window.location.href = '{{URL::to('/success/send/order')}}';
                            });
                        }
                    }
                }
            }
            
            return true;
            
        }
    </script>
    <script>
        $(document).ready(function(){
            var submitIcon = $('.searchbar-icon');
            var inputBox = $('.searchbar-input');
            var searchbar = $('.searchbar');
            var isOpen = false;
            submitIcon.click(function(){
                if(isOpen == false){
                    searchbar.addClass('searchbar-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
                    searchbar.removeClass('searchbar-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });
            submitIcon.mouseup(function(){
                return false;
            });
            searchbar.mouseup(function(){
                return false;
            });
            $(document).mouseup(function(){
                if(isOpen == true){
                $('.searchbar-icon').css('display','block');
                submitIcon.click();
                }
            });
        });
            
        function buttonUp(){
            var inputVal = $('.searchbar-input').val();
            inputVal = $.trim(inputVal).length;
            if( inputVal !== 0){
                $('.searchbar-icon').css('display','none');
            } else {
                $('.searchbar-input').val('');
                $('.searchbar-icon').css('display','block');
            }
        }
        /*
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-183852861-1');*/
    </script>
</body>

</html>