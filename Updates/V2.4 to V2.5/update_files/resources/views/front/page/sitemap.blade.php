@php
echo '<?xml version="1.0" encoding="UTF-8"?>';
@endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>{{url('/')}}</loc>
    </url>
    @foreach($pages as $page)
    <url>
        <loc>{{route('page.show',[$page->slug])}}</loc>
    </url>
    @endforeach
    <url>
        <loc>{{url('archive')}}</loc>
    </url>    
    <url>
        <loc>{{url('trending')}}</loc>
    </url>        
    <url>
        <loc>{{url('contact')}}</loc>
    </url>    
    @foreach($syntaxes as $syntax)
    <url>
        <loc>{{$syntax->url}}</loc>
    </url> 
    @endforeach      
    @foreach($pastes as $paste)
    <url>
        <loc>{{$paste->url}}</loc>
    </url> 
    @endforeach       
</urlset>