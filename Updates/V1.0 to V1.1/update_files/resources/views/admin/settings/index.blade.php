@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
<div class="container-fluid mt-5">

<!-- Heading -->
<div class="card mb-4 wow fadeIn"> 
  
  <!--Card content-->
  <div class="card-body d-sm-flex justify-content-between">
    <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <span>{{$page_title}}</span> </h4>
  </div>
</div>
<!-- Heading --> 

<!--Grid row-->
<div class="row wow fadeIn"> 
  
  <!--Grid column-->
  <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
    <!--Card-->
    <div class="card mb-4"> 
      
      <!-- Card header -->
      <div class="card-header"> {{$page_title}} </div>
      
      <!--Card content-->
      <div class="card-body">
        <form method="post">
          @csrf
          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> General Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Site Name*</label>
            <input type="text" class="form-control" name="site_name" placeholder="Userame" value="{{old('site_name',$settings['site_name'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Site Email*</label>
            <input type="email" class="form-control" name="site_email" placeholder="Email" value="{{old('site_email',$settings['site_email'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Default Site Locale</label>
            @php $selected = old('default_locale',$settings['default_locale']); @endphp
            <select class="form-control" name="default_locale">
                <option value="en">Select</option>
                @foreach($locales as $lang)
                <option value="{{$lang->code}}" @if($selected == $lang->code) selected @endif>{{$lang->name}}</option>
                @endforeach
            </select>
          </div>
          <div class="form-group col-md-6">
            <label>Default Timezone</label>
            <input type="text" class="form-control" name="default_timezone" placeholder="Asia/Kolkata" value="{{old('default_timezone',$settings['default_timezone'])}}">
          </div>
          <div class="form-group col-md-6">
            <label>Footer Text</label>
            <textarea class="form-control" name="footer_text">{{old('footer_text',$settings['footer_text'])}}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Registration Open</label>
            <br/>
            <label>
              <input type="radio" name="registration_open" value="1" @if($settings['registration_open'] == 1) checked @endif>
              Yes </label>
            <label>
              <input type="radio" name="registration_open" value="0" @if($settings['registration_open'] == 0) checked @endif>
              No </label>
          </div>

          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Paste Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Public Paste <small class="text-muted">anyone can paste without registration</small></label>
            <br/>
            <label>
              <input type="radio" name="public_paste" value="1" @if($settings['public_paste'] == 1) checked @endif>
              Yes </label>
            <label>
              <input type="radio" name="public_paste" value="0" @if($settings['public_paste'] == 0) checked @endif>
              No </label>             
          </div>

          <div class="form-group col-md-6">
            <label>Max Paste  Size in KB*</label>
            <input type="number" class="form-control" name="max_content_size_kb" placeholder="500" value="{{old('max_content_size_kb',$settings['max_content_size_kb'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Recent Pastes Limit*</label>
            <input type="number" class="form-control" name="recent_pastes_limit" placeholder="5" value="{{old('recent_pastes_limit',$settings['recent_pastes_limit'])}}" >
          </div>
          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> SEO Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Meta Description</label>
            <textarea class="form-control" name="meta_description">{{old('meta_description',$settings['meta_description'])}}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Meta Keywords</label>
            <textarea class="form-control" name="meta_keywords">{{old('meta_keywords',$settings['meta_keywords'])}}</textarea>
          </div>

          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Comments Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Disqus Comments(on/off)</label>
            <br/>
            <label>
              <input type="radio" name="disqus" value="1" @if($settings['disqus'] == 1) checked @endif>
              On </label>
            <label>
              <input type="radio" name="disqus" value="0" @if($settings['disqus'] == 0) checked @endif>
              Off </label>
          </div>
          <div class="form-group col-md-6">
            <label>Disqus Code</label>
            <textarea class="form-control" name="disqus_code">{!!old('disqus_code',html_entity_decode($settings['disqus_code']))!!}</textarea>
          </div>


          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Invisible Recaptcha Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Invisible Recaptcha(on/off)</label>
            <br/>
            <label>
              <input type="radio" name="captcha" value="1" @if($settings['captcha'] == 1) checked @endif>
              On </label>
            <label>
              <input type="radio" name="captcha" value="0" @if($settings['captcha'] == 0) checked @endif>
              Off </label>
            <p><small class="text-muted">How to get Invisible Recaptcha SiteKey & SecretKey? <a class="blue-text" data-toggle="modal" data-target="#sideModal" data-backdrop="false">click here</a></small></p>
          </div>
          <div class="form-group col-md-6">
            <label>Invisible Recaptcha SiteKey</label>
            <input type="text" class="form-control" name="captcha_site_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_site_key',$settings['captcha_site_key'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Invisible Recaptcha SecretKey</label>
            <input type="text" class="form-control" name="captcha_secret_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_secret_key',$settings['captcha_secret_key'])}}" >
          </div>
          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Advertisement Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Ad Blocks(on/off)</label>
            <br/>
            <label>
              <input type="radio" name="ad" value="1" @if($settings['ad'] == 1) checked @endif>
              On </label>
            <label>
              <input type="radio" name="ad" value="0" @if($settings['ad'] == 0) checked @endif>
              Off </label>
          </div>
          <div class="form-group col-md-6">
            <label>Ad Block 1</label>
            <textarea class="form-control" name="ad1">{{old('ad1',$settings['ad1'])}}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Ad Block 2</label>
            <textarea class="form-control" name="ad2">{{old('ad2',$settings['ad2'])}}</textarea>
          </div>
          <div class="form-group col-md-6">
            <label>Ad Block 3</label>
            <textarea class="form-control" name="ad3">{{old('ad3',$settings['ad3'])}}</textarea>
          </div>
          <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Social Links Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          <div class="form-group col-md-6">
            <label>Facebook*</label>
            <input type="text" class="form-control" name="social_fb" placeholder="http://facebook.com/username" value="{{old('social_fb',$settings['social_fb'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Twitter*</label>
            <input type="text" class="form-control" name="social_tw" placeholder="http://twitter.com/@username" value="{{old('social_tw',$settings['social_tw'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Google Plus*</label>
            <input type="text" class="form-control" name="social_gp" placeholder="http://plus.google.com/username" value="{{old('social_gp',$settings['social_gp'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>LinkedIn*</label>
            <input type="text" class="form-control" name="social_lin" placeholder="http://linkedin.com/username" value="{{old('social_lin',$settings['social_lin'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Pinterest*</label>
            <input type="text" class="form-control" name="social_pin" placeholder="http://pinterest.com/username" value="{{old('social_pin',$settings['social_pin'])}}" >
          </div>
          <div class="form-group col-md-6">
            <label>Instagram*</label>
            <input type="text" class="form-control" name="social_insta" placeholder="http://instagram.com/username" value="{{old('social_insta',$settings['social_insta'])}}" >
          </div>
          <div class="form-group col-md-6">
          <button class="btn btn-success" type="submit">Save</button>
        </form>
      </div>
      <!--/.Card--> 
      
    </div>
    <!--Grid column--> 
    
  </div>
  <!--Grid row--> 
  
</div>
</main>
<!--Main layout--> 

<!-- Side Modal Top Right-->
<div class="modal fade right" id="sideModal" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-side modal-top-right modal-notify modal-info" role="document"> 
    <!--Content-->
    <div class="modal-content"> 
      <!--Header-->
      <div class="modal-header">
        <p class="heading lead">Invisible Recaptcha</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" class="white-text">&times;</span> </button>
      </div>
      
      <!--Body-->
      <div class="modal-body">
        <div class="text-center">
          <p>1. Click on 'Get it now' button. </p>
          <p>2. Singup/Login & Click on My reCAPTCHA button. </p>
          <p>3. Enter Label Name, Select Invisible Recaptcha option & add your domain in domain list. </p>
          <img src="{{url('img/help1.jpg')}}" class="img-fluid">
          <p>4. Copy SiteKey & SecretKey. </p>
        </div>
      </div>
      
      <!--Footer-->
      <div class="modal-footer justify-content-center"> <a role="button" class="btn btn-info" href="https://www.google.com/recaptcha" target="_blank">Get it now <i class="fa fa-diamond ml-1"></i> </a> <a role="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">No,
        thanks</a> </div>
    </div>
    <!--/.Content--> 
  </div>
</div>
<!-- Side Modal Top Right Success--> 
@stop 