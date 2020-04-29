@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <span>{{$page_title}}</span> </h4>
        <a href="https://ecodevs.in/contact" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-envelope"></i> Contact Developer</a> </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row">
      <div class="col-md-12">@include('front.includes.messages')</div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> General Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="type" value="general">
              <div class="form-group">
                <label>Site Name*</label>
                <input type="text" class="form-control" name="site_name" placeholder="Userame" value="{{old('site_name',$settings['site_name'])}}" >
              </div>
              <div class="form-group">
                <label>Site Email*</label>
                <input type="email" class="form-control" name="site_email" placeholder="Email" value="{{old('site_email',$settings['site_email'])}}" >
              </div>
              <div class="form-group">
                <label>Default Site Locale</label>
                @php $selected = old('default_locale',$settings['default_locale']); @endphp
                <select class="form-control" name="default_locale">
                  <option value="en">Select</option>
                  
                @foreach($locales as $lang)
                
                  <option value="{{$lang->code}}" @if($selected == $lang->code) selected @endif>{{$lang->name}}</option>
                  
                @endforeach
            
                </select>
              </div>
              <div class="form-group">
                <label>Default Timezone</label>
                <input type="text" class="form-control" name="default_timezone" placeholder="Asia/Kolkata" value="{{old('default_timezone',$settings['default_timezone'])}}">
                <small>To find your timezone <a href="http://php.net/manual/en/timezones.php" target="_blank">click here</a>.</small> </div>
              <div class="form-group">
                <label>Site Logo</label>
                <br/>
                @if(!empty($settings['site_logo']))<img src="{{$settings['site_logo']}}" class="bg-dark" height="32">@endif
                <br/><br/>
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">Change Logo</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="site_logo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                  </div>
                </div>
                <small>Only png files are allowed, Max File Size: 200kb, Recommended 200x48</small> </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="remove_logo">
                  <label class="custom-control-label" for="defaultUnchecked">Remove Logo</label>
                </div>
              </div>
              <div class="form-group">
                <label>Site Favicon</label>
                <br/>
                @if(!empty($settings['site_favicon']))<img src="{{$settings['site_favicon']}}" class="bg-dark" height="32">@endif
                <br/><br/>
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">Change Favicon</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="site_favicon" id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                  </div>
                </div>
                <small>Only png, ico files are allowed, Max File Size: 100kb, Recommended 32x32</small> </div>
              <div class="form-group">
                <label>Footer Text</label>
                <textarea class="form-control" name="footer_text" rows="5">{{old('footer_text',$settings['footer_text'])}}</textarea>
              </div>
              <div class="form-group">
                <label>Registration Open</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="registration_open1" name="registration_open" value="1" @if($settings['registration_open'] == 1) checked @endif>
                  <label class="custom-control-label" for="registration_open1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="registration_open0" name="registration_open" value="0" @if($settings['registration_open'] == 0) checked @endif>
                  <label class="custom-control-label" for="registration_open0">No</label>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Paste Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              @csrf
              <input type="hidden" name="type" value="paste">
              <div class="form-group">
                <label>Syntax Hightlighting Skin</label>
                @php $selected = old('syntax_highlighting_style',$settings['syntax_highlighting_style']); @endphp
                <select name="syntax_highlighting_style" class="form-control">
                  <option value="default" @if($selected == 'default') selected @endif>Default</option>
                  <option value="dark" @if($selected == 'dark') selected @endif>Dark Brown</option>
                  <option value="coy" @if($selected == 'coy') selected @endif>Coy</option>
                  <option value="okadia" @if($selected == 'okadia') selected @endif>Okadia</option>
                  <option value="funky" @if($selected == 'funky') selected @endif>Funky</option>
                  <option value="solarized-light" @if($selected == 'solarized-light') selected @endif>Solarized Light</option>
                  <option value="tomorrow-night" @if($selected == 'tomorrow-night') selected @endif>Tomorrow Night</option>
                  <option value="twilight" @if($selected == 'twilight') selected @endif>Twilight</option>
                </select>
              </div>
              <div class="form-group">
                <label>Public Paste</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_paste1" name="public_paste" value="1" @if($settings['public_paste'] == 1) checked @endif>
                  <label class="custom-control-label" for="public_paste1">Yes</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_paste0" name="public_paste" value="0" @if($settings['public_paste'] == 0) checked @endif>
                  <label class="custom-control-label" for="public_paste0">No</label>
                </div>
                <br/>
                <small class="text-muted">anyone can paste without registration</small> </div>
              <div class="form-group">
                <label>Max Paste  Size in KB*</label>
                <input type="number" class="form-control" name="max_content_size_kb" placeholder="500" value="{{old('max_content_size_kb',$settings['max_content_size_kb'])}}" >
              </div>
              <div class="form-group">
                <label>Pastes per page*</label>
                <input type="number" class="form-control" name="pastes_per_page" placeholder="10" value="{{old('pastes_per_page',$settings['pastes_per_page'])}}" >
               </div>               
               <div class="form-group">
                <label>Self Destroy After X Views*</label>
                <input type="number" class="form-control" name="self_destroy_after_views" placeholder="10" value="{{old('self_destroy_after_views',$settings['self_destroy_after_views'])}}" >
               </div>                
              <div class="form-group">
                <label>Recent Pastes Limit*</label>
                <input type="number" class="form-control" name="recent_pastes_limit" placeholder="5" value="{{old('recent_pastes_limit',$settings['recent_pastes_limit'])}}" >
                <small class="text-muted">Set to 0 to hide Recent pastes widget</small> </div>
              <div class="form-group">
                <label>My Recent Pastes Limit*</label>
                <input type="number" class="form-control" name="my_recent_pastes_limit" placeholder="5" value="{{old('my_recent_pastes_limit',$settings['my_recent_pastes_limit'])}}" >
                <small class="text-muted">Set to 0 to hide My Recent pastes widget</small> </div>
              <div class="form-group">
                <label>Daily Pastes Limit for Unauthorized user*</label>
                <input type="number" class="form-control" name="daily_paste_limit_unauth" placeholder="5" value="{{old('daily_paste_limit_unauth',$settings['daily_paste_limit_unauth'])}}" >
              </div>
              <div class="form-group">
                <label>Daily Pastes Limit for Authorized user*</label>
                <input type="number" class="form-control" name="daily_paste_limit_auth" placeholder="5" value="{{old('daily_paste_limit_auth',$settings['daily_paste_limit_auth'])}}" >
              </div>
              <div class="form-group">
                <label>Features Toggle</label>
                <br/>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_share" name="feature_share" @if($settings['feature_share'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_share">Share</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_copy" name="feature_copy" @if($settings['feature_copy'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_copy">Copy Link</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_raw" name="feature_raw" @if($settings['feature_raw'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_raw">Raw</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_download" name="feature_download" @if($settings['feature_download'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_download">Download</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_embed" name="feature_embed" @if($settings['feature_embed'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_embed">Embed</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_report" name="feature_report" @if($settings['feature_report'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_report">Report</label>
                </div>
                <div class="custom-control custom-checkbox mb-2">
                  <input type="checkbox" class="custom-control-input" id="feature_print" name="feature_print" @if($settings['feature_print'] == 1) checked @endif>
                  <label class="custom-control-label" for="feature_print">Print</label>
                </div>
              </div>
              <div class="form-group mb-4">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Advertisement Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              <input type="hidden" name="type" value="advertisement">
              @csrf
              <div class="form-group">
                <label>Ad Blocks(on/off)</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ad1" name="ad" value="1" @if($settings['ad'] == 1) checked @endif>
                  <label class="custom-control-label" for="ad1">On</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ad0" name="ad" value="0" @if($settings['ad'] == 0) checked @endif>
                  <label class="custom-control-label" for="ad0">Off</label>
                </div>
              </div>
              <div class="form-group">
                <label>Ad Block 1</label>
                <textarea class="form-control" name="ad1" rows="3">{{old('ad1',$settings['ad1'])}}</textarea>
              </div>
              <div class="form-group">
                <label>Ad Block 2</label>
                <textarea class="form-control" name="ad2" rows="3">{{old('ad2',$settings['ad2'])}}</textarea>
              </div>
              <div class="form-group">
                <label>Ad Block 3</label>
                <textarea class="form-control" name="ad3" rows="3">{{old('ad3',$settings['ad3'])}}</textarea>
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> SEO Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              <input type="hidden" name="type" value="seo">
              @csrf
              <div class="form-group">
                <label>Meta Description</label>
                <textarea class="form-control" name="meta_description">{{old('meta_description',$settings['meta_description'])}}</textarea>
              </div>
              <div class="form-group">
                <label>Meta Keywords</label>
                <textarea class="form-control" name="meta_keywords">{{old('meta_keywords',$settings['meta_keywords'])}}</textarea>
              </div>
              <div class="form-group">
                <label>Analytics Code</label>
                <textarea class="form-control" name="analytics_code" placeholder="<script>..</script>">{{old('analytics_code',html_entity_decode($settings['analytics_code']))}}</textarea>
              </div>
              <div class="form-group">
                <label>Site Image</label>
                <br/>
                @if(!empty($settings['site_image']))<img src="{{$settings['site_image']}}" class="bg-dark" height="32">@endif
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon03">Change Logo</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="site_image" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03">
                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                  </div>
                </div>
                <small>Only png, jpg files are allowed, Max File Size: 200kb</small> </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Comments Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              @csrf
              <input type="hidden" name="type" value="comments">
              <div class="form-group">
                <label>Disqus Comments(on/off)</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="disqus1" name="disqus" value="1" @if($settings['disqus'] == 1) checked @endif>
                  <label class="custom-control-label" for="disqus1">On</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="disqus0" name="disqus" value="0" @if($settings['disqus'] == 0) checked @endif>
                  <label class="custom-control-label" for="disqus0">Off</label>
                </div>
              </div>
              <div class="form-group">
                <label>Disqus Code</label>
                <textarea class="form-control" name="disqus_code" rows="4">{!!old('disqus_code',html_entity_decode($settings['disqus_code']))!!}</textarea>
                <small>Get disqus code from <a href="https://disqus.com" target="_blank">here</a>.</small> </div>
              <div class="form-group mb-4">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Captcha Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              <input type="hidden" name="type" value="captcha">
              @csrf
              <div class="form-group">
                <label>Invisible Recaptcha(on/off)</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="captcha1" name="captcha" value="1" @if($settings['captcha'] == 1) checked @endif>
                  <label class="custom-control-label" for="captcha1">On</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="captcha0" name="captcha" value="0" @if($settings['captcha'] == 0) checked @endif>
                  <label class="custom-control-label" for="captcha0">Off</label>
                </div>
                <p><small class="text-muted">How to get Invisible Recaptcha SiteKey & SecretKey? <a class="blue-text" data-toggle="modal" data-target="#sideModal" data-backdrop="false">click here</a></small></p>
              </div>
              <div class="form-group">
                <label>Invisible Recaptcha SiteKey</label>
                <input type="text" class="form-control" name="captcha_site_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_site_key',$settings['captcha_site_key'])}}" >
              </div>
              <div class="form-group">
                <label>Invisible Recaptcha SecretKey</label>
                <input type="text" class="form-control" name="captcha_secret_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_secret_key',$settings['captcha_secret_key'])}}" >
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Mail Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              <input type="hidden" name="type" value="mail">
              @csrf
              <div class="form-group">
                <label>Mail Driver*</label>
                @php $selected = old('mail_driver',$settings['mail_driver']); @endphp
                <select class="form-control" name="mail_driver">
                  <option value="mail" @if($selected == 'mail') selected @endif>mail</option>
                  <option value="smtp" @if($selected == 'smtp') selected @endif>smtp</option>
                  <option value="sendmail" @if($selected == 'sendmail') selected @endif>sendmail</option>
                  <option value="mailgun" @if($selected == 'mailgun') selected @endif>mailgun</option>
                  <option value="mandrill" @if($selected == 'mandrill') selected @endif>mandrill</option>
                  <option value="ses" @if($selected == 'ses') selected @endif>ses</option>
                  <option value="sparkpost" @if($selected == 'sparkpost') selected @endif>sparkpost</option>
                  <option value="log" @if($selected == 'log') selected @endif>log</option>
                </select>
              </div>
              <div class="form-group">
                <label>Mail Host</label>
                <input type="text" class="form-control" name="mail_host" placeholder="smtp.mail.io" value="{{old('mail_host',$settings['mail_host'])}}" >
              </div>
              <div class="form-group">
                <label>Mail Port</label>
                <input type="text" class="form-control" name="mail_port" placeholder="587" value="{{old('mail_port',$settings['mail_port'])}}" >
              </div>
              <div class="form-group">
                <label>Mail Username</label>
                <input type="text" class="form-control" name="mail_username" value="{{old('mail_username',$settings['mail_username'])}}" >
              </div>
              <div class="form-group">
                <label>Mail Password</label>
                <input type="password" class="form-control" name="mail_password" value="{{old('mail_password',$settings['mail_password'])}}" >
              </div>
              <div class="form-group">
                <label>Mail Encryption</label>
                <input type="text" class="form-control" name="mail_encryption" placeholder="ssl/tls" value="{{old('mail_encryption',$settings['mail_encryption'])}}" >
              </div>
              <div class="form-group">
                <label>Mail From Address</label>
                <input type="text" class="form-control" name="mail_from_address" placeholder="noreply@example.com" value="{{old('mail_from_address',$settings['mail_from_address'])}}" >
              </div>
              <div class="form-group">
                <label>Mail From Name</label>
                <input type="text" class="form-control" name="mail_from_name" placeholder="PasteShr" value="{{old('mail_from_name',$settings['mail_from_name'])}}" >
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="text-center"><i class="fa fa-cog fa-spin"></i> Social Links Settings <i class="fa fa-cog  fa-spin"></i> </h5>
          </div>
          <div class="card-body">
            <form method="post">
              <input type="hidden" name="type" value="social_links">
              @csrf
              <div class="form-group">
                <label>Facebook*</label>
                <input type="text" class="form-control" name="social_fb" placeholder="http://facebook.com/username" value="{{old('social_fb',$settings['social_fb'])}}" >
              </div>
              <div class="form-group">
                <label>Twitter*</label>
                <input type="text" class="form-control" name="social_tw" placeholder="http://twitter.com/@username" value="{{old('social_tw',$settings['social_tw'])}}" >
              </div>
              <div class="form-group">
                <label>Google Plus*</label>
                <input type="text" class="form-control" name="social_gp" placeholder="http://plus.google.com/username" value="{{old('social_gp',$settings['social_gp'])}}" >
              </div>
              <div class="form-group">
                <label>LinkedIn*</label>
                <input type="text" class="form-control" name="social_lin" placeholder="http://linkedin.com/username" value="{{old('social_lin',$settings['social_lin'])}}" >
              </div>
              <div class="form-group">
                <label>Pinterest*</label>
                <input type="text" class="form-control" name="social_pin" placeholder="http://pinterest.com/username" value="{{old('social_pin',$settings['social_pin'])}}" >
              </div>
              <div class="form-group">
                <label>Instagram*</label>
                <input type="text" class="form-control" name="social_insta" placeholder="http://instagram.com/username" value="{{old('social_insta',$settings['social_insta'])}}" >
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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