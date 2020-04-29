@extends('front.layouts.default')

@section('content')
	<main>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					@include('front.user.sidebar')
				</div>
				<div class="col-md-9">
					@include('front.includes.messages')
					<div class="card">
						<div class="card-header">
							<i class="fa fa-trash"></i> {{$page_title}}
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="alert alert-warning" role="alert">
										<i class="fa fa-info-circle"></i> {{ __('Before you can delete your account make sure you have an active password') }}
									</div>

									<a class="btn btn-danger btn-block mt-1"  data-toggle="modal" data-target="#modalDeleteAccount"><i class="fa fa-trash"></i> {{ __('Delete Account')}}</a>
								</div>
							</div>
						</div>
					</div>
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
        <h4 class=""><i class="fa fa-trash"></i> {{ __('Delete Account')}} - {{$user->name}}</h4>
        <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <!-- Body -->
      <div class="modal-body mb-0">
        <form method="post" action="{{route('profile.delete')}}">
          @csrf
          <div class="md-form form-sm"> <i class="fa fa-user prefix"></i>
            <input type="password" name="password" id="form99" class="form-control form-control-sm" tabindex="1" required>
            <label for="form99">{{ __('Password')}}</label>
          </div>



          <img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha">
              <a rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='{{url('captcha/'.config('settings.custom_captcha_style'))}}?'+Math.random()" class="refresh">

                <button type="button" class="btn btn-info btn-sm btn-refresh" tabindex="4"><i class="fa fa-refresh"></i></button>

              </a>
          <div class="md-form"> <i class="fa fa-shield prefix grey-text"></i>
            <input type="text" id="form6" name="g-recaptcha-response" class="form-control" tabindex="2" required>
            <label for="form6"> {{ __('Security Check')}}</label>
          </div>


          <div class="text-center mt-1-half">
            <button class="btn btn-danger mb-2" type="submit" tabindex="3">{{ __('Confirm Delete Account')}}</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Content -->
  </div>
</div>
<!-- Modal: form -->
@stop

