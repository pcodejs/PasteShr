@extends('front.layouts.default')

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
						<h5 class="card-header"><i class="fa fa-cogs"></i> <strong>{{ $page_title}}</strong>
						</h5>
						<!--Card content-->
						<div class="card-body  pt-0">
							<form class="p-3" method="post" enctype="multipart/form-data" action="">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Default Paste Title')}} <small class="text-muted">[{{ __('Optional')}}]</small></label>
											<input type="text" name="title" class="form-control mb-4" value="{{old('title',$paste->title)}}" placeholder="{{__('Untitled')}}" tabindex="1" autofocus>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Default Paste Status')}} :
												<small class="text-muted">[{{ __('Optional')}}] </small> </label>
											@php $selected = old('status',$paste->status); @endphp
											<select class="form-control" name="status" tabindex="2">
												<option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}
												</option>
												<option value="2"
														@if($selected == 2) selected @endif>{{ __('Unlisted')}}
												</option>
												<option value="3" @if(!Auth::check()) disabled
														@else  @if($selected == 3) selected @endif @endif>
													{{ __('Private')}} ({{ __('members only')}})
												</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6"><div class="form-group">
											<label>{{ __('Default Syntax Highlighting')}} :
												<small class="text-muted">[{{ __('Optional')}}] </small> </label>
											@php $selected = old('syntax',$paste->syntax); @endphp
											<select class="form-control select2" name="syntax" tabindex="3">
												<option value="none">{{ __('Select')}}
												</option>
												<optgroup label="{{ __('Popular Languages')}}">
													@foreach($popular_syntaxes as $syntax)
														<option value="{{$syntax->slug}}"
																data-ext="{{(!empty($syntax->extension))?$syntax->extension:'txt'}}"
																@if($selected == $syntax->slug) selected @endif>{{$syntax->name}}
														</option>
													@endforeach
												</optgroup>
												<optgroup label="{{ __('All Languages')}}">
													@foreach($syntaxes as $syntax)
														<option value="{{$syntax->slug}}"
																data-ext="{{(!empty($syntax->extension))?$syntax->extension:'txt'}}"
																@if($selected == $syntax->slug) selected @endif>{{$syntax->name}}
														</option>
													@endforeach
												</optgroup>
											</select>
										</div></div>
									<div class="col-md-6"><div class="form-group">
											<label>{{ __('Default Paste Expiration')}} :
												<small class="text-muted">[{{ __('Optional')}}] </small> </label>
											@php $selected = old('expire',$paste->expire); @endphp
											<select class="form-control" name="expire" tabindex="4">
												<option value="N" @if($selected == 'N') selected @endif>{{ __('Never')}}
												</option>
												<option value="SD"
														@if($selected == 'SD') selected @endif>{{ __('Self Destroy')}}
												</option>
												<option value="10M"
														@if($selected == '10M') selected @endif>{{ __('10 Minutes')}}
												</option>
												<option value="1H"
														@if($selected == '1H') selected @endif>{{ __('1 Hour')}}
												</option>
												<option value="1D"
														@if($selected == '1D') selected @endif>{{ __('1 Day')}}
												</option>
												<option value="1W"
														@if($selected == '1W') selected @endif>{{ __('1 Week')}}
												</option>
												<option value="2W"
														@if($selected == '2W') selected @endif>{{ __('2 Weeks')}}
												</option>
												<option value="1M"
														@if($selected == '1M') selected @endif>{{ __('1 Month')}}
												</option>
												<option value="6M"
														@if($selected == '6M') selected @endif>{{ __('6 Months')}}
												</option>
												<option value="1Y"
														@if($selected == '1Y') selected @endif>{{ __('1 Year')}}
												</option>
											</select>
										</div></div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>{{ __('Default Password')}} :
												<small class="text-muted">[{{ __('Optional')}}] </small> </label>
											<input type="text" name="password" class="form-control" placeholder="{{ __('Default Password')}}" tabindex="5" value="{{$paste->password}}">
										</div>
										<div class="form-group">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="encrypted" name="encrypted" value="1" tabindex="6" @if(old('encrypted',$paste->encrypted) == 1) checked @endif>
												<label class="custom-control-label" for="encrypted">{{ __('Default Encrypt Paste')}} <small class="text-muted">[{{ __('Optional')}}] </small></label>
												<span>(<small class="cp" title="{{ __('Protect your text by Encrypting and Decrypting any given text with a key that no one knows')}}">?</small>)</span>
											</div>
										</div>
									</div>
								</div>

								<!-- Save button -->
								<button class="btn btn-blue-grey darken-5 btn-block" type="submit" tabindex="7">{{ __('Save')}}</button>
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
