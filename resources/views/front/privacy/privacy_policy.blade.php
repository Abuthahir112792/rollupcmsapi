@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.privacy_policy.privacy_policy') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')
@include('front.layouts.top_nav',['is_login' => $is_login])

@stop
@section('content')
<main>
       <section class="product-tab pt-60 pb-30" id="download">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>{{ __('front/label.privacy_policy.privacy_policy') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- product tab menu start -->
                        {!! !empty($privacy->page_content) ? $privacy->page_content : '' !!}
                    </div>
                </div>
            </div>
        </section>
</main>
@stop
