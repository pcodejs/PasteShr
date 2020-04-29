<head>
<meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1.0, user-scalable=yes">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{csrf_token()}}">
@yield('meta')
<title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
<link rel="shortcut icon" href="{{config('settings.site_favicon')}}" />
@yield('before_styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{url('css/mdb.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<link href="{{url('css/style.css')}}" rel="stylesheet">
@yield('after_styles')
</head>