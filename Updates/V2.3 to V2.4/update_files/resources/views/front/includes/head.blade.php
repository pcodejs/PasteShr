<head>
<meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1.0, user-scalable=yes">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{csrf_token()}}">
@yield('meta')
<title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
<link rel="shortcut icon" href="{{url(config('settings.site_favicon'))}}" />
@yield('before_styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{url('css/mdb.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<link href="{{url('css/skins/'.config('settings.site_skin').'.min.css')}}" rel="stylesheet">
<link href="{{url('css/app.min.css?v=1.1')}}" rel="stylesheet">
<style type="text/css">	
@if(!empty(config('settings.background_image')))
html {
  /* The image used */
  background: url("{{ url(config('settings.background_image')) }}")  no-repeat center center fixed !important;
  -webkit-background-size: cover !important;
  -moz-background-size: cover !important;
  -o-background-size: cover !important;
  background-size: cover !important;
}
@endif
@if(config('settings.paste_break_word') ==  1)
code{ white-space: pre-wrap !important;     word-wrap: break-word !important; }
@endif
</style>
@if(config('settings.navbar') == 'fixed')
<style type="text/css">
main{
	margin-top: 50px;
}	
</style>
@endif
@yield('after_styles')

{!! html_entity_decode(config('settings.header_code')) !!}
</head>
