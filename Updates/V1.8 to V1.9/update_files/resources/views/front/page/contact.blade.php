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
      <div class="col-md-8 mx-auto"> 
        
        <!--Card-->
        <div class="card"> 
          
          <!--Card content-->
          <div class="card-body"> 
            
            <!-- Form -->
            <form method="post" action="{{route('contact')}}">
              @csrf 
              <!-- Heading -->
              <h3 class="dark-grey-text text-center"> <strong>{{ __('Write to us')}}:</strong> </h3>
              <hr>
              <div class="md-form"> <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="form3" name="name" class="form-control" value="{{old('name')}}">
                <label for="form3">{{ __('Your name')}}</label>
              </div>
              <div class="md-form"> <i class="fa fa-envelope prefix grey-text"></i>
                <input type="text" id="form2" name="email" class="form-control" value="{{old('email')}}">
                <label for="form2">{{ __('Your email')}}</label>
              </div>
              <div class="md-form"> <i class="fa fa-pencil prefix grey-text"></i>
                <textarea type="text" id="form8" name="message" class="md-textarea">{{old('message')}}</textarea>
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
              
              @include('front.includes.messages')
              <div class="text-center">
                <button class="btn btn-blue-grey" type="submit">{{ __('Send') }}</button>
                @if(config('settings.captcha') == 1) @captcha @endif </div>
            </form>
            <!-- Form --> 
            
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
    </div>
  </div>
</main>
@stop