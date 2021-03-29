@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.home.home') }}
@stop
@section('css')
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/front.home.css') }}" rel="stylesheet" type="text/css" />

    <!-- Pwa -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('front/images/icon.png') }}">
    
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-640x1136.png') }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-750x1294.png') }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-1242x2148.png') }}" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-1125x2436.png') }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-1536x2048.png') }}" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-1668x2224.png') }}" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="{{ asset('front/images/splash/launch-2048x2732.png') }}" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">


    <!-- Whatsapp share icon and details -->
    <meta property="og:site_name" content="Falcon Fruits and Vegetable">
    <meta property="og:title" content="Falcon Fruits and Vegetable" />
    <meta property="og:description" content="Easy Home delivery with just voice or text." />
    <meta property="og:image" itemprop="image" content="{{ asset('front/images/icon.png') }}">
    <meta property="og:type" content="website" />


    <style>
        .home-demo{
            padding: 0 10px;
            width: 100%;
        }
        .home-demo iframe{width: 100%;border-radius: 10px;}
        / .home-demo .owl-carousel .owl-stage-outer .owl-item{border-radius: 10px;} /
        .owl-carousel .item-video {
            height: 130px;
        }
        .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span{
            background-color: #1b88db;
        }
        .owl-stage{
            display:flex
        }
        .owl-stage-outer{
            overflow:hidden
        }
        .customerly-launcher{
            bottom:60px !important;
        }
        .owl-carousel-image{direction:ltr !important}
        .owl-carousel-image > .owl-nav{display:none !important}
        .owl-carousel-image > .owl-stage-outer > .owl-stage > .owl-item{padding: 15px;height: 100%;}
        .owl-carousel-image > .owl-stage-outer > .owl-stage {height:35vh}
        .owl-carousel-image > .owl-stage-outer > .owl-stage > .owl-item .carousel-image{
            box-shadow: 0 3px 6px rgba(0,0,0,0.05), 0 3px 6px rgba(0,0,0,0.05);
            height: 100%;border-radius: 3px;background-size: cover!important;background-repeat:no-repeat!important}

        /* header */
        .container.home-header:after,.container.home-header:before{display:none}







        #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        }

        #myImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        }


        /* Add Animation */
        .modal-content, #caption {  
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
        from {-webkit-transform:scale(0)} 
        to {-webkit-transform:scale(1)}
        }

        @keyframes zoom {
        from {transform:scale(0)} 
        to {transform:scale(1)}
        }

        /* The Close Button */
        .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #ffffff;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        opacity:1 !important;
        }

        .close:hover,
        .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
        }


        #customerly-container .customerly-launcher{
            z-index:1900 !important;
        }














    </style>
@stop

@section('loader')
    <div class="preloader" style="display: none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@stop

@section('header')
    <header>
        @include('front.layouts.top_nav',['is_login' => $is_login])




        <div class="home-header">
            <div class="container" > 
            <div class="justify-content-between py-4 " style="display:flex">
                <img src="{{ asset('front/images/icon.png') }}" height="100" >
                <div class="login-logout">
                    @if($is_login == 1)
                        <a href="#" class="logout" id="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <!-- {{ __('front/label.home.logout') }} -->
                        </a>
                        @else
                         <a href="{{ route('front.login.show') }}" class="logout">
                             <div>
                             <i class="fas fa-sign-in-alt"></i>
                              / 
                             <i class="fas fa-user-plus"></i>
                             </div>
                             <!-- {{ __('front/label.home.login_register') }} -->
                        </a>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </header>
@stop

@section('content')
    <main class="main container" role="main">
        <div>
        <!-- <div class="container-fluid"> -->
        <div>
                
                @if($is_login == 1 )
                <div class="col-md-12 p-0 pt-5" >
                <span style="font-size:2.2rem;font-weight: 500;text-transform: capitalize;">{{ __('front/label.home.hi') }} {{$cms_data['getusername']->name}}</span>
                </div>
                <div class="col-md-12 p-0 pb-3" >
                <span style="font-size:1.5rem">{{ __('front/label.home.hello_message') }}</span>
                </div>
                <br/>
                @if($order_allow == 1)
                
                
                <div class="col-md-12" style="border:1.5px solid #1b88db ;border-radius: 10px;padding: 15px 10px;margin-top:25px">
                    <div class="col-md-12 order-int-voice" >
                        <div class="input-ct group order-input">
                            <input type="text" id="description" name="description" required>
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>{{ __('front/label.home.order') }}</label>
                            <a href="#" id="voice_microphone" class="voice-cmd"><i class="fas fa-microphone"></i></a>
                        </div>
                        <div class="form-group delivery-method" >
                            <div class="delivery-method-item delivery-method-active select-home-delivery">
                                 <i class="fas fa-shipping-fast" ></i>
                                <div>{{ __('front/label.home.homedelivery') }}</div>
                            </div>
                            <div class="delivery-method-item select-slef-pickup">
                                <i class="fas fa-shopping-bag" ></i>
                                <div>{{ __('front/label.home.selfpickup') }}</div>
                            </div>

                        </div>
                        <input type="button" id="place_order" class="btn-primary place-order mb-4 mt-5" value="{{ __('front/label.home.place_order') }}">
                    </div>
                @else

                    <div
                    style="align-content: center;background: rgba(242,242,242,0.7);border-radius: 25px;padding: 15px 0px;margin:20px auto;width:80%;
                        text-align: center;font-weight: bold;font-size: 1.8rem;color: #1b88db;"
                    >Shop is Closed </div>
                @endif
                 @else
                 <div class="col-md-12 p-0 pt-5" >
                <span style="font-size:2.2rem;font-weight: 500;text-transform: capitalize;">{{ __('front/label.home.login_register') }}</span>
                </div>
                 <div class="col-md-12 p-0 pb-3" >
                <span style="font-size:1.5rem">{{ __('front/label.home.hello_message') }}</span>
                </div>
                @endif
            </div>



                 
            <div class="row mt-4 mb-4">
                 @if(!empty($cms_data['images']) && count($cms_data['images']) > 0)
                <div class="col-md-12 p-0">

                <div class="owl-carousel-image">
                @foreach($cms_data['images'] as $key => $csm_media)
                        <div class="carousel-image d-block w-100"
                        style="background:url({{ asset('cms_media/images') }}/{{ $csm_media }})"
                        >
                        
                        </div>
                 @endforeach
                </div>
                </div>
                @endif
                <br/>
            </div>
                @if($is_login == 1 )
                <!-- <div class="row"> -->
               
                <!-- <div class="col-md-12 p-0" style="margin-right: 20px;margin-left: 20px;"> -->
                <span class="pending-orders-title">
                {{ __('front/label.home.pending') }}
                </span>
                 <!-- </div> -->
                @if(!empty($cms_data['getpendingorders']) && count($cms_data['getpendingorders']) > 0)
                
                <div class="mt-4 mb-5">

                <div class="owl-carousel-pending-orders" dir='ltr'>
                @foreach($cms_data['getpendingorders'] as $key => $getpendingorders)
                        <div class="pending-order-item d-block">
                        <div>
                            <button class="button pending-ord-btn">{{ $getpendingorders->order_id}}</button>
                        </div>
                        <div class="pending-ord-descp">{{ $getpendingorders->order_description}}</div>
                        <br/>
                        @if($getpendingorders->self_pickup=='True')    
                            <span class="pending-order-self-pickup-status">
                            {{ __('front/label.home.self-pickup-short') }}</span>
                        @else
                           
                        @endif
                        <span class="pending-order-date">{{ $getpendingorders->created_at}}</span>
                        </div>
                 @endforeach
                </div>
                </div>
                
                @else
                    <div
                    style="align-content: center;background: rgba(242,242,242,0.7);border-radius: 25px;padding: 15px 0px;margin:20px auto;width:80%;
                        text-align: center;font-weight: bold;font-size: 1.8rem;color: #1b88db;"
                    >No More</div>
                    @endif
                @else
                 
                    <!-- <div
                    style="align-content: center;background: rgba(242,242,242,0.7);border-radius: 25px;padding: 15px 0px;margin:20px auto;width:80%;
                        text-align: center;font-weight: bold;font-size: 1.8rem;color: #1b88db;"
                    >Shop is Closed </div> -->
                @endif

               


            <!-- The Modal -->
            <div id="myModal" class="modal" style="z-index: 2000">
                <span class="close">&times;</span>
                <img class="modal-content" id="img01">
                <div id="caption"></div>
            </div>

</div>


<div >
                @if(!empty($cms_data['videos']) && count($cms_data['videos']) > 0)
                <div class="video-slider" style="direction: ltr;">
                    <div class="home-demo">
                        <div class="owl-carousel owl-theme">
                            @foreach($cms_data['videos'] as $key => $csm_media)
                            <div class="item">
                            <video controls="" 
                            style="width:100%;height:25vh;border-radius:3px;margin-top:3px;box-shadow: 0 3px 6px rgba(0,0,0,0.05), 0 3px 6px rgba(0,0,0,0.05);"
                            class="videos"
                            preload="metadata"
                            >
                                        <source src="{{ asset('cms_media/videos/') }}/{{ $csm_media }}#t=1" type="video/mp4">
                                        <!-- <source src="movie.ogg" type="video/ogg"> -->
                                        Your browser does not support the video tag.
                                    </video>    
                            
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>


                        {{--<div id="myCarousel video-slider" class="carousel slide new-vid-slider" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                @foreach($cms_data['videos'] as $key => $csm_media)
                                    <li data-target="#myCarousel" data-slide-to="{{ $key }}" class="{{ $key == 1 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" >
                                @foreach($cms_data['videos'] as $key => $csm_media)
                                <div class="item {{ $key == 0 ? 'active' : '' }}">
                                    <video controls="" class="videos">
                                        <source src="{{ asset('cms_media/videos/') }}/{{ $csm_media }}" type="video/mp4">
                                        <!-- <source src="movie.ogg" type="video/ogg"> -->
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                @endforeach
                            </div>
                        </div>--}}
                @endif

                
                <div class="mb-3" style="height:160px">
                    <a href="{{ route('front.privacy_policy') }}" style='color: inherit;'>
                    <div class="col-md-3 col-xs-3 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="home-circle-icon cicle-policy"><i class="fas fa-user-shield"></i></div>
                        <p class="circle-text">{{ __('front/label.home.privacy_policy') }}</p>
                    </div>
                    </a>
                    <a href="{{ route('front.terms_condition') }}" style='color: inherit;'>
                    <div class="col-md-3 col-xs-3 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="home-circle-icon cicle-terms"><i class="fas fa-file"></i></div>
                        <p class="circle-text">{{__('front/label.home.terms_conditions')}}</p>
                    </div>
                        </a>
                    <a href="{{ $is_login == 1 ? route('front.feedback') : route('front.login.show') }}" style='color: inherit;'>    
                    <div class="col-md-3 col-xs-3 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="home-circle-icon cicle-feedback"><i class="fas fa-comment"></i></i></div>
                        <p class="circle-text">{{__('front/label.home.feedback')}}</p>
                    </div>
                        </a>
                        <a href="{{ $is_login == 1 ? route('front.referral') : route('front.login.show') }}" style='color: inherit;'>    
                    <div class="col-md-3 col-xs-3 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="home-circle-icon cicle-refer"><i class="fas fa-user-plus"></i></div>
                        <p class="circle-text">{{__('front/label.home.refer_friends')}}</p>
                    </div>
                        </a>
                </div>




                <!-- <div class="col-md-12 text-center">
                    <a class="w-100 float-left mt-2" href="{{ route('front.privacy_policy') }}">{{ __('front/label.home.privacy_policy') }}</a>
                    <a class="w-100 float-left mt-2" href="{{ route('front.terms_condition') }}">{{__('front/label.home.terms_conditions')}}</a>
                </div> -->
                <div class="mb-3 w-100">
                <div class="col-sm-6 col-xs-6 col-md-6 text-center">
                    <button   class="btn btn btn-primary" 
                    style="width: 100%;border-radius: 3px !important;">
                        <a href="tel:+{{ $cms_data['Shopkeeperno'] }}" style="color: white;
                    text-decoration: none;">{{__('front/label.home.contact_us')}}</a></button>
                </div>
                
                <div class="col-sm-6 col-xs-6 col-md-6 text-center">
                    <button   class="btn btn btn-primary" style="width: 100%;border-radius: 3px !important;">
                        <a 
                         style="color: white;
                    text-decoration: none;"
                        href = "mailto: {{ $cms_data['Shopkeeperemail'] }}">{{__('front/label.home.send_email')}}</a></button>
                </div>
            </div>
                
                
            </div>
        </div>
    </main>

    <div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.home.ok') }}</a>
                </div>
            </div>
        </div>
    </div>






</div>
    @include('front.layouts.nav',['is_login' => $is_login])
@stop
@section('footer')
@stop
@section('slider')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        jQuery.noConflict();
        // Code that uses other library's $ can follow here.
    </script>
@stop
@section('javascript')
    <script src="{{ asset('front/js/home.js') }}"></script>
    <script type="text/javascript">
       var username = window.localStorage.getItem('username');
       var userid = window.localStorage.getItem('userid');
       var useremail = window.localStorage.getItem('useremail');
   // alert(username);
   //var userid =   document.getElementById("name").value;
       //alert(username);
       if((username != null) ){
       window.customerlySettings = {

        app_id: '{{ env('CUSTOMERLY') }}',
        name: username, 
        id: userid, 
        email: useremail, 
    };
    !function(){function e(){var e=t.createElement("script");
    e.type="text/javascript",e.async=!0,
    e.src="https://widget.customerly.io/widget/76ae9ebb";
    var r=t.getElementsByTagName("script")[0];r.parentNode.insertBefore(e,r)}
    var r=window,t=document,n=function(){n.c(arguments)};
    r.customerly_queue=[],n.c=function(e){r.customerly_queue.push(e)},
    r.customerly=n,r.attachEvent?r.attachEvent("onload",e):r.addEventListener("load",e,!1)}();
    }
    </script>
    <script src="{{ asset('front/js/speech_recognize.js') }}"></script>
    <script>

      $('.owl-carousel-pending-orders').owlCarousel({
            merge:true,
            lazyLoad:true,
            // rtl: true,
            margin:15,
            autoWidth:true,
            dots:false,
            nav:false,
            responsiveClass:true,
            responsive:{
                1000:{
                    items:3
                }
            }
        })  


    $('.owl-carousel-image').owlCarousel({
            loop:true,
            items:1,
            merge:true,
            lazyLoad:true,
            center:true,
            autoplay:true,
            dots:false,
            autoplayTimeout:4000,
            nav:false,
            responsiveClass:true,
            responsive:{
                1000:{
                    items:3
                }
            }
        })

        $('.owl-carousel').owlCarousel({
            items:1,
            merge:true,
            margin:10,
            video:true,
            lazyLoad:true,
            center:true,
        })


        var modal = document.getElementById("myModal");
        $('.owl-carousel-image .owl-stage').on('click',(e)=>{
            const s = document.querySelector('.owl-item.active .carousel-image');
            var modalImg = document.getElementById("img01");
            // console.log(s.style.background.split("\"")[1]);
            modal.style.display = "block";
            modalImg.src=s.style.background.split("\"")[1]
            
        })

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() { 
        modal.style.display = "none";
        }
    </script>

@stop
