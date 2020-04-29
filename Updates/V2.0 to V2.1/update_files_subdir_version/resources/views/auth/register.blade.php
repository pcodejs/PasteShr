@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
@stop

@section('content')
<main>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header h4 text-center">{{ __('Register') }}</div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Username') }}" required autofocus>
                  @if ($errors->has('name')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('name') }}</strong> </span> @endif </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required>
                  @if ($errors->has('email')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('email') }}</strong> </span> @endif </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>
                  @if ($errors->has('password')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('password') }}</strong> </span> @endif </div>
              </div>
              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                <div class="col-md-6">
                  <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}" class="form-control" name="password_confirmation" required>
                </div>
              </div>
              @if(config('settings.captcha') == 1) 
              @if(config('settings.captcha_type') == 1) @captcha 
              @else
              <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="g-recaptcha-response">{{ __('Security Check')}} : </label>
                <div class="col-md-6"> {{captcha_img(config('settings.custom_captcha_style'))}}
                  <input type="text" name="g-recaptcha-response" id="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}">
                </div>
              </div>
              @endif
              @endif
              <div class="form-group row">
                <div class="col-md-6 offset-md-4 text-muted"><small>By Clicking Register button you agree with our <a href="{{url('terms')}}">Terms</a>.</small></div>
              </div>
              @include('front.includes.messages')
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-blue-grey"> {{ __('Register') }} </button>
                </div>
              </div>

    <hr>

    @if (config('settings.social_login_facebook') == 1)
        <a href="{{ route('social.login', ['provider '=> 'facebook', 'action' => 'register']) }}"
           class="btn btn-primary btn-block mb-1">
           <i class="fa fa-facebook"></i>  {{ __('Register with Facebook') }}
        </a>
    @endif

    @if (config('settings.social_login_twitter') == 1)
        <a href="{{ route('social.login', ['twitter', 'action' => 'register']) }}" class="btn btn-cyan btn-block mb-1">
           <i class="fa fa-twitter"></i>  {{ __('Register with Twitter') }}
        </a>
    @endif

    @if (config('settings.social_login_google') == 1)
        <a href="{{ route('social.login', ['google', 'action' => 'register']) }}" class="btn btn-danger btn-block mb-1">
           <i class="fa fa-google-plus"></i>  {{ __('Register with Google') }}
        </a>
    @endif


            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection 