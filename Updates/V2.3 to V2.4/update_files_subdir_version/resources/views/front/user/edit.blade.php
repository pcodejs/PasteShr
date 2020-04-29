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
        function loadFile(event, id) {
            // alert(event.files[0]);
            var reader = new FileReader();
            reader.onload = function () {
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
			<div class="row">
				<div class="col-md-3">
					@include('front.user.sidebar')
				</div>
				<div class="col-md-9">
				@include('front.includes.messages')
				<!-- Material form register -->
					<div class="card">
						<h5 class="card-header"><i class="fa fa-user-circle-o"></i> <strong>{{ $page_title}}</strong>
						</h5>
						<!--Card content-->
						<div class="card-body  pt-0">
							<form class="p-3" method="post" enctype="multipart/form-data" action="">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Username')}}</label>
											<input type="text" id="defaultContactFormName" class="form-control mb-4" value="{{$user->name}}" disabled>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('E-Mail address')}}</label>
											<input type="email" id="defaultContactFormEmail" class="form-control mb-4" value="{{$user->email}}" disabled>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>{{ __('Avatar')}}</label> <br />
									<img src="{{$user->avatar}}" id="avatar" class="rounded-circle z-depth-1-half avatar-pic mb-4" height="80" width="80">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01" onchange="loadFile(this,'avatar')" aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file jpg-png Max 1MB')}}</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>{{ __('About Me')}}</label>
									<textarea name="about" class="form-control mb-4">{{old('about',$user->about)}}</textarea>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label><i class="fa fa-facebook"></i> {{ __('Facebook Link')}}</label>
											<input type="text" name="fb" class="form-control mb-4" value="{{old('fb',$user->fb)}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><i class="fa fa-twitter"></i> {{ __('Twitter Link')}}</label>
											<input type="text" name="tw" class="form-control mb-4" value="{{old('tw',$user->tw)}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label><i class="fa fa-google-plus"></i> {{ __('Google Plus Link')}}</label>
											<input type="text" name="gp" class="form-control mb-4" value="{{old('gp',$user->gp)}}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Password')}}</label>
											<input type="password" name="password" class="form-control mb-4">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Confirm Password')}}</label>
											<input type="password" name="password_confirmation" class="form-control mb-4">
										</div>
									</div>
								</div>
								<!-- Save button -->
								<button class="btn btn-blue-grey darken-5 btn-block" type="submit">{{ __('Save')}}</button>
							</form>
							<!-- Default form contact -->
						</div>
					</div>
					<!-- Material form register -->
				</div>
			</div>
		</div>
	</main>

@stop