@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
@stop

@section('content')
<main> 
  
  <!--Main layout-->
  <div class="container"> 
    <!--First row-->
    <div class="row wow fadeIn" data-wow-delay="0.2s">
      <div class="col-md-9">
        <div class="col-md-12 m-2 text-center"> @if(config('settings.ad') == 1){!!config('settings.ad1')!!}@endif </div>
        <div class="card">
          <div class="card-body"> @include('front.includes.messages')
            <form method="post" action="{{route('paste.store')}}">
              @csrf
              <div class="form-group">
                <label class="font-weight-bold">{{ __('New Paste')}}</label>
                <textarea name="content" class="form-control" rows="10" autofocus>{{old('content')}}</textarea>
              </div>
              <h5>{{ __('Paste Settings')}}</h5>
              <hr class="extra-margin" />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group pb-2">
                    <label>{{ __('Syntax Highlighting')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('syntax'); @endphp
                    <select class="form-control select2" name="syntax">
                      <option value="markup">Select</option>
                      <optgroup label="{{ __('Popular Languages')}}">
                                                        @foreach($popular_syntaxes as $syntax)
                                                        
                      <option value="{{$syntax->slug}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                      
                                                        @endforeach
                                                    </optgroup>
                      <optgroup label="{{ __('All Languages')}}">
                                                        @foreach($syntaxes as $syntax)
                                                        
                      <option value="{{$syntax->slug}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                      
                                                        @endforeach
                                                    </optgroup>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Paste Expiration')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('expire'); @endphp
                    <select class="form-control" name="expire">
                      <option value="N" @if($selected == 'N') selected @endif>Never</option>
                      <option value="10M" @if($selected == '10M') selected @endif>10 Minutes</option>
                      <option value="1H" @if($selected == '1H') selected @endif>1 Hour</option>
                      <option value="1D" @if($selected == '1D') selected @endif>1 Day</option>
                      <option value="1W" @if($selected == '1W') selected @endif>1 Week</option>
                      <option value="2W" @if($selected == '2W') selected @endif>2 Weeks</option>
                      <option value="1M" @if($selected == '1M') selected @endif>1 Month</option>
                      <option value="6M" @if($selected == '6M') selected @endif>6 Months</option>
                      <option value="1Y" @if($selected == '1Y') selected @endif>1 Year</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Paste Status')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('status'); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>Public</option>
                      <option value="2" @if($selected == 2) selected @endif>Unlisted</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      Private (members only)
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Paste Title')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="{{ __('Paste Title')}}" value="{{old('title')}}">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('Create New Paste')}}</button>
                    @if(config('settings.captcha') == 1) @captcha @endif
                  </div>
                </div>
              </div>
            </form>
            @if(!Auth::check())
            <div class="alert alert-warning" role="alert"> <i class="fa fa-info-circle"></i> {{ __('You are currently not logged in, this means you can not edit or delete anything you paste.')}} <a href="{{url('register')}}">{{ __('Sign Up')}}</a> or <a href="{{url('login')}}">{{ __('Login')}}</a> </div>
            @endif </div>
        </div>
        <div class="col-md-12 m-2 text-center"> @if(config('settings.ad') == 1){!!config('settings.ad2')!!}@endif </div>
      </div>
      <div class="col-md-3"> @include('front.paste.recent_pastes')  <div class="col-md-12 mt-2 mb-2 text-center"> @if(config('settings.ad') == 1){!!config('settings.ad3')!!}@endif </div></div>
    </div>
    <!--/.First row--> 
    
  </div>
  <!--/.Main layout--> 
  
</main>
@stop 