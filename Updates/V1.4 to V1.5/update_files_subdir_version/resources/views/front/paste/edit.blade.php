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
            <form method="post" action="">
              @csrf
              <div class="form-group">
                <label class="font-weight-bold">{{ __('Edit Paste')}}</label>
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
                    <label>{{ __('Paste Title')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="{{ __('Paste Title')}}" value="{{old('title',$paste->title)}}">
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Paste Status')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('status',$paste->status); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}</option>
                      <option value="2" @if($selected == 2) selected @endif>{{ __('Unlisted')}}</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      Private (members only)
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Password')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('Password')}}">
                  </div>

                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="encrypted" @if($paste->encrypted == 1) checked @endif>
                        <label class="custom-control-label" for="defaultUnchecked">{{ __('Encrypt Paste')}}</label>
                    </div>
                  </div>
                </div>                
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('Update Paste')}}</button>
                    <a href="{{$paste->url}}" class="btn btn-default">{{ __('Cancel')}}</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
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