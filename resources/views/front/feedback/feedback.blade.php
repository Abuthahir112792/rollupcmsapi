@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.feedback.feedback') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/front.feedback.css') }}" rel="stylesheet" type="text/css" />
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
                    class="mobile-header-page-link text-white">{{ __('front/label.feedback.feedback') }}</a>
                </div>
            </div>
        </div>
    </header>
@stop
@section('content')





<section class="d-flex flex-column justify-content-center align-items-center feedback-container">
    <img src="{{ asset('front/images/feedback.png') }}" class="feedback-image" />
        <div class="container">
            <h4 class="text-center mt-5 mb-4 feedback-text">{{ __('front/label.feedback.feedback_heading') }}?</h4>
            <div class="feedback-stars text-center" style="font-size: 20px;">
                <span class="fa fa-star star-1" data-index="1"></span>
                <span class="fa fa-star star-2" data-index="2"></span>
                <span class="fa fa-star star-3" data-index="3"></span>
                <span class="fa fa-star star-4" data-index="4"></span>
                <span class="fa fa-star star-5" data-index="5"></span>
            </div>
            <div class="feedback-note text-center">
            	<input type="hidden" id="user_id" name="user_id" >
            	
                <input type="hidden" id="feedback_rate" name="feedback_rate" >
            	
                <textarea class="form-control rounded-0 " placeholder="{{ __('front/label.feedback.add_note') }}" id="feedback_description" name="feedback_description" rows="8"></textarea>

                
            </div>
            <div class="col-md-12 col-xs-12 col-md-12 text-center mt-3 mb-2">
                <input type="button" id="userfeedback" class="btn btn btn-primary" value="{{ __('front/label.feedback.submit') }}">
            </div>
            
        </div>

        <!-- <div style="display:none" class="star-value">0</div> -->
</section>

<div class="modal fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_message">

                </div>
                <div class="modal-footer border-0 p-0">
                    <a href="" id="notification_action" class="btn btn-link text-dark text-decoration-none">{{ __('front/label.profile.ok') }}</a>
                </div>
            </div>
        </div>
    </div>


    
@stop

@section('javascript')
    <script src="{{ asset('front/js/feedback.js') }}"></script>
    <script type="text/javascript">
       var userid = window.localStorage.getItem('userid');

       $("#user_id").val(userid);

/*
        let s1 = $('.star-1')
        let s2 = $('.star-2')
        let s3 = $('.star-3')
        let s4 = $('.star-4')
        let s5 = $('.star-5')
        let stval = $('.star-value')

        s1.click(()=>{
            s1.addClass('checked')
            s2.removeClass('checked')
            s3.removeClass('checked')
            s4.removeClass('checked')
            s5.removeClass('checked')
            stval.html(1)
        })
        s2.click(()=>{
            s1.addClass('checked')
            s2.addClass('checked')
            s3.removeClass('checked')
            s4.removeClass('checked')
            s5.removeClass('checked')
            stval.html(2)
        })
        s3.click(()=>{
            s1.addClass('checked')
            s2.addClass('checked')
            s3.addClass('checked')
            s4.removeClass('checked')
            s5.removeClass('checked')
            stval.html(3)
        })
        s4.click(()=>{
            s1.addClass('checked')
            s2.addClass('checked')
            s3.addClass('checked')
            s4.addClass('checked')
            s5.removeClass('checked')
            stval.html(4)
        })
        s5.click(()=>{
            s1.addClass('checked')
            s2.addClass('checked')
            s3.addClass('checked')
            s4.addClass('checked')
            s5.addClass('checked')
            stval.html(5)
        })
*/

    </script>
@stop

