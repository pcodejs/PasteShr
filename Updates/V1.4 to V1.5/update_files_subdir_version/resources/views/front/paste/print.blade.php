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
<link href="{{url('css/style.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('plugins/prismjs/prism.css')}}">
</head>
<body onload="window.print();">
<div class="card">
  <div class="card-header"> {{$paste->title_f}} - <span class="badge badge-light">{{strtoupper($paste->syntax)}}</span> <small class="text-muted">{{$paste->content_size}} KB</small> </div>
  <div class="card-body" style="padding: 2px;">
    <pre class="line-numbers language-{{$paste->syntax}}">
                                <code class="language-{{$paste->syntax}}">
                                    {{$paste->content_f}}
                                </code>
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
</body>
</html>