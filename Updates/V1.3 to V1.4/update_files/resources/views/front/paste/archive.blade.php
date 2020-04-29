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
          <div class="card-header"> {{ __('Archive')}} - {{$syntax->name}} </div>
          <ul class="list-group list-group-flush">
            @forelse($pastes as $paste)
            <li class="list-group-item"> <i class="fa fa-paste small"></i> @if(!empty($paste->password))<i class="fa fa-lock small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item text-center">{{ __('No results')}}</li>
            @endforelse
          </ul>
          @if(Auth::check())<div class=" mx-auto mt-3"> {{$pastes->links()}} </div>@else  <div class="alert alert-warning" role="alert"> <i class="fa fa-info-circle"></i> {{ __('You are currently not logged in, this means you can only see limited pastes.')}} <a href="{{url('register')}}">{{ __('Sign Up')}}</a> or <a href="{{url('login')}}">{{ __('Login')}}</a> </div>  @endif
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