@yield('before_scripts')
<script>
var max_content_size_kb = {{ config('settings.max_content_size_kb') }};	
var paste_editor_height = {{ config('settings.paste_editor_height') }};
var ad_block_message = '{{ __("Ad Block Detected") }}';

@if(config('settings.ad_block_detection') == 1)
var isAdBlockActive = true;
@else
var isAdBlockActive = false;
@endif
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/mdb.min.js?v=2')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="{{url('js/ads.js')}}"></script>
<script src="{{url('js/app.min.js?v=1.5')}}"></script>
<script>
if(isAdBlockActive){
	$('main > div').html('<div class="row"><div class="card col-md-12 text-center text-danger h1 pt-5 pb-5">'+ad_block_message+'</div></div>');
}	
</script>
@yield('after_scripts')
{!! html_entity_decode(config('settings.analytics_code')) !!}
{!! html_entity_decode(config('settings.footer_code')) !!}