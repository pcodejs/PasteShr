@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!$page->description!!}">
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
<div class="card">

	<div class="card-body">
    <!--First row-->
    <div class="row wow fadeIn" data-wow-delay="0.2s">
      <div class="col-md-12">
        <h1>{{$page->title}}</h1>
        {!!$page->content_f!!} 
    	</div>
    </div>
</div>
</div>

  </div>
</main>
@stop 