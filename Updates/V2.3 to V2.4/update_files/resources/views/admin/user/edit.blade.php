@extends('admin.layouts.default')

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
	<!--Main layout-->
	<main class="pt-5 mx-lg-5">
		<div class="container mt-5">
			<!-- Heading -->
			<div class="card mb-4 ">
				<!--Card content-->
				<div class="card-body d-sm-flex justify-content-between">
					<h4 class="mb-2 mb-sm-0 pt-1"><a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span>
						<a href="{{url('admin/users')}}">{{$page_title}}</a> <span>/</span> <span>Edit</span></h4>
				</div>
			</div>
			<!-- Heading -->
			<!--Grid row-->
			<div class="row">
				<!--Grid column-->
				<div class="col-md-12 mb-4"> @include('admin.includes.messages')
				<!--Card-->
					<div class="card mb-4">
						<!-- Card header -->
						<div class="card-header"> {{$page_title}} Edit</div>
						<!--Card content-->
						<div class="card-body">
							<form method="post" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Username*</label>
											<input type="text" class="form-control" name="username" placeholder="Userame" value="{{old('username',$user->name)}}">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Email*</label>
											<input type="email" class="form-control" name="email" placeholder="Email" value="{{old('email',$user->email)}}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Role*</label>
											@php $selected = old('role',$user->role); @endphp
											<select class="form-control" name="role">
												<option value="2" @if($selected == '2') selected @endif>Registered User</option>
												<option value="1" @if($selected == '1') selected @endif>Administrator</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Status*</label>
											@php $selected = old('active',$user->active); @endphp
											<select class="form-control" name="active">
												<option value="1" @if($selected == '1') selected @endif>Active</option>
												<option value="0" @if($selected == '0') selected @endif>Inactive</option>
												<option value="2" @if($selected == '2') selected @endif>Banned</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Avatar</label> <br />
									<img src="{{$user->avatar}}" id="avatar" class="rounded-circle z-depth-1-half avatar-pic mb-3" height="80" width="80">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01" onchange="loadFile(this,'avatar')" aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">Choose file (jpg,png), Max 1MB</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>About Me*</label>
									<textarea class="form-control" name="about">{{old('about',$user->about)}}</textarea>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Facebook Link*</label>
											<input type="text" class="form-control" name="fb" placeholder="#" value="{{old('fb',$user->fb)}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Twitter Link*</label>
											<input type="text" class="form-control" name="tw" placeholder="#" value="{{old('tw',$user->tw)}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Google Plus Link*</label>
											<input type="text" class="form-control" name="gp" placeholder="#" value="{{old('gp',$user->gp)}}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control" name="password" placeholder="Password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Confirm Password</label>
											<input type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation">
										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-success" type="submit">Save</button>
									<a href="{{url('admin/users')}}" class="btn btn-default">Cancel</a>
								</div>
							</form>
						</div>
					</div>
					<!--/.Card-->
				</div>
				<!--Grid column-->
			</div>
			<!--Grid row-->
		</div>
	</main>
	<!--Main layout-->
@stop