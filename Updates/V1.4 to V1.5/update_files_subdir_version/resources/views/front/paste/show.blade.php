@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{$paste->description}}">
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
<link rel="stylesheet" type="text/css" href="{{url('plugins/prismjs/prism-'.config('settings.syntax_highlighting_style').'.css')}}">
@stop

@section('after_scripts') 
<script src="{{url('plugins/prismjs/prism.js')}}"></script> 
<script type="text/javascript">
(function(){

if (
    typeof self !== 'undefined' && !self.Prism ||
    typeof global !== 'undefined' && !global.Prism
) {
    return;
}

Prism.hooks.add('before-highlight', function(env) {
    var tokens = env.grammar;

    if (!tokens) return;

    tokens.tab = '';
    tokens.crlf = '';
    tokens.lf = '';
    tokens.cr = '';
    tokens.space = '';
});
})();   

function CopyToClipboard(text) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
    $('#embed_response').html('Copied!');
}
</script>

@if(!empty($paste->password))
<script type="text/javascript">
$(document).ready(function($) {
  
  $('#passwordModal').modal('toggle');

  $('#passwordBtn').on('click', function(event) {
    event.preventDefault();
    $("#passwordBtn").prop('disabled','disabled');
    $("#password_response").html(' ');
    $.ajax({
      url: '{{route("paste.get")}}',
      type: 'POST',
      data: {slug: '{{$paste->slug}}',password: $('#password').val(), _token: '{{ csrf_token() }}'},
    })
    .done(function(data) {
      if(data.status == 'success')
      { 
          var code = document.createElement('code');
          code.className = 'language-{{$paste->syntax}}';
          var pre = document.getElementById("pre");
          pre.textContent = '';

          code.textContent = data.content;
          pre.appendChild(code);

          Prism.highlightElement(code);

          $("#raw_content").val(data.content); 
          $("#passwordModal").modal('toggle');
          $("#unlock_link").remove();
      }
      else{
        $("#password_response").html(data.message);
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
      $("#passwordBtn").removeAttr('disabled');
    });
    

  });

});
</script> 
@endif
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
            <div class="media"> @if(isset($paste->user)) <img class="mr-3 mb-3 rounded-circle img-fluid" src="{{$paste->user->avatar}}" alt="avatar" style="height: 60px"> @else <img class="mr-3 mb-3 rounded-circle img-fluid" src="{{url('img/default-avatar.png')}}" alt="avatar" style="height: 60px"> @endif
              <div class="media-body">
                <h5 class="mt-0"><i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif {{$paste->title_f}}</h5>
                <p class="text-muted small"> <i class="fa fa-user"></i> @if(isset($paste->user)) {{$paste->user->name}} @else Guest @endif <i class="fa fa-eye ml-2"></i> {{$paste->views_f}} <i class="fa fa-calendar ml-2"> {{$paste->created_at->format('jS M, Y')}}</i>  
                  @if($paste->status == 2) <span class="badge badge-warning">{{ __('Unlisted')}}</span> @elseif($paste->status == 3) <span class="badge badge-danger">{{ __('Private')}}</span> @endif</p>
              </div>
              @if(Auth::check())
                  @if($paste->user_id == Auth::user()->id) <a href="{{url('paste/'.$paste->slug.'/edit')}}" class="badge badge-info mr-2"><i class="fa fa-edit"></i> {{ __('Edit')}}</a> <a href="{{url('paste/'.$paste->slug.'/delete')}}" class="badge badge-danger"><i class="fa fa-trash"></i> {{ __('Delete')}}</a> 
                  @else
                    @if(Auth::user()->role == 1)
                      <a href="{{url('admin/pastes/'.$paste->id.'/edit')}}" class="badge badge-info mr-2"><i class="fa fa-edit"></i> {{ __('Edit')}}</a> <a href="{{url('admin/pastes/'.$paste->id.'/delete')}}" class="badge badge-danger"><i class="fa fa-trash"></i> {{ __('Delete')}}</a>
                    @endif
                  @endif  
              @endif
            </div>
           @if(Auth::check()) @if($paste->user_id == Auth::user()->id)
            <p class="text-muted text-center"><small>{{ __('This is one of your paste')}}</small></p>
            @endif @endif
           @if(!empty($paste->password))<div class="text-center" id="unlock_link"><a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#passwordModal">{{ __('Unlock')}}</a></div>@endif
            <div class="card">
              <div class="card-header"> <span class="badge badge-light">{{strtoupper($paste->syntax)}}</span> <small class="text-muted">{{$paste->content_size}} KB</small>
                <div class="pull-right">  
                    @if(config('settings.feature_share') == 1)<a class="badge badge-warning" data-toggle="modal" data-target="#shareModal">{{ __('share')}}</a> @endif
                    @if(config('settings.feature_raw') == 1 && empty($paste->password))<a href="{{url('raw/'.$paste->slug)}}" class="badge badge-default">{{ __('raw')}}</a> @endif 
                    @if(config('settings.feature_download') == 1 && empty($paste->password))<a href="{{url('download/'.$paste->slug)}}" class="badge badge-primary">{{ __('download')}}</a> @endif
                    @if(config('settings.feature_clone') == 1 && empty($paste->password))<a href="{{url('clone/'.$paste->slug)}}" class="badge badge-secondary">{{ __('clone')}}</a> @endif
                    @if(config('settings.feature_embed') == 1)<a class="badge badge-success" data-toggle="modal" data-target="#embedModal">{{ __('embed')}}</a> @endif
                    @if(config('settings.feature_report') == 1)<a class="badge badge-danger" @if(\Auth::check()) data-toggle="modal" data-target="#reportModal" @else href="{{url('login')}}" @endif>{{ __('report')}}</a> @endif
                    @if(config('settings.feature_print') == 1 && empty($paste->password))<a href="{{url('print/'.$paste->slug)}}" class="badge badge-info">print</a> @endif
                </div>
              </div>
              <div class="card-body">
                <pre class="line-numbers language-{{$paste->syntax}}" id="pre">
                     @if(empty($paste->password))
                      <code class="language-{{$paste->syntax}}" id="paste_content">
                         {{$paste->content_f}}
                      </code>
                      @endif
                 </pre>
              </div>
            </div>

         @if(config('settings.feature_copy') == 1)  
          <div class="form-group mt-3 mb-3">
              <small class="text-muted">{{ __('To share this paste please copy this url and send to your friends')}}</small>

                <div class="input-group">
                  <div class="input-group-prepend">
                    <button class="btn btn-md btn-blue-grey m-0 px-3" type="button" onclick="CopyToClipboard('{{$paste->url}}')">{{ __('Copy')}}</button>
                  </div>
                  <input type="text" class="form-control" value="{{$paste->url}}" disabled>
                </div>
          </div>
          @endif

            <div class="card mt-3">
              <div class="card-header"> {{ __('RAW Paste Data')}} </div>
              <div class="card-body">
                <textarea class="form-control" rows="10" id="raw_content">@if(empty($paste->password)){{$paste->content_f}}@endif</textarea>
              </div>
            </div>
          </div>
        </div>
        @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>@endif 

        @if(config('settings.disqus') == 1){!!html_entity_decode(config('settings.disqus_code'))!!}@endif

      </div>
      <div class="col-md-3"> @include('front.paste.recent_pastes') @if(config('settings.ad') == 1 && !empty(config('settings.ad3')))<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad3')) !!}</div>@endif </div>
    </div>
    <!--/.First row--> 
    
  </div>
  <!--/.Main layout--> 
  
</main>

<!-- The Modal -->
<div class="modal" id="embedModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('Embed Code')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <textarea class="form-control" id="embed_code"><iframe src="{{url('embed/'.$paste->slug)}}" style="border:none;width:100%;min-height:400px;"></iframe>
</textarea>
        <span id="embed_response" class="text-success"></span> </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success btn-sm" onclick="CopyToClipboard(document.getElementById('embed_code').value);">{{ __('Copy')}}</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="reportModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('Report Issue')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" action="{{route('paste.report')}}">
        <!-- Modal body -->
        <div class="modal-body"> @csrf
          <input type="hidden" name="id" value="{{$paste->id}}">
          <label>{{ __('Reason')}}</label>
          <textarea class="form-control" name="reason" placeholder="Write your reason.."></textarea>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning btn-sm">{{ __('Report')}}</button>
          <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(config('settings.feature_share') == 1)  
<!-- The Modal -->
<div class="modal" id="shareModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('Share')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

        <!-- Modal body -->
        <div class="modal-body text-center"> 

<a href="#" onclick="MyWindow=window.open('https://www.facebook.com/dialog/share?app_id=1932129293685911&amp;display=popup&amp;href={{$paste->url}}','Facebook share','width=600,height=300'); return false;" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-facebook"></i></a> <a href="#" onclick="MyWindow=window.open('https://twitter.com/share?url={{$paste->url}}','Twitt this','width=600,height=300'); return false;" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-twitter"></i></a> <a href="#" onclick="MyWindow=window.open('https://plus.google.com/share?url={{$paste->url}}','Google Plus share','width=600,height=300'); return false;" class="btn btn-pink btn-sm waves-effect waves-light"><i class="fa fa-google-plus"></i></a> 

@if(config('settings.feature_copy') == 1)  
<div class="form-group mt-3 mb-3">
    <small class="text-muted">{{ __('To share this paste, please copy this url and send to your friends.')}}</small>

      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-md btn-blue-grey m-0 px-3" type="button" onclick="CopyToClipboard('{{$paste->url}}')">{{ __('Copy')}}</button>
        </div>
        <input type="text" class="form-control" value="{{$paste->url}}" disabled>
      </div>
</div>
@endif

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
        </div>
    </div>
  </div>
</div>
@endif


@if(!empty($paste->password))
<!-- The Modal -->
<div class="modal" id="passwordModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('Password')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

        <!-- Modal body -->
        <div class="modal-body text-center"> 
          <div class="form-group">
              <small class="text-muted">{{ __('To unlock this paste, please enter password')}}</small>
              <input type="password" class="form-control" id="password" placeholder="{{ __('Password')}}">
          </div>
          <div id="password_response"></div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
           <button class="btn btn-sm btn-default" type="button" id="passwordBtn">{{ __('Unlock')}}</button>
          <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
        </div>
    </div>
  </div>
</div>
@endif


@stop 