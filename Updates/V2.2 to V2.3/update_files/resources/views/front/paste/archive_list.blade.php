@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!config('settings.meta_description')!!}">
<meta name="keywords" content="{!!config('settings.meta_keywords')!!}">
<meta name="author" content="{{config('settings.site_name')}}">

<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('content')
<main> 
  
  <!--Main layout-->
  <div class="container"> 
    <!--First row-->
    <div class="row " data-wow-delay="0.2s">
      <div class="@if(config('settings.site_layout') == 1) col-md-9 @else col-md-12 @endif">
        @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad1')) !!}</div>@endif 
        <div class="card">
          <div class="card-header"> {{ __('Archive')}} </div>
          <div class="row m-2"> @foreach($syntaxes as $syntax)
            <div class="col-md-4"><a class="" href="{{$syntax->url}}">{{$syntax->name}}</a></div>
            @endforeach </div>
        </div>
        @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>@endif 
      </div>
      @include('front.paste.recent_pastes') 

    </div>
    <!--/.First row--> 
    
  </div>
  <!--/.Main layout--> 
  
</main>
@stop 