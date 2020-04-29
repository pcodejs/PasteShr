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
          <div class="card-header h4 text-center">{{ __('Reset Password') }}</div>
          <div class="card-body"> @include('front.includes.messages')
            <form method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" tabindex="1" required autofocus>
                  @if ($errors->has('email')) <span class="invalid-feedback" role="alert"> <strong>{{ $errors->first('email') }}</strong> </span> @endif </div>
              </div>
              @if(config('settings.captcha') == 1) 
              @if(config('settings.captcha_type') == 1) @captcha 
              @else
              <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="g-recaptcha-response" tabindex="2">{{ __('Security Check')}} </label>
                <div class="col-md-6"> <img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha"> <a rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='{{url('captcha/'.config('settings.custom_captcha_style'))}}?'+Math.random()" class="refresh">
                  <button type="button" class="btn btn-info btn-sm btn-refresh"><i class="fa fa-refresh"></i></button>
                  </a>
                  <input type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}" tabindex="3" required>
                </div>
              </div>
              @endif
              @endif
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-blue-grey" tabindex="4"> {{ __('Send Password Reset Link') }} </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection 