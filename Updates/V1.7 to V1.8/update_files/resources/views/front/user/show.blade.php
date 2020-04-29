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

@section('after_styles')
<style type="text/css">
.profile-card{margin-top:70px}.profile-card .avatar{max-width:150px;max-height:150px;margin-top:-70px;margin-left:auto;margin-right:auto;-webkit-border-radius:50%;border-radius:50%;overflow:hidden}.profile-card p{font-weight:300}.user-card{margin-top:100px}.user-card .admin-up .data span{font-size:15px}  
</style>
@stop


@section('content')
<main> 
  
  <!--Main layout-->
  <div class="container"> 
    <!--First row-->
    <div class="row">
      <div class="col-md-3"> 
        
        <!-- Section: Basic Info -->
        <section class="card profile-card mb-4 text-center">
          <div class="avatar z-depth-1-half"> <img src="{{$user->avatar}}" alt="{{$user->name}}" class="img-fluid" style="width: 120px;"> </div>
          <!-- Card content -->
          <div class="card-body"> 
            <!-- Title -->
            <h4 class="card-title"><strong>{{$user->name}}</strong></h4>
            <h5>{{ __('Registered Member')}}</h5>
            <p class="dark-grey-text">{{ __('Joined')}} {{$user->created_ago}}</p>
            @if($user->status == 1)
            <p class="green-text font-weight-bold">{{ __('Active')}}</p>
            @elseif($user->status == 0)
            <p class="blue-text font-weight-bold">{{ __('Pending')}}</p>
            @else
            <p class="red-text font-weight-bold">{{ __('Banned')}}</p>
            @endif 
            <!-- Social --> 
            <a href="{{$user->fb}}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-facebook-f white-text"></i></a> <a href="{{$user->tw}}" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-twitter white-text"></i></a> <a href="{{$user->gp}}" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-google-plus white-text"></i></a> 
            
            <!-- Text -->
            <p class="card-text mt-3">{{$user->about}}</p>
            <button type="button" class="btn btn-info btn-rounded btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modalContactForm">Contact<i class="fa fa-paper-plane ml-2"></i></button>
          </div>
        </section>
        <!-- Section: Basic Info --> 
        
      </div>
      <div class="col-md-9"> @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
        <div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad1')) !!}</div>
        @endif 
        @include('front.includes.messages')
        <div class="card">
          <div class="card-header">{{ __('Recent Pastes')}}</div>
          <ul class="list-group list-group-flush">
            @forelse($pastes as $paste)
            <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$paste->url}}">{{$paste->title_f}}</a>
              <p><small class="text-muted">@if(isset($paste->language)) <a href="{{$paste->language->url}}">{{$paste->language->name}}</a> @else{{$paste->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}</small></p>
            </li>
            @empty
            <li class="list-group-item text-center">{{ __('No results')}}</li>
            @endforelse
          </ul>
        </div>
        @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
        <div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>
        @endif </div>
    </div>
  </div>
  <!--/.First row-->
  
  </div>
  <!--/.Main layout--> 
  
</main>

<!-- Modal: Contact form -->
<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document"> 
    <!-- Content -->
    <div class="modal-content"> 
      
      <!-- Header -->
      <div class="modal-header light-blue darken-3 white-text">
        <h4 class=""><i class="fas fa-pencil-alt"></i> {{ __('Contact')}} {{$user->name}}</h4>
        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <!-- Body -->
      <div class="modal-body mb-0">
        <form method="post" action="{{route('user.contact',['name'=>$user->name])}}">
          @csrf
          <div class="md-form form-sm"> <i class="fa fa-user prefix"></i>
            <input type="text" name="name" id="form19" class="form-control form-control-sm" required>
            <label for="form19">{{ __('Your name')}}</label>
          </div>
          <div class="md-form form-sm"> <i class="fa fa-envelope prefix"></i>
            <input type="email" name="email" id="form20" class="form-control form-control-sm" required>
            <label for="form20">{{ __('Your email')}}</label>
          </div>
          <div class="md-form form-sm"> <i class="fa fa-pencil prefix"></i>
            <textarea type="text" name="message" id="form8" class="md-textarea form-control form-control-sm" minlength="10" maxlength="255" rows="3" required></textarea>
            <label for="form8">{{ __('Your message')}}</label>
          </div>
          @if(config('settings.captcha') == 1) 
          @if(config('settings.captcha_type') == 1) @captcha 
          @else
          {{captcha_img(config('settings.custom_captcha_style'))}}
          <div class="md-form"> <i class="fa fa-shield prefix grey-text"></i>
            <input type="text" id="form6" name="g-recaptcha-response" class="form-control">
            <label for="form6"> {{ __('Security Check')}}</label>
          </div>
          @endif
          @endif
          <div class="text-center mt-1-half">
            <button class="btn btn-info mb-2" type="submit">Send <i class="fa fa-paper-plane ml-1"></i></button>
            @if(config('settings.captcha') == 1) @captcha @endif </div>
        </form>
      </div>
    </div>
    <!-- Content --> 
  </div>
</div>
<!-- Modal: Contact form --> 
@stop 