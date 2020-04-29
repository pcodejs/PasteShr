@extends('front.layouts.default')

@section('content')
	<main>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					@include('front.user.sidebar')
				</div>
				<div class="col-md-9">
					<div class="card">
						<div class="card-header">
							<i class="fa fa-dashboard"></i> {{$page_title}}
						</div>
						<div class="card-body">
							<div class="row">
								<!--Grid column-->
								<div class="col-xl-3 col-md-6 mb-4">
									<!--Card Default-->
									<div class="card classic-admin-card warning-color">
										<div class="card-body">
											<div class="pull-right"><i class="fa fa-paste fa-2x"></i></div>
											<p class="white-text">{{__('Total Pastes')}}</p>
											<h3>{{\App\Models\Paste::where('user_id',Auth::user()->id)->count()}}</h3>
										</div>
									</div>
									<!--/.Card Default-->
								</div>
								<!--Grid column-->
								<!--Grid column-->
								<div class="col-xl-3 col-md-6 mb-4">
									<!--Card Default-->
									<div class="card classic-admin-card success-color">
										<div class="card-body">
											<div class="pull-right"><i class="fa fa-paste fa-2x"></i></div>
											<p class="white-text">{{__('Public Pastes')}}</p>
											<h3>{{\App\Models\Paste::where('user_id',Auth::user()->id)->where('status',1)->count()}}</h3>
										</div>
									</div>
									<!--/.Card Default-->
								</div>
								<!--Grid column-->                <!--Grid column-->
								<div class="col-xl-3 col-md-6 mb-4">
									<!--Card Default-->
									<div class="card classic-admin-card info-color">
										<div class="card-body">
											<div class="pull-right"><i class="fa fa-paste fa-2x"></i></div>
											<p class="white-text">{{__('Unlisted Pastes')}}</p>
											<h3>{{\App\Models\Paste::where('user_id',Auth::user()->id)->where('status',2)->count()}}</h3>
										</div>
									</div>
									<!--/.Card Default-->
								</div>
								<!--Grid column-->
								<!--Grid column-->
								<div class="col-xl-3 col-md-6 mb-4">
									<!--Card Default-->
									<div class="card classic-admin-card danger-color">
										<div class="card-body">
											<div class="pull-right"><i class="fa fa-paste fa-2x"></i></div>
											<p class="white-text">{{__('Private Pastes')}}</p>
											<h3>{{\App\Models\Paste::where('user_id',Auth::user()->id)->where('status',3)->count()}}</h3>
										</div>
									</div>
									<!--/.Card Default-->
								</div>
								<!--Grid column-->
							</div>

							<div class="col-md-12">

								<p class="m-0"><b>{{__('Views')}}:</b></p>
								<p>{{__('Total views of all your pastes')}} - <b>{{Auth::user()->paste_views}}</b></p>

								<p class="m-0"><b>{{__('Backup')}}:</b></p>
								<p>{{__('If you want a backup of all your pastes')}} <a href="{{route('user.backup')}}">{{ __('click here')}}</a></p>

								<p class="m-0"><b>{{__('Privacy')}}:</b></p>
								<p>{{__('To see what other people see on your profile')}} <a href="{{Auth::user()->url}}" target="_blank">{{ __('click here')}}</a></p>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@stop
