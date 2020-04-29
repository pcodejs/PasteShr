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
        @include('front.includes.messages')
        <div class="card">
          <div class="card-header"> {{ __('My Pastes')}} </div>
          <ul class="list-group list-group-flush">
            @forelse($pastes as $paste)
            <li class="list-group-item">
              <div class="pull-left"> <i class="fa fa-paste small"></i> <a href="{{$paste->url}}">{{$paste->title_f}}</a>
                <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | {{$paste->created_ago}}</small></p>
              </div>
              <div class="pull-right"> <a href="{{url('paste/'.$paste->slug.'/edit')}}" class="badge badge-info mr-2"><i class="fa fa-edit"></i> {{ __('Edit')}}</a> <a href="{{url('paste/'.$paste->slug.'/delete')}}" class="badge badge-danger"><i class="fa fa-trash"></i> {{ __('Delete')}}</a> </div>
            </li>
            @empty
            <li class="list-group-item">{{ __('No results')}}</li>
            @endforelse
          </ul>
          <div class=" mx-auto mt-3"> {{$pastes->links()}} </div>
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