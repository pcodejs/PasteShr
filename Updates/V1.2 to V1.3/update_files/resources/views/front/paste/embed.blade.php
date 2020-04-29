<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{csrf_token()}}" />
<title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
<link rel="shortcut icon" href="{{url('favicon.ico')}}" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{url('css/mdb.min.css')}}" rel="stylesheet">
<link href="{{url('css/style.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('plugins/prismjs/prism.css')}}">
</head>
<body>
<div class="card">
  <div class="card-header"> {{$paste->title_f}} - <span class="badge badge-light">{{strtoupper($paste->syntax)}}</span> <small class="text-muted">{{$paste->content_size}} KB</small>
    <div class="pull-right"> 
        @if(config('settings.feature_raw') == 1 && empty($paste->password))<a href="{{url('raw/'.$paste->slug)}}" class="badge badge-default">{{ __('raw')}}</a> @endif 
        @if(config('settings.feature_download') == 1 && empty($paste->password))<a href="{{url('download/'.$paste->slug)}}" class="badge badge-primary">{{ __('download')}}</a> @endif
    </div>
  </div>
  <div class="card-body p-2">
    @if(!empty($paste->password))
        <div class="row justify-content-center" id="unlock_form">
            <div class="form-group col-md-3  text-center">
                  <small class="text-muted">{{ __('To unlock this paste, please enter password.')}}</small>
                  <input type="password" class="form-control mb-1" id="password" placeholder="{{ __('Password')}}">
                  <small id="password_response" class="pt-1"></small>
            </div>                 
            <div class="form-group col-md-12 text-center"> 
                <button class="btn btn-sm btn-default m-0" type="button" id="passwordBtn">{{ __('Unlock')}}</button>
            </div>
        </div>
    @endif
    <pre class="line-numbers language-{{$paste->syntax}} @if(!empty($paste->password)) d-none @endif" id="pre">
        @if(empty($paste->password))
            <code class="language-{{$paste->syntax}}">
             {{$paste->content_f}}
            </code>
        @endif
    </pre>
    <p class="text-center p-0">{{ __('Paste Hosted With')}} <i class="fa fa-heart"></i> {{ __('By')}} <a href="{{url('/')}}" target="_blank">{{config('settings.site_name')}}</a></p>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<script src="{{url('js/bootstrap.min.js')}}"></script> 
<script src="{{url('js/mdb.min.js')}}"></script> 
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
</script>
@if(!empty($paste->password))
<script type="text/javascript">
$(document).ready(function($) {

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
          $("pre").removeClass('d-none');
          var code = document.createElement('code');
          code.className = 'language-{{$paste->syntax}}';
          var pre = document.getElementById("pre");
          pre.textContent = '';

          code.textContent = data.content;
          pre.appendChild(code);

          Prism.highlightElement(code);
 
          $("#unlock_form").remove();
      }
      else{
        $('#password').val('');
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
</body>
</html>