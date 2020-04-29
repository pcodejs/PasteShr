@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!config('settings.meta_description')!!}">
<meta name="keywords" content="{!!config('settings.meta_keywords')!!}">
<meta name="author" content="{{config('settings.site_name')}}">

<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_scripts') 
<script type="text/javascript">
function loadFile(event, id){
    // alert(event.files[0]);
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById(id);
      output.src = reader.result;
       //$("#imagePreview").css("background-image", "url("+this.result+")");
    };
    reader.readAsDataURL(event.files[0]);
}    
</script> 
@stop

@section('content')
<main> 
  
  <!--Main layout-->
  <div class="container"> 
    <!--First row-->
    <div class="row " data-wow-delay="0.2s">
      <div class="col-md-8 mx-auto"> 
        
        <!-- Material form register -->
        <div class="card">
          <h5 class="card-header text-center"> <strong>{{ __('Profile')}}</strong> </h5>
          
          <!--Card content-->
          <div class="card-body  pt-0">
            <form class="p-3" method="post" enctype="multipart/form-data" action="">
              @include('front.includes.messages')
              
              @csrf
              <label>{{ __('Username')}}</label>
              <input type="text" id="defaultContactFormName" class="form-control mb-4" value="{{$user->name}}" disabled>
              <label>{{ __('E-Mail address')}}</label>
              <input type="email" id="defaultContactFormEmail" class="form-control mb-4" value="{{$user->email}}" disabled>
              <label>{{ __('Avatar')}}</label>
              <br/>
              <img src="{{$user->avatar}}" id="avatar" class="rounded-circle z-depth-1-half avatar-pic mb-4" height="80" width="80">
              <div class="input-group mb-4">
                <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span> </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01" onchange="loadFile(this,'avatar')" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file jpg-png Max 1MB')}}</label>
                </div>
              </div>
              <label>{{ __('About Me')}}</label>
              <textarea name="about" class="form-control mb-4">{{old('about',$user->about)}}</textarea>   

              <label>{{ __('Facebook Link')}}</label>
              <input type="text" name="fb" class="form-control mb-4" value="{{old('fb',$user->fb)}}">                
              <label>{{ __('Twitter Link')}}</label>
              <input type="text" name="tw" class="form-control mb-4" value="{{old('tw',$user->tw)}}">               
              <label>{{ __('Google Plus Link')}}</label>
              <input type="text" name="gp" class="form-control mb-4" value="{{old('gp',$user->gp)}}">              

              <label>{{ __('Password')}}</label>
              <input type="password" name="password" class="form-control mb-4">
              <label>{{ __('Confirm Password')}}</label>
              <input type="password" name="password_confirmation" class="form-control mb-4">
              
              <!-- Save button -->
              <button class="btn btn-blue-grey darken-5 btn-block" type="submit">{{ __('Save')}}</button>
              <a class="btn btn-danger btn-block mt-1"  data-toggle="modal" data-target="#modalDeleteAccount">{{ __('Delete Account')}}</a>
            </form>
            <!-- Default form contact --> 
            
          </div>
        </div>
        <!-- Material form register --> 
        
      </div>
    </div>
  </div>
</main>




<!-- Modal: form -->
<div class="modal fade" id="modalDeleteAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-danger" role="document"> 
    <!-- Content -->
    <div class="modal-content"> 
      
      <!-- Header -->
      <div class="modal-header red darken-3 white-text">
        <h4 class=""><i class="fas fa-pencil-alt"></i> {{ __('Delete Account')}} - {{$user->name}}</h4>
        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <!-- Body -->
      <div class="modal-body mb-0">
        <form method="post" action="{{route('profile.delete')}}">
          @csrf
          <div class="md-form form-sm"> <i class="fa fa-user prefix"></i>
            <input type="password" name="password" id="form99" class="form-control form-control-sm" required>
            <label for="form99">{{ __('Password')}}</label>
          </div>


          @if(config('settings.captcha_type') == 1) @captcha 
          @else
          <img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha">
              <a rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='{{url('captcha/'.config('settings.custom_captcha_style'))}}?'+Math.random()" class="refresh">
                                    
                <button type="button" class="btn btn-info btn-sm btn-refresh"><i class="fa fa-refresh"></i></button>

              </a> 
          <div class="md-form"> <i class="fa fa-shield prefix grey-text"></i>
            <input type="text" id="form6" name="g-recaptcha-response" class="form-control" required>
            <label for="form6"> {{ __('Security Check')}}</label>
          </div>
          @endif

          <div class="text-center mt-1-half">
            <button class="btn btn-danger mb-2" type="submit">{{ __('Confirm Delete Account')}} <i class="fa fa-paper-plane ml-1"></i></button>
          </div>
        </form>
      </div>
    </div>
    <!-- Content --> 
  </div>
</div>
<!-- Modal: form --> 
@stop