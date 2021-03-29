@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.order_profile.order_history')}}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('front/css/responsive.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('loader')
    <div class="preloader" style="display: none">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@stop

@section('content')
@include('front.layouts.top_nav',['is_login' => $is_login])

<div class="order-detail-back container">
    <a
    href="{{ $is_login == 1 ? route('front.order.history') : route('front.login.show') }}" 
    >
    <span
    ><i class="fas fa-arrow-left"></i> Back</span>
</a>
</div>

    <main class="main mt-4" role="main">
        <input type="hidden" name="orderid" id="orderid" value="{{ $orderid }}">
        <div class="container" >
            <!-- <h4 id="shop-detail-status"></h4> -->
            <div class="row" id="main_order_details">
            </div>
        </div>
    </main>
    

    <div class="modal fade" id="notification_action_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body" id="notification_action_message">
                
                </div>
                <input type="hidden" name="notification_action_orderid" id="notification_action_orderid" class="notification_action_orderid">
                <div class="modal-footer border-0 p-0">
                    <a href=""  class="btn btn-link text-dark text-decoration-none" data-dismiss="modal">{{ __('front/label.home.cancel') }}</a>
                    <a href=""  class="btn btn-link text-dark text-decoration-none cancel_order">{{ __('front/label.home.ok') }}</a>
                </div>
            </div>
        </div>
    </div>

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
    @include('front.layouts.nav',['is_login'=>$is_login])
@stop
@section('footer')
@stop

@section('javascript')
    <script src="{{ asset('front/js/order.js') }}"></script>
    
@stop
