@extends('admin.layouts.default')

@section('after_scripts')
	@if(session('type'))
		<script>
            $('#{{session('type')}}').addClass('active show');
            $('#{{session('type')}}-tab').addClass('active');
		</script>
	@else
		<script>
            $('#general').addClass('active show');
            $('#general-tab').addClass('active');
		</script>
	@endif
@stop

@section('content')
	<!--Main layout-->
	<main class="pt-5 mx-lg-5">
		<div class="container mt-5">
			<!-- Heading -->
			<div class="card mb-4">
				<!--Card content-->
				<div class="card-body d-sm-flex justify-content-between">
					<h4 class="mb-2 mb-sm-0 pt-1"><a href="{{url('admin/dashboard')}}">Admin </a> <span>/ </span>
						<span>{{$page_title}} </span></h4>
					<div>
						<a href="{{url('admin/clear-cache')}}" class="btn btn-sm btn-danger">
							<i class="fa fa-trash"> </i> Clear Cache </a>
						<a href="https://ecodevs.com/contact" target="_blank" class="btn btn-sm btn-primary">
							<i class="fa fa-envelope"> </i> Contact Developer </a>						
						<a href="http://market.ecodevs.com/downloads/category/plugins/" target="_blank" class="btn btn-sm btn-warning">
							<i class="fa fa-plug"> </i> Plug-Ins </a>
					</div>
				</div>
			</div>
			<!-- Heading -->
			<!--Grid row-->
			<div class="row">
				<div class="col-md-12">@include('front.includes.messages') </div>
				<div class="col-md-12">
					<div class="card mb-4">
						<div class="card-header p-0">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab"><i class="fa fa-cog"></i> General
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="paste-tab" data-toggle="tab" href="#paste" role="tab"><i class="fa fa-paste"></i> Paste
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="advertisement-tab" data-toggle="tab" href="#advertisement" role="tab"><i class="fa fa-audio-description"></i> Advertisement
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"><i class="fa fa-anchor"></i> SEO
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab"><i class="fa fa-comments"></i> Comments
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="captcha-tab" data-toggle="tab" href="#captcha" role="tab"><i class="fa fa-dot-circle-o"></i> Captcha
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="social_auth-tab" data-toggle="tab" href="#social_auth" role="tab"><i class="fa fa-vcard-o"></i> Social Auth
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="mail-tab" data-toggle="tab" href="#mail" role="tab"><i class="fa fa-envelope"></i> Mail
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="social_links-tab" data-toggle="tab" href="#social_links" role="tab"><i class="fa fa-globe"></i> Social Links
									</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
									<form method="post" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="type" value="general">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Site Name* </label>
													<input type="text" class="form-control" name="site_name" placeholder="PasteShr" value="{{old('site_name',$settings['site_name'])}}">
												</div>
												<div class="form-group">
													<label>Site Email* </label>
													<input type="email" class="form-control" name="site_email" placeholder="Email" value="{{old('site_email',$settings['site_email'])}}">
												</div>
												<div class="form-group">
													<label>Site Skin </label>
													@php $selected = old('site_skin',$settings['site_skin']); @endphp
													<select class="form-control" name="site_skin">
														<option value="default" @if($selected == 'default') selected @endif>Default</option>
														<option value="brown" @if($selected == 'brown') selected @endif>Brown</option>
														<option value="orange" @if($selected == 'orange') selected @endif>Orange</option>
														<option value="pink" @if($selected == 'pink') selected @endif>Pink</option>
														<option value="special" @if($selected == 'special') selected @endif>Special</option>
														<option value="teal" @if($selected == 'teal') selected @endif>Teal</option>
														<option value="unique" @if($selected == 'unique') selected @endif>Unique</option>
													</select>
												</div>
												<div class="form-group">
													<label>Background Color* </label>
													<input type="color" class="form-control" name="background_color" placeholder="#f7f7f7" value="{{old('background_color',$settings['background_color'])}}">
													<small class="text-muted">Default : #f7f7f7</small></div>
												<div class="form-group">
													<label>Background Image </label> <br />
													@if(!empty($settings['background_image']))
														<a href="{{url($settings['background_image'])}}" target="_blank">View</a>
														<br />
														<br />
													@endif
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroupFileAddon04">Change Background Image </span>
														</div>
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="background_image" id="background_image1" aria-describedby="inputGroupFileAddon04">
															<label class="custom-file-label" for="background_image1">Choose file </label>
														</div>
													</div>
													<small class="text-muted">Only jpg/jpeg, png files are allowed, Max File Size: 500kb </small>
												</div>
												@if(!empty($settings['background_image']))
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="remove_background_image" name="remove_background_image">
															<label class="custom-control-label" for="remove_background_image">Remove Background Image </label>
														</div>
													</div>
												@endif
												<div class="form-group">
													<label>Default Site Locale </label>
													@php $selected = old('default_locale',$settings['default_locale']); @endphp
													<select class="form-control" name="default_locale">
														<option value="en">Select</option>
														@foreach($locales as $lang)

															<option value="{{$lang->code}}" @if($selected == $lang->code) selected @endif>{{$lang->name}} </option>

														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label>Default Timezone </label>
													@php $selected = old('default_timezone',$settings['default_timezone']); @endphp
													<select class="form-control" name="default_timezone">
														@foreach(timezone_identifiers_list() as $key => $value)
															<option value="{{$value}}" @if($value == $selected) selected @endif>{{$value}}</option>
														@endforeach
													</select> <small class="text-muted">To find your timezone
														<a href="http://php.net/manual/en/timezones.php" target="_blank">click here </a>.
													</small>
												</div>
												<div class="form-group">
													<label>Site Logo </label> <br />
													@if(!empty($settings['site_logo']))
														<img src="{{url($settings['site_logo'])}}" class="bg-dark" height="32">
														<br />
														<br />
													@endif
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroupFileAddon01">Change Logo </span>
														</div>
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="site_logo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
															<label class="custom-file-label" for="inputGroupFile01">Choose file </label>
														</div>
													</div>
													<small class="text-muted">Only png files are allowed, Max File Size: 200kb, Recommended 200x48 </small>
												</div>
												@if(!empty($settings['site_logo']))
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="remove_logo">
															<label class="custom-control-label" for="defaultUnchecked">Remove Logo </label>
														</div>
													</div>
												@endif
												<div class="form-group">
													<label>Site Favicon </label> <br />
													@if(!empty($settings['site_favicon']))
														<img src="{{url($settings['site_favicon'])}}" class="bg-dark" height="32">
														<br />
													@endif
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroupFileAddon01">Change Favicon </span>
														</div>
														<div class="custom-file">
															<input type="file" class="custom-file-input" name="site_favicon" id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
															<label class="custom-file-label" for="inputGroupFile02">Choose file </label>
														</div>
													</div>
													<small class="text-muted">Only png, ico files are allowed, Max File Size: 100kb, Recommended 32x32 </small>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Footer Text </label>
													<textarea class="form-control" name="footer_text" rows="2">{{old('footer_text',$settings['footer_text'])}}
													</textarea>
												</div>
												<div class="form-group">
													<label>Registration Open </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="registration_open1" name="registration_open" value="1" @if($settings['registration_open'] == 1) checked @endif>
														<label class="custom-control-label" for="registration_open1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="registration_open0" name="registration_open" value="0" @if($settings['registration_open'] == 0) checked @endif>
														<label class="custom-control-label" for="registration_open0">No </label>
													</div>
												</div>
												<div class="form-group">
													<label>Auto Approve User </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="auto_approve_user1" name="auto_approve_user" value="1" @if($settings['auto_approve_user'] == 1) checked @endif>
														<label class="custom-control-label" for="auto_approve_user1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="auto_approve_user0" name="auto_approve_user" value="0" @if($settings['auto_approve_user'] == 0) checked @endif>
														<label class="custom-control-label" for="auto_approve_user0">No </label>
													</div>
												</div>
												<div class="form-group">
													<label>Site Layout </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="site_layout1" name="site_layout" value="1" @if($settings['site_layout'] == 1) checked @endif>
														<label class="custom-control-label" for="site_layout1">Default </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="site_layout2" name="site_layout" value="2" @if($settings['site_layout'] == 2) checked @endif>
														<label class="custom-control-label" for="site_layout2">Full width </label>
													</div>
												</div>
												<div class="form-group">
													<label>Maintenance Mode </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="maintenance_mode1" name="maintenance_mode" value="1" @if($settings['maintenance_mode'] == 1) checked @endif>
														<label class="custom-control-label" for="maintenance_mode1">On </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="maintenance_mode0" name="maintenance_mode" value="0" @if($settings['maintenance_mode'] == 0) checked @endif>
														<label class="custom-control-label" for="maintenance_mode0">Off </label>
													</div>
												</div>
												<div class="form-group">
													<label>Maintenance Text </label>
													<textarea class="form-control" name="maintenance_text" rows="2">{{old('maintenance_text',$settings['maintenance_text'])}}</textarea>
												</div>
												<div class="form-group">
													<label>Navbar </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="navbar1" name="navbar" value="fixed" @if($settings['navbar'] == 'fixed') checked @endif>
														<label class="custom-control-label" for="navbar1">Fixed </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="navbar0" name="navbar" value="default" @if($settings['navbar'] == 'default') checked @endif>
														<label class="custom-control-label" for="navbar0">Default </label>
													</div>
												</div>
												<div class="form-group">
													<label>String Validation </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="string_validation1" name="string_validation" value="1" @if($settings['string_validation'] == 1) checked @endif>
														<label class="custom-control-label" for="string_validation1">Strict </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="string_validation0" name="string_validation" value="2" @if($settings['string_validation'] == 2) checked @endif>
														<label class="custom-control-label" for="string_validation0">Moderate </label>
													</div>
												</div>
												<div class="form-group">
													<label>Purchase Code </label>
													<input type="text" class="form-control" value="{{config('settings.pc')}}" disabled>
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="paste" role="tabpanel" aria-labelledby="paste-tab">
									<form method="post">
										@csrf
										<div class="row">
											<div class="col-md-6">
												<input type="hidden" name="type" value="paste">
												<div class="form-group">
													<label>Public Paste </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="public_paste1" name="public_paste" value="1" @if($settings['public_paste'] == 1) checked @endif>
														<label class="custom-control-label" for="public_paste1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="public_paste0" name="public_paste" value="0" @if($settings['public_paste'] == 0) checked @endif>
														<label class="custom-control-label" for="public_paste0">No </label>
													</div>
													<br />
													<small class="text-muted">anyone can paste without registration </small>
												</div>
												<div class="form-group">
													<label>User Paste </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="user_paste1" name="user_paste" value="1" @if($settings['user_paste'] == 1) checked @endif>
														<label class="custom-control-label" for="user_paste1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="user_paste0" name="user_paste" value="0" @if($settings['user_paste'] == 0) checked @endif>
														<label class="custom-control-label" for="user_paste0">No </label>
													</div>
													<br />
													<small class="text-muted">any user can paste after registration and login </small>
												</div>
												<div class="form-group">
													<label>Public Download </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="public_download1" name="public_download" value="1" @if($settings['public_download'] == 1) checked @endif>
														<label class="custom-control-label" for="public_download1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="public_download0" name="public_download" value="0" @if($settings['public_download'] == 0) checked @endif>
														<label class="custom-control-label" for="public_download0">No </label>
													</div>
													<br />
													<small class="text-muted">anyone can download without registration </small>
												</div>
												<div class="form-group">
													<label>Paste Title Required </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_title_required1" name="paste_title_required" value="1" @if($settings['paste_title_required'] == 1) checked @endif>
														<label class="custom-control-label" for="paste_title_required1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_title_required0" name="paste_title_required" value="0" @if($settings['paste_title_required'] == 0) checked @endif>
														<label class="custom-control-label" for="paste_title_required0">No </label>
													</div>
													<br />
													<small class="text-muted">one must enter title for paste </small>
												</div>
												<div class="form-group">
													<label>Paste Storage </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_storage1" name="paste_storage" value="database" @if($settings['paste_storage'] == 'database') checked @endif>
														<label class="custom-control-label" for="paste_storage1">Database </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_storage2" name="paste_storage" value="file" @if($settings['paste_storage'] == 'file') checked @endif>
														<label class="custom-control-label" for="paste_storage2">File </label>
													</div>
												</div>
												<div class="form-group">
													<label>Paste Page Layout </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_page_layout1" name="paste_page_layout" value="1" @if($settings['paste_page_layout'] == 1) checked @endif>
														<label class="custom-control-label" for="paste_page_layout1">Default </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_page_layout2" name="paste_page_layout" value="2" @if($settings['paste_page_layout'] == 2) checked @endif>
														<label class="custom-control-label" for="paste_page_layout2">Full width </label>
													</div>
												</div>
												<div class="form-group">
													<label>Paste Editor </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_editor2" name="paste_editor" value="default" @if($settings['paste_editor'] == 'default') checked @endif>
														<label class="custom-control-label" for="paste_editor2">Default </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_editor1" name="paste_editor" value="ace" @if($settings['paste_editor'] == 'ace') checked @endif>
														<label class="custom-control-label" for="paste_editor1">Ace Editor </label>
													</div>
												</div>
												<div class="form-group">
													<label>Paste Editor Line Numbers </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_editor_line_numbers2" name="paste_editor_line_numbers" value="1" @if($settings['paste_editor_line_numbers'] == 1) checked @endif>
														<label class="custom-control-label" for="paste_editor_line_numbers2">On </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="paste_editor_line_numbers1" name="paste_editor_line_numbers" value="0" @if($settings['paste_editor_line_numbers'] == 0) checked @endif>
														<label class="custom-control-label" for="paste_editor_line_numbers1">Off </label>
													</div>
												</div>
												<div class="form-group">
													<label>Syntax Highlighter </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter2" name="syntax_highlighter" value="prismjs" @if($settings['syntax_highlighter'] == 'prismjs') checked @endif>
														<label class="custom-control-label" for="syntax_highlighter2">PrismJS </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter1" name="syntax_highlighter" value="ace" @if($settings['syntax_highlighter'] == 'ace') checked @endif>
														<label class="custom-control-label" for="syntax_highlighter1">Ace </label>
													</div>
												</div>
												<div class="form-group">
													<label>Syntax Highlighter Line Numbers </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter_line_numbers2" name="syntax_highlighter_line_numbers" value="1" @if($settings['syntax_highlighter_line_numbers'] == 1) checked @endif>
														<label class="custom-control-label" for="syntax_highlighter_line_numbers2">On </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter_line_numbers1" name="syntax_highlighter_line_numbers" value="0" @if($settings['syntax_highlighter_line_numbers'] == 0) checked @endif>
														<label class="custom-control-label" for="syntax_highlighter_line_numbers1">Off </label>
													</div>
												</div>
												<div class="form-group">
													<label>Syntax Highlighter Break Word</label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter_break_word2" name="syntax_highlighter_break_word" value="1" @if($settings['syntax_highlighter_break_word'] == 1) checked @endif>
														<label class="custom-control-label" for="syntax_highlighter_break_word2">On </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="syntax_highlighter_break_word1" name="syntax_highlighter_break_word" value="0" @if($settings['syntax_highlighter_break_word'] == 0) checked @endif>
														<label class="custom-control-label" for="syntax_highlighter_break_word1">Off </label>
													</div>
												</div>
												<div class="form-group mt-4 mb-0">
													<label>Features Toggle </label>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_share" name="feature_share" @if($settings['feature_share'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_share">Share </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="qr_code_share" name="qr_code_share" @if($settings['qr_code_share'] == 1) checked @endif>
															<label class="custom-control-label" for="qr_code_share">QR Code Share </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_copy" name="feature_copy" @if($settings['feature_copy'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_copy">Copy Link </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_raw" name="feature_raw" @if($settings['feature_raw'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_raw">Raw </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_clone" name="feature_clone" @if($settings['feature_clone'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_clone">Clone </label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_download" name="feature_download" @if($settings['feature_download'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_download">Download </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_embed" name="feature_embed" @if($settings['feature_embed'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_embed">Embed </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_report" name="feature_report" @if($settings['feature_report'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_report">Report </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="feature_print" name="feature_print" @if($settings['feature_print'] == 1) checked @endif>
															<label class="custom-control-label" for="feature_print">Print </label>
														</div>
													</div>
												</div>
												<div class="form-group mt-4 mb-0">
													<label>Pages </label>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="trending_page" name="trending_page" @if($settings['trending_page'] == 1) checked @endif>
															<label class="custom-control-label" for="trending_page">Trending </label>
														</div>
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="search_page" name="search_page" @if($settings['search_page'] == 1) checked @endif>
															<label class="custom-control-label" for="search_page">Search </label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="custom-control custom-checkbox mb-2">
															<input type="checkbox" class="custom-control-input" id="archive_page" name="archive_page" @if($settings['archive_page'] == 1) checked @endif>
															<label class="custom-control-label" for="archive_page">Archive </label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Default Paste Syntax</label>
													@php $selected = old('default_syntax',$settings['default_syntax']); @endphp
													<select class="form-control" name="default_syntax">
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
												</div>
												<div class="form-group">
													<label>PrismJS Hightlighting Skin </label>
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
													<label>Ace Hightlighting Skin</label>
													@php $selected = old('ace_editor_skin',$settings['ace_editor_skin']); @endphp
													<select name="ace_editor_skin" class="form-control">
														<optgroup label="Bright">
															<option value="chrome" @if($selected == 'chrome') selected @endif>Chrome</option>
															<option value="clouds" @if($selected == 'clouds') selected @endif>Clouds</option>
															<option value="crimson_editor" @if($selected == 'crimson_editor') selected @endif>Crimson Editor</option>
															<option value="dawn" @if($selected == 'dawn') selected @endif>Dawn</option>
															<option value="dreamweaver" @if($selected == 'dreamweaver') selected @endif>Dreamweaver</option>
															<option value="eclipse" @if($selected == 'eclipse') selected @endif>Eclipse</option>
															<option value="github" @if($selected == 'github') selected @endif>GitHub</option>
															<option value="iplastic" @if($selected == 'iplastic') selected @endif>IPlastic</option>
															<option value="solarized_light" @if($selected == 'solarized_light') selected @endif>Solarized Light</option>
															<option value="textmate" @if($selected == 'textmate') selected @endif>TextMate</option>
															<option value="tomorrow" @if($selected == 'tomorrow') selected @endif>Tomorrow</option>
															<option value="xcode" @if($selected == 'xcode') selected @endif>XCode</option>
															<option value="kuroir" @if($selected == 'kuroir') selected @endif>Kuroir</option>
															<option value="katzenmilch" @if($selected == 'katzenmilch') selected @endif>KatzenMilch</option>
															<option value="sqlserver" @if($selected == 'sqlserver') selected @endif>SQL Server</option>
														</optgroup>
														<optgroup label="Dark">
															<option value="ambiance" @if($selected == 'ambiance') selected @endif>Ambiance</option>
															<option value="chaos" @if($selected == 'chaos') selected @endif>Chaos</option>
															<option value="clouds_midnight" @if($selected == 'clouds_midnight') selected @endif>Clouds Midnight</option>
															<option value="dracula" @if($selected == 'dracula') selected @endif>Dracula</option>
															<option value="cobalt" @if($selected == 'cobalt') selected @endif>Cobalt</option>
															<option value="gruvbox" @if($selected == 'gruvbox') selected @endif>Gruvbox</option>
															<option value="gob" @if($selected == 'gob') selected @endif>Green on Black</option>
															<option value="idle_fingers" @if($selected == 'idle_fingers') selected @endif>idle Fingers</option>
															<option value="kr_theme" @if($selected == 'kr_theme') selected @endif>krTheme</option>
															<option value="merbivore" @if($selected == 'merbivore') selected @endif>Merbivore</option>
															<option value="merbivore_soft" @if($selected == 'merbivore_soft') selected @endif>Merbivore Soft</option>
															<option value="mono_industrial" @if($selected == 'mono_industrial') selected @endif>Mono Industrial</option>
															<option value="monokai" @if($selected == 'monokai') selected @endif>Monokai</option>
															<option value="pastel_on_dark" @if($selected == 'pastel_on_dark') selected @endif>Pastel on dark</option>
															<option value="solarized_dark" @if($selected == 'solarized_dark') selected @endif>Solarized Dark</option>
															<option value="terminal" @if($selected == 'terminal') selected @endif>Terminal</option>
															<option value="tomorrow_night" @if($selected == 'tomorrow_night') selected @endif>Tomorrow Night</option>
															<option value="tomorrow_night_blue" @if($selected == 'tomorrow_night_blue') selected @endif>Tomorrow Night Blue</option>
															<option value="tomorrow_night_bright" @if($selected == 'tomorrow_night_bright') selected @endif>Tomorrow Night Bright</option>
															<option value="tomorrow_night_eighties" @if($selected == 'tomorrow_night_eighties') selected @endif>Tomorrow Night 80s</option>
															<option value="twilight" @if($selected == 'twilight') selected @endif>Twilight</option>
															<option value="vibrant_ink" @if($selected == 'vibrant_ink') selected @endif>Vibrant Ink</option>
														</optgroup>
													</select>
												</div>
												<div class="form-group">
													<label>Max Paste Size in KB* </label>
													<input type="number" class="form-control" name="max_content_size_kb" placeholder="500" value="{{old('max_content_size_kb',$settings['max_content_size_kb'])}}">
												</div>
												<div class="form-group">
													<label>Pastes per page* </label>
													<input type="number" class="form-control" name="pastes_per_page" placeholder="10" value="{{old('pastes_per_page',$settings['pastes_per_page'])}}">
												</div>
												<div class="form-group">
													<label>Self Destroy After X Views* </label>
													<input type="number" class="form-control" name="self_destroy_after_views" placeholder="10" value="{{old('self_destroy_after_views',$settings['self_destroy_after_views'])}}">
												</div>
												<div class="form-group">
													<label>Recent Pastes Limit* </label>
													<input type="number" class="form-control" name="recent_pastes_limit" placeholder="5" value="{{old('recent_pastes_limit',$settings['recent_pastes_limit'])}}">
													<small class="text-muted">Set to 0 to hide Recent pastes widget </small>
												</div>
												<div class="form-group">
													<label>My Recent Pastes Limit* </label>
													<input type="number" class="form-control" name="my_recent_pastes_limit" placeholder="5" value="{{old('my_recent_pastes_limit',$settings['my_recent_pastes_limit'])}}">
													<small class="text-muted">Set to 0 to hide My Recent pastes widget </small>
												</div>
												<div class="form-group">
													<label>Trending Pastes Limit* </label>
													<input type="number" class="form-control" name="trending_pastes_limit" placeholder="5" value="{{old('trending_pastes_limit',$settings['trending_pastes_limit'])}}">
												</div>
												<div class="form-group">
													<label>Daily Pastes Limit for Unauthorized user* </label>
													<input type="number" class="form-control" name="daily_paste_limit_unauth" placeholder="5" value="{{old('daily_paste_limit_unauth',$settings['daily_paste_limit_unauth'])}}">
												</div>
												<div class="form-group">
													<label>Daily Pastes Limit for Authorized user* </label>
													<input type="number" class="form-control" name="daily_paste_limit_auth" placeholder="5" value="{{old('daily_paste_limit_auth',$settings['daily_paste_limit_auth'])}}">
												</div>
												<div class="form-group">
													<label>Paste Time Restriction for Authorized user* </label>
													<input type="number" class="form-control" name="paste_time_restrict_auth" placeholder="60" value="{{old('paste_time_restrict_auth',$settings['paste_time_restrict_auth'])}}">
													<small class="text-muted">in seconds </small>
												</div>
												<div class="form-group">
													<label>Paste Time Restriction for Unauthorized user* </label>
													<input type="number" class="form-control" name="paste_time_restrict_unauth" placeholder="600" value="{{old('paste_time_restrict_unauth',$settings['paste_time_restrict_unauth'])}}">
													<small class="text-muted">in seconds </small>
												</div>
											</div>
										</div>
										<div class="form-group mb-4">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="advertisement" role="tabpanel" aria-labelledby="advertisement-tab">
									<form method="post">
										<input type="hidden" name="type" value="advertisement">
										@csrf
										<div class="form-group">
											<label>Ad Blocks(on/off) </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="ad1" name="ad" value="1" @if($settings['ad'] == 1) checked @endif>
												<label class="custom-control-label" for="ad1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="ad0" name="ad" value="0" @if($settings['ad'] == 0) checked @endif>
												<label class="custom-control-label" for="ad0">Off </label>
											</div>
										</div>
										<div class="form-group">
											<label>Ad Block 1 </label>
											<textarea class="form-control" name="ad1" rows="4">{{old('ad1',html_entity_decode($settings['ad1']))}}</textarea>
										</div>
										<div class="form-group">
											<label>Ad Block 2 </label>
											<textarea class="form-control" name="ad2" rows="4">{{old('ad2',html_entity_decode($settings['ad2']))}}</textarea>
										</div>
										<div class="form-group">
											<label>Ad Block 3 </label>
											<textarea class="form-control" name="ad3" rows="4">{{old('ad3',html_entity_decode($settings['ad3']))}}</textarea>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
									<form method="post" enctype="multipart/form-data">
										<input type="hidden" name="type" value="seo">
										@csrf
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Meta Description </label>
													<textarea class="form-control" name="meta_description">{{old('meta_description',$settings['meta_description'])}}</textarea>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Meta Keywords </label>
													<textarea class="form-control" name="meta_keywords">{{old('meta_keywords',$settings['meta_keywords'])}}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Analytics Code </label>
											<textarea class="form-control" name="analytics_code" placeholder="<script>..</script>">{{old('analytics_code',html_entity_decode($settings['analytics_code']))}}</textarea>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Header Code </label>
													<textarea class="form-control" name="header_code" placeholder="<script>..</script>">{{old('header_code',html_entity_decode($settings['header_code']))}}</textarea>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Footer Code </label>
													<textarea class="form-control" name="footer_code" placeholder="<script>..</script>">{{old('footer_code',html_entity_decode($settings['footer_code']))}}</textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Site Image </label> <br />
											@if(!empty($settings['site_image']))
												<img src="{{url($settings['site_image'])}}" class="bg-dark" height="32">@endif
											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text" id="inputGroupFileAddon03">Change Image </span>
												</div>
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="site_image" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03">
													<label class="custom-file-label" for="inputGroupFile03">Choose file </label>
												</div>
											</div>
											<small class="text-muted">Only png, jpg files are allowed, Max File Size: 200kb </small>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
									<form method="post">
										@csrf
										<input type="hidden" name="type" value="comments">
										<div class="form-group">
											<label>Custom Comments(on/off) </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="custom_comments1" name="custom_comments" value="1" @if($settings['custom_comments'] == 1) checked @endif>
												<label class="custom-control-label" for="custom_comments1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="custom_comments0" name="custom_comments" value="0" @if($settings['custom_comments'] == 0) checked @endif>
												<label class="custom-control-label" for="custom_comments0">Off </label>
											</div>
										</div>
										<div class="form-group">
											<label>Disqus Comments(on/off) </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="disqus1" name="disqus" value="1" @if($settings['disqus'] == 1) checked @endif>
												<label class="custom-control-label" for="disqus1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="disqus0" name="disqus" value="0" @if($settings['disqus'] == 0) checked @endif>
												<label class="custom-control-label" for="disqus0">Off </label>
											</div>
										</div>
										<div class="form-group">
											<label>Disqus Code </label>
											<textarea class="form-control" name="disqus_code" rows="4">{!!old('disqus_code',html_entity_decode($settings['disqus_code']))!!}
											</textarea> <small class="text-muted">Get disqus code from
												<a href="https://disqus.com" target="_blank">here </a>. </small></div>
										<div class="form-group mb-4">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="captcha" role="tabpanel" aria-labelledby="captcha-tab">
									<form method="post">
										<input type="hidden" name="type" value="captcha">
										@csrf
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Captcha Type </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha_type1" name="captcha_type" value="1" @if($settings['captcha_type'] == 1) checked @endif>
														<label class="custom-control-label" for="captcha_type1">Invisible Recaptcha </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha_type0" name="captcha_type" value="2" @if($settings['captcha_type'] == 2) checked @endif>
														<label class="custom-control-label" for="captcha_type0">Custom Captcha </label>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Invisible Recaptcha(on/off) </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha1" name="captcha" value="1" @if($settings['captcha'] == 1) checked @endif>
														<label class="custom-control-label" for="captcha1">On </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha0" name="captcha" value="0" @if($settings['captcha'] == 0) checked @endif>
														<label class="custom-control-label" for="captcha0">Off </label>
													</div>
													<p>
														<small class="text-muted">How to get Invisible Recaptcha SiteKey & SecretKey?
															<a class="blue-text" data-toggle="modal" data-target="#sideModal" data-backdrop="false">click here </a>
														</small></p>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Custom Captcha Style </label>
													@php $selected = old('custom_captcha_style',$settings['custom_captcha_style']); @endphp
													<select class="form-control" name="custom_captcha_style">
														<option value="default" @if($selected == 'default') selected @endif>Default</option>
														<option value="math" @if($selected == 'math') selected @endif>Math</option>
														<option value="flat" @if($selected == 'flat') selected @endif>Flat</option>
														<option value="mini" @if($selected == 'mini') selected @endif>Mini</option>
														<option value="inverse" @if($selected == 'inverse') selected @endif>Inverse</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Captcha For Verified Users </label> <br />
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha_for_verified_users1" name="captcha_for_verified_users" value="1" @if($settings['captcha_for_verified_users'] == 1) checked @endif>
														<label class="custom-control-label" for="captcha_for_verified_users1">Yes </label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" class="custom-control-input" id="captcha_for_verified_users0" name="captcha_for_verified_users" value="0" @if($settings['captcha_for_verified_users'] == 0) checked @endif>
														<label class="custom-control-label" for="captcha_for_verified_users0">No </label>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Invisible Recaptcha SiteKey </label>
													<input type="text" class="form-control" name="captcha_site_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_site_key',$settings['captcha_site_key'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Invisible Recaptcha SecretKey </label>
													<input type="text" class="form-control" name="captcha_secret_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_secret_key',$settings['captcha_secret_key'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="social_auth" role="tabpanel" aria-labelledby="social_auth-tab">
									<form method="post">
										@csrf
										<input type="hidden" name="type" value="social_auth">
										<div class="form-group">
											<label>Facebook App ID</label>
											<input type="text" name="facebook_app_id" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('facebook_app_id',$settings['facebook_app_id'])}}">
										</div>
										<div class="form-group">
											<label>Login With Facebook </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_facebook1" name="social_login_facebook" value="1" @if($settings['social_login_facebook'] == 1) checked @endif>
												<label class="custom-control-label" for="social_login_facebook1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_facebook2" name="social_login_facebook" value="0" @if($settings['social_login_facebook'] == 0) checked @endif>
												<label class="custom-control-label" for="social_login_facebook2">Off </label>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>FACEBOOK CLIENT ID </label>
													<input type="text" class="form-control" name="FACEBOOK_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('FACEBOOK_CLIENT_ID',$settings['FACEBOOK_CLIENT_ID'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>FACEBOOK CLIENT SECRET </label>
													<input type="text" class="form-control" name="FACEBOOK_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('FACEBOOK_CLIENT_SECRET',$settings['FACEBOOK_CLIENT_SECRET'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Login With Twiiter </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_twitter1" name="social_login_twitter" value="1" @if($settings['social_login_twitter'] == 1) checked @endif>
												<label class="custom-control-label" for="social_login_twitter1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_twitter2" name="social_login_twitter" value="0" @if($settings['social_login_twitter'] == 0) checked @endif>
												<label class="custom-control-label" for="social_login_twitter2">Off </label>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>TWITTER CLIENT ID </label>
													<input type="text" class="form-control" name="TWITTER_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('TWITTER_CLIENT_ID',$settings['TWITTER_CLIENT_ID'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>TWITTER CLIENT SECRET </label>
													<input type="text" class="form-control" name="TWITTER_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('TWITTER_CLIENT_SECRET',$settings['TWITTER_CLIENT_SECRET'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>Login With Google </label> <br />
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_google1" name="social_login_google" value="1" @if($settings['social_login_google'] == 1) checked @endif>
												<label class="custom-control-label" for="social_login_google1">On </label>
											</div>
											<div class="custom-control custom-radio custom-control-inline">
												<input type="radio" class="custom-control-input" id="social_login_google2" name="social_login_google" value="0" @if($settings['social_login_google'] == 0) checked @endif>
												<label class="custom-control-label" for="social_login_google2">Off </label>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>GOOGLE CLIENT ID </label>
													<input type="text" class="form-control" name="GOOGLE_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('GOOGLE_CLIENT_ID',$settings['GOOGLE_CLIENT_ID'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>GOOGLE CLIENT SECRET </label>
													<input type="text" class="form-control" name="GOOGLE_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('GOOGLE_CLIENT_SECRET',$settings['GOOGLE_CLIENT_SECRET'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
									<form method="post">
										<input type="hidden" name="type" value="mail">
										@csrf
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Driver* </label>
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
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Encryption </label>
													<input type="text" class="form-control" name="mail_encryption" placeholder="ssl/tls" value="{{old('mail_encryption',$settings['mail_encryption'])}}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Host </label>
													<input type="text" class="form-control" name="mail_host" placeholder="smtp.mail.io" value="{{old('mail_host',$settings['mail_host'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Port </label>
													<input type="text" class="form-control" name="mail_port" placeholder="587" value="{{old('mail_port',$settings['mail_port'])}}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Username </label>
													<input type="text" class="form-control" name="mail_username" value="{{old('mail_username',$settings['mail_username'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail Password </label>
													<input type="password" class="form-control" name="mail_password" value="{{old('mail_password',$settings['mail_password'])}}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail From Address </label>
													<input type="text" class="form-control" name="mail_from_address" placeholder="noreply@example.com" value="{{old('mail_from_address',$settings['mail_from_address'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Mail From Name </label>
													<input type="text" class="form-control" name="mail_from_name" placeholder="PasteShr" value="{{old('mail_from_name',$settings['mail_from_name'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
								<div class="tab-pane fade" id="social_links" role="tabpanel" aria-labelledby="social_links-tab">
									<form method="post">
										<input type="hidden" name="type" value="social_links">
										@csrf
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Facebook* </label>
													<input type="text" class="form-control" name="social_fb" placeholder="http://facebook.com/username" value="{{old('social_fb',$settings['social_fb'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Twitter* </label>
													<input type="text" class="form-control" name="social_tw" placeholder="http://twitter.com/@username" value="{{old('social_tw',$settings['social_tw'])}}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Google Plus* </label>
													<input type="text" class="form-control" name="social_gp" placeholder="http://plus.google.com/username" value="{{old('social_gp',$settings['social_gp'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>LinkedIn* </label>
													<input type="text" class="form-control" name="social_lin" placeholder="http://linkedin.com/username" value="{{old('social_lin',$settings['social_lin'])}}">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Pinterest* </label>
													<input type="text" class="form-control" name="social_pin" placeholder="http://pinterest.com/username" value="{{old('social_pin',$settings['social_pin'])}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Instagram* </label>
													<input type="text" class="form-control" name="social_insta" placeholder="http://instagram.com/username" value="{{old('social_insta',$settings['social_insta'])}}">
												</div>
											</div>
										</div>
										<div class="form-group">
											<button class="btn btn-success" type="submit">Save</button>
										</div>
									</form>
								</div>
							</div>
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
					<p class="heading lead">Invisible Recaptcha </p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="white-text">&times; </span></button>
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
				<div class="modal-footer justify-content-center">
					<a role="button" class="btn btn-info" href="https://www.google.com/recaptcha" target="_blank">Get it now
						<i class="fa fa-diamond ml-1"> </i> </a>
					<a role="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">No, thanks </a>
				</div>
			</div>
			<!--/.Content-->
		</div>
	</div>
	<!-- Side Modal Top Right Success-->
@stop