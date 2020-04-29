<!-- SCRIPTS -->
@yield('before_scripts') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<script type="text/javascript" src="{{url('js/popper.min.js')}}"></script> 
<script src="{{url('js/bootstrap.min.js')}}"></script> 
<script src="{{url('js/mdb.min.js')}}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script> 
<script src="{{url('js/admin.js')}}"></script> 
@yield('after_scripts') 
<script type="text/javascript">
new WOW().init();   
$(document).ready(function() {
    $('.select2').select2();

});

@if(count($errors) > 0)
    @foreach($errors->getMessages() as $key => $message)
        if($('[name="{{$key}}"]').length > 0){
          $('[name="{{$key}}"]').addClass('is-invalid');
          $('[name="{{$key}}"]').parent().append('<div class="invalid-feedback">{{$message[0]}}</div>');
        }
    @endforeach
@endif
</script>