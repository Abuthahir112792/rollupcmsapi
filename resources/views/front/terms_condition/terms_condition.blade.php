@extends('front.layouts.app')

@section('title')
    {{ __('front/label.title') }} - {{ __('front/label.terms_condition.terms_condition') }}
@stop
@section('css')
    <link href="{{ asset('front/css/login.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')
@include('front.layouts.top_nav',['is_login' => $is_login])
<main>
       <section class="product-tab pt-60 pb-30" id="download">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2>{{ __('front/label.terms_condition.terms_condition') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <!-- product tab menu start -->
                        {!! !empty($terms->page_content) ? $terms->page_content : '' !!}
                    </div>
                </div>
            </div>
        </section>
</main>
@stop

