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
    <div class="row " data-wow-delay="0.2s">
      <div class="col-md-9">
        @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad1')) !!}</div>@endif 
        <div class="card">
          <div class="card-header"> {{ __('Search Results')}} - {{app('request')->get('keyword')}} </div>
          <ul class="list-group list-group-flush">
            @forelse($pastes as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) <a href="{{$paste->language->url}}">{{$paste->language->name}}</a> @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item text-center">{{ __('No results')}}</li>
            @endforelse
          </ul>
          @if(Auth::check())<div class=" mx-auto mt-3"> {{$pastes->appends(['keyword'=>app('request')->get('keyword')])->links()}} </div>@else  <div class="alert alert-warning" role="alert"> <i class="fa fa-info-circle"></i> {{ __('You are currently not logged in')}}, {{ __('this means you can only see limited pastes')}}. <a href="{{url('register')}}">{{ __('Sign Up')}}</a> or <a href="{{url('login')}}">{{ __('Login')}}</a> </div>  @endif
        </div>
        @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>@endif 
      </div>
      <div class="col-md-3"> @include('front.paste.recent_pastes') @if(config('settings.ad') == 1 && !empty(config('settings.ad3')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad3')) !!}</div>@endif </div>
    </div>
    <!--/.First row--> 
    
  </div>
  <!--/.Main layout--> 
  
</main>
@stop 