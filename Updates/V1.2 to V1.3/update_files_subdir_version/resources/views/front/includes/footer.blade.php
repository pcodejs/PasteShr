<!-- The Modal -->
<div class="modal" id="localeModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{ __('Site Languages')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

        <!-- Modal body -->
        <div class="modal-body"> 
          <ul style="list-style-type: none;">
            @forelse($locales as $lang)
              <li><a href="{{url('lang/'.$lang->code)}}" style="margin-left: 4.0rem!important;">{{$lang->name}}</a></li>
            @empty
                {{ __('No results')}}
            @endforelse

            </ul>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
        </div>
    </div>
  </div>
</div>




<!--Footer-->
<footer class="page-footer text-center text-md-left mt-4 pt-4"> 
  <!--Footer links-->
  <div class="container-fluid">
    <div class="row"> 
      <!--First column-->
      <div class="col-lg-4 col-md-6 ml-auto">
        <h5 class="title mb-3"><strong>{{ __('About')}} {{config('settings.site_name')}}</strong></h5>
        <p>{{config('settings.footer_text')}}</p>
      </div>
      <!--/.First column-->
      <hr class="w-100 clearfix d-sm-none">
      <!--Second column-->
      <div class="col-lg-3 col-md-6 ml-auto mb-4">
        <h5 class="title mb-3"><strong>{{ __('Pages')}}</strong></h5>
        <ul class="list-unstyled">
          <li> <a href="{{url('pages/about')}}">{{ __('About Us')}}</a> </li>
          <li> <a href="{{url('contact')}}">{{ __('Contact Us')}}</a> </li>
          <li> <a href="{{url('pages/privacy-policy')}}">{{ __('Privacy policy')}}</a> </li>
          <li> <a href="{{url('pages/terms')}}">{{ __('Terms of Service')}}</a> </li>
        </ul>
      </div>
      <!--/.Second column-->
      <hr class="w-100 clearfix d-sm-none">
      <!--Third column-->
      <div class="col-lg-3 col-md-6 ml-auto mb-4">
        <h5 class="title mb-3"><strong>{{ __('Useful Links')}}</strong></h5>
        <ul class="list-unstyled">
          <li> <a href="{{url('pages/faq')}}">{{ __('FAQ')}}</a> </li>
          <li> <a href="{{url('archive')}}">{{ __('Syntax Languages')}}</a> </li>
          <li> <a data-toggle="modal" data-target="#localeModal">{{ __('Site Languages')}}</a> </li>
          <li> <a href="{{url('sitemap.xml')}}">{{ __('Sitemap')}}</a> </li>
        </ul>
      </div>
      <!--/.Third column-->
      <hr class="w-100 clearfix d-sm-none">
    </div>
    
    <!-- Grid row-->
    <div class="row"> 
      
      <!-- Grid column -->
      <div class="col-md-12 py-3">
        <div class="mb-5 flex-center"> 
          
          <!-- Facebook --> 
          <a class="fb-ic" href="{{config('settings.social_fb')}}" target="_blank"> <i class="fa fa-facebook fa-lg white-text mr-md-5 mr-3 fa-2x"> </i> </a> 
          <!-- Twitter --> 
          <a class="tw-ic" href="{{config('settings.social_tw')}}" target="_blank"> <i class="fa fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i> </a> 
          <!-- Google +--> 
          <a class="gplus-ic" href="{{config('settings.social_gp')}}" target="_blank"> <i class="fa fa-google-plus fa-lg white-text mr-md-5 mr-3 fa-2x"> </i> </a> 
          <!--Linkedin --> 
          <a class="li-ic" href="{{config('settings.social_lin')}}" target="_blank"> <i class="fa fa-linkedin fa-lg white-text mr-md-5 mr-3 fa-2x"> </i> </a> 
          <!--Instagram--> 
          <a class="ins-ic" href="{{config('settings.social_insta')}}" target="_blank"> <i class="fa fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i> </a> 
          <!--Pinterest--> 
          <a class="pin-ic" href="{{config('settings.social_pin')}}" target="_blank"> <i class="fa fa-pinterest fa-lg white-text fa-2x"> </i> </a> </div>
      </div>
      <!-- Grid column --> 
      
    </div>
    <!-- Grid row--> 
    
  </div>
  
  <!--/.Footer links--> 
  
  <!--Copyright-->
  <div class="footer-copyright py-3 text-center">
    <div class="containter-fluid"> © {{date('Y')}} <a href="{{url('/')}}">{{config('settings.site_name')}}</a>. </div>
  </div>
  <!--/.Copyright--> 
</footer>
<!--/.Footer--> 
