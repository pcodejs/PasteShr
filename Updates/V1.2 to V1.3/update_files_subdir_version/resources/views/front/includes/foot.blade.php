@yield('before_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/mdb.min.js?v=1')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
@yield('after_scripts')
<script type="text/javascript">
new WOW().init();	
$(document).ready(function() {
    $('.select2').select2();
});
</script>
{!! html_entity_decode(config('settings.analytics_code')) !!}