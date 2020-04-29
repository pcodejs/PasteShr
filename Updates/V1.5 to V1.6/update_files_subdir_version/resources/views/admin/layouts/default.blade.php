<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('admin.includes.head')
<body>
@include('admin.includes.header')

@yield('content')

@include('admin.includes.footer')
     
@include('admin.includes.foot')
</body>
</html>