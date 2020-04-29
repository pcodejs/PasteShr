<div class="card mb-3">
	<div class="card-header text-center">
		<strong>{{__('My Account')}}</strong>
	</div>
	<div class="card-body p-0">
		<ul class="list-group list-group-flush text-center">
			<li class="list-group-item">
				<a href="{{route('user.dashboard')}}"><i class="fa fa-dashboard blue-grey-text small"></i> {{__('Dashboard')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('user.pastes')}}"><i class="fa fa-paste blue-grey-text small"></i> {{__('My Pastes')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('user.paste.settings')}}"><i class="fa fa-cogs blue-grey-text small"></i> {{__('Paste Settings')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('profile.edit')}}"><i class="fa fa-user-circle-o blue-grey-text small"></i> {{__('Edit Profile')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('user.backup')}}"><i class="fa fa-hdd-o blue-grey-text small"></i> {{__('Backup')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('profile.delete')}}"><i class="fa fa-trash blue-grey-text small"></i> {{__('Delete Account')}}</a>
			</li>
			<li class="list-group-item">
				<a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out blue-grey-text small"></i> {{__('Logout')}}</a>
			</li>
		</ul>
	</div>
</div>