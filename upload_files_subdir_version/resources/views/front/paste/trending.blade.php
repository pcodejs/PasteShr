@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!config('settings.meta_description')!!}">
<meta name="keywords" content="{!!config('settings.meta_keywords')!!}">
<meta name="author" content="{{config('settings.site_name')}}">

<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::url()}}" />
@if(!empty(config('settings.site_image')))
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
@endif
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
        @include('front.includes.messages')

<div class="card p-1">

<ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="today-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today"
      aria-selected="true">{{ __('Today')}}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week"
      aria-selected="false">{{ __('This Week')}}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab" aria-controls="month"
      aria-selected="false">{{ __('This Month')}}</a>
  </li>  
  <li class="nav-item">
    <a class="nav-link" id="year-tab" data-toggle="tab" href="#year" role="tab" aria-controls="year"
      aria-selected="false">{{ __('This Year')}}</a>
  </li>
</ul>
<hr/>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="today-tab">
          <ul class="list-group list-group-flush">
            @forelse($trending_today as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item">{{ __('No results')}}</li>
            @endforelse
          </ul>
  </div>
  <div class="tab-pane fade show" id="week" role="tabpanel" aria-labelledby="week-tab">
          <ul class="list-group list-group-flush">
            @forelse($trending_week as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item">{{ __('No results')}}</li>
            @endforelse
          </ul>
  </div>
  <div class="tab-pane fade show" id="month" role="tabpanel" aria-labelledby="month-tab">
          <ul class="list-group list-group-flush">
            @forelse($trending_month as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item">{{ __('No results')}}</li>
            @endforelse
          </ul>
  </div>
  <div class="tab-pane fade show" id="year" role="tabpanel" aria-labelledby="year-tab">
          <ul class="list-group list-group-flush">
            @forelse($trending_year as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item">{{ __('No results')}}</li>
            @endforelse
          </ul>
  </div>


</div>
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