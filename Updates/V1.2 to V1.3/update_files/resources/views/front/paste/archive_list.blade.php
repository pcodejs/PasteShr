@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
<meta name="author" content="{{config('settings.site_name')}}">

<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url('img/image.png')}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('content')
<main> 
  
  <!--Main layout-->
  <div class="container"> 
    <!--First row-->
    <div class="row wow fadeIn" data-wow-delay="0.2s">
      <div class="col-md-9">
        <div class="col-md-12 m-2 text-center"> @if(config('settings.ad') == 1){!! html_entity_decode(config('settings.ad1')) !!}@endif </div>
        <div class="card">
          <div class="card-header"> {{ __('Archive')}} </div>
          <div class="row m-2"> @foreach($syntaxes as $syntax)
            <div class="col-md-4"><a class="" href="{{url('archive/'.$syntax->slug)}}">{{$syntax->name}}</a></div>
            @endforeach </div>
        </div>
        <div class="col-md-12 m-2 text-center"> @if(config('settings.ad') == 1){!! html_entity_decode(config('settings.ad2')) !!}@endif </div>
      </div>
      <div class="col-md-3"> @include('front.paste.recent_pastes') <div class="col-md-12 mt-2 mb-2 text-center"> @if(config('settings.ad') == 1){!! html_entity_decode(config('settings.ad3')) !!}@endif </div></div>
    </div>
    <!--/.First row--> 
    
  </div>
  <!--/.Main layout--> 
  
</main>
@stop 