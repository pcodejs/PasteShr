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
          <div class="card-body"> @include('front.includes.messages')
            <form method="post" action="{{route('paste.store')}}">
              @csrf
              <div class="form-group">
                <label class="font-weight-bold">{{ __('New Paste')}}</label>
                <textarea name="content" class="form-control" rows="15" autofocus>{{old('content',$paste->content_f)}}</textarea>
              </div>
              <h5>{{ __('Paste Settings')}}</h5>
              <hr class="extra-margin" />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Syntax Highlighting')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('syntax',$paste->syntax); @endphp
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
                      <option value="N" @if($selected == 'N') selected @endif>{{ __('Never')}}</option>
                      <option value="SD" @if($selected == 'SD') selected @endif>{{ __('Self Destroy')}}</option>
                      <option value="10M" @if($selected == '10M') selected @endif>{{ __('10 Minutes')}}</option>
                      <option value="1H" @if($selected == '1H') selected @endif>{{ __('1 Hour')}}</option>
                      <option value="1D" @if($selected == '1D') selected @endif>{{ __('1 Day')}}</option>
                      <option value="1W" @if($selected == '1W') selected @endif>{{ __('1 Week')}}</option>
                      <option value="2W" @if($selected == '2W') selected @endif>{{ __('2 Weeks')}}</option>
                      <option value="1M" @if($selected == '1M') selected @endif>{{ __('1 Month')}}</option>
                      <option value="6M" @if($selected == '6M') selected @endif>{{ __('6 Months')}}</option>
                      <option value="1Y" @if($selected == '1Y') selected @endif>{{ __('1 Year')}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Paste Status')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('status'); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}</option>
                      <option value="2" @if($selected == 2) selected @endif>{{ __('Unlisted')}}</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      Private (members only)
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Paste Title')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="{{ __('Paste Title')}}" value="{{old('title',$paste->title)}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Password')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('Password')}}">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="encrypted">
                        <label class="custom-control-label" for="defaultUnchecked">{{ __('Encrypt Paste')}}</label>
                    </div>
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
            <div class="alert alert-warning" role="alert"> <i class="fa fa-info-circle"></i> {{ __('You are currently not logged in')}}, {{ __('this means you can not edit or delete anything you paste')}}. <a href="{{url('register')}}">{{ __('Sign Up')}}</a> or <a href="{{url('login')}}">{{ __('Login')}}</a> </div>
            @endif </div>
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