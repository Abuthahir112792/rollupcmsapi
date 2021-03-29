@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.privacy_policy.privacy_policy') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
@stop
@section('header')


    <header class="bg-header more-screen-inner">
        <div class="container">
            <div class="row no-gutters py-2">
                <h4 class="header-sub-title">Privacy Policy</h4>
            </div>
        </div>
    </header>
@stop
@section('content')
<div class="container" style="padding:20px;font-size: 15px;">
    {!! !empty($privacy->page_content) ? $privacy->page_content : '' !!}
</div>
@stop
