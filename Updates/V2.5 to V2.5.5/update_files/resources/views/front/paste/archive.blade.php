@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!config('settings.meta_description')!!}">
<meta name="keywords" content="{!!config('settings.meta_keywords')!!}">
<meta name="author" content="{{config('settings.site_name')}}">

<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::url()}}" />
@if(!empty(config('settings.site_image')))
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
@endif
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('content')
	<main>
		<!--Main layout-->
		<div class="container">
			<!--First row-->
			<div class="row " data-wow-delay="0.2s">
				<div class="@if(config('settings.site_layout') == 1) col-md-9 @else col-md-12 @endif">
					@if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
						<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad1')) !!}</div>@endif
					<div class="card">
						<div class="card-header"> {{ __('Archive')}} - {{$syntax->name}} </div>
						<ul class="list-group list-group-flush">
							@forelse($pastes as $paste)
								<li class="list-group-item">
									<i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))
										<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))
										<i class="fa fa-clock-o text-warning small"></i> @endif
									<a href="{{$paste->url}}">{{$paste->title_f}}</a>
									<p>
										<small class="text-muted">@if(isset($paste->language)) {{$paste->language->name}} @else{{$paste->syntax}}@endif |
											<i class="fa fa-eye blue-grey-text"></i> {{$paste->views_f}} | {{$paste->created_ago}}
										</small></p>
								</li>
							@empty
								<li class="list-group-item text-center">{{ __('No results')}}</li>
							@endforelse
						</ul>
					</div>
					<div class="row">
						@if(Auth::check())
							<div class=" mx-auto mt-3 d-none d-sm-none d-md-block"> {{$pastes->links()}} </div>
							<div class=" mx-auto mt-3 d-sm-block d-md-none"> {{$pastes->links('pagination::simple-bootstrap-4')}} </div>
						@else
							<div class="col-md-12 mt-3">
								<div class="alert alert-warning" role="alert">
									<i class="fa fa-info-circle"></i> {{ __('You are currently not logged in')}}, {{ __('this means you can only see limited pastes')}}.
									<a href="{{route('register')}}">{{ __('Sign Up')}}</a> {{__('or')}}
									<a href="{{route('login')}}">{{ __('Login')}}</a>
								</div>
							</div>
						@endif
					</div>
					@if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
						<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>@endif
				</div>
				@include('front.paste.recent_pastes')
			</div>
			<!--/.First row-->
		</div>
		<!--/.Main layout-->
	</main>
@stop 