@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.referral.referral') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/front.referral.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')
@include('front.layouts.top_nav',['is_login' => $is_login])

    <header class="bg-header more-screen-inner">
        <div class="container">
            <div class="row no-gutters py-2">
                <div class="col-xs-1">
                    <a 
                    href="{{ $is_login == 1 ? route('front.more') : route('front.login.show') }}"
                    ><img class="back" src="{{ asset('front/images/back.png') }}"></a>
                </div>
                <div class="col-xs-6 text-left px-2">
                    <a 
                    href="{{ $is_login == 1 ? route('front.more') : route('front.login.show') }}"
                    class="mobile-header-page-link text-white">{{ __('front/label.referral.referral') }}</a>
                </div>
            </div>
        </div>
    </header>
@stop
@section('content')




<section class="d-flex flex-column justify-content-center align-items-center referral-container">
    <img src="{{ asset('front/images/referral.png') }}" class="referral-image" />
        <div class="container">
            <h4 class="text-center mt-5 mb-4 referral-text">{{ __('front/label.referral.referral_heading') }}</h4>
            <p class="text-center referral-sub-text">
            {{ __('front/label.referral.referral_sub_heading') }}
            </p>        
            <br/>
            <p class="text-center font-weight-bold referral-code-text">
            {{ __('front/label.referral.referral_code') }}
            </p>
            <div class="text-center m-5">
                    <span class=" font-weight-bold referral-code" id="r-code">
                    
                    </span>
                    
            </div>
            <div class=" alert alert-primary text-center col-md-12 col-xs-12 col-md-12 referral-code-message" role="alert" style="display:none">
                {{ __('front/label.referral.referraltext') }}
                </div>
            <div class="col-md-12 col-xs-12 col-md-12 text-center mt-3 mb-2">
                <input 
                style="background:var(--primary-color) !important"
                type="button" id="userfeedback" class="btn btn btn-primary" value="{{ __('front/label.referral.share') }}">
               
            </div>
            
        </div>

</section>

@stop


@section('javascript')
    <script>
        $( document ).ready(function() {
            if (!navigator.share){
            $('#userfeedback').css({"display":"none"}) 

            }
        });



        var userid = window.localStorage.getItem('userid');
         $("#r-code").html("RCBDS"+userid);
        const span = document.querySelector("#r-code");

        span.onclick = function() {
        document.execCommand("copy");
        }

        span.addEventListener("copy", function(event) {
        event.preventDefault();
        if (event.clipboardData) {
            $('.referral-code-message').css({"display":"block"})
            setTimeout(() => {
            $('.referral-code-message').css({"display":"none"}) 
            }, 2000);
            event.clipboardData.setData("text/plain", span.textContent);
            console.log(event.clipboardData.getData("text"))
        }
        });



        $('#userfeedback').on('click',function(){
            if (navigator.share) {
              navigator.share({
                title: 'Falcon Fruits and Vegetable',
                text: `Easy Grocery purchase with Falcon Fruits and Vegetable app use Referral Code RCBDS${userid} while registration`,
                url: 'http://onelink.to/vtmznj',
              })
                .then(() => console.log('Successful share'))
                .catch((error) => console.log('Error sharing', error));
            }
        })
        
    
    </script>
    
@stop



