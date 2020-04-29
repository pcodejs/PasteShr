@extends('front.layouts.default')

@section('content')
<main>
  <div class="container mb-5 mt-5 pt-5">
<div class="col-sm-12 text-center">
  <div class="content">
    <div class="title" style="font-size: 156px;">404</div>
    <div class="quote" style="font-size: 36px;">{{ __('Page not found')}}.</div>
    <div class="explanation" style="font-size: 24px;"> <br>
      <small> {{ __('Please return to')}} <a href="{{url('/')}}">{{ __('our homepage')}}</a>. </small> </div>
  </div>
</div>
</div>
</main>
@stop