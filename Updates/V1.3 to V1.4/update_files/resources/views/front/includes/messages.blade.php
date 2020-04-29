@if(session('success'))
<div class="alert alert-success alert-dismissible">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  {!!session('success')!!}
</div>
@endif
@if(session('status') && !session('warning'))
<div class="alert alert-success alert-dismissible">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  {!!session('status')!!}
</div>
@endif
@if(session('info'))
<div class="alert alert-info alert-dismissible">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  {!!session('info')!!}
</div>
@endif
@if(session('warning'))
<div class="alert alert-warning alert-dismissible">
  <button type = "button" class="close" data-dismiss = "alert">x</button>
  {!!session('warning')!!}
</div>
@endif
@if (count($errors) == 1)
<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach ($errors->all() as $error)
       {{ $error }}
    @endforeach
</div>
@elseif(count($errors) > 1)
<div class="alert alert-danger alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif