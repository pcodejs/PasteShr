<header>
	<!--Navbar-->
	<nav class="navbar navbar-expand-lg @if(config('settings.navbar') == 'fixed') fixed-top @endif navbar-dark">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
			</button>
			<a class="navbar-brand" href="{{url('/')}}">@if(!empty(config('settings.site_logo')))
					<img src="{{url(config('settings.site_logo'))}}" height="32" alt="{{config('settings.site_name')}}"> @else{{config('settings.site_name')}}@endif
			</a> @if(Auth::check())
				<ul class="navbar-nav d-md-none d-lg-none">
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false" title="{{Auth::user()->name}}">
							<img src="{{Auth::user()->avatar}}" class="rounded-circle z-depth-0"
									alt="avatar image" style="height: 32px;"> </a>
						<div class="dropdown-menu dropdown-menu-right dropdown-secondary"
								aria-labelledby="navbarDropdownMenuLink-55"> @if(Auth::user()->isAdmin())
								<a class="dropdown-item" href="{{url('admin/dashboard')}}"><i class="fa fa-user-secret blue-grey-text"></i> {{ __('Admin Panel')}}
								</a>
								<div class="dropdown-divider"></div>
							@endif
							<a class="dropdown-item" href="{{route('user.dashboard')}}"><i class="fa fa-dashboard blue-grey-text"></i> {{ __('My Dashboard')}}
							</a>
							<a class="dropdown-item" href="{{route('user.pastes')}}"><i class="fa fa-list-alt blue-grey-text"></i> {{ __('My Pastes')}}
							</a>
							<a class="dropdown-item" href="{{route('profile.edit')}}"><i class="fa fa-user-circle-o blue-grey-text"></i> {{ __('Edit Profile')}}
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out blue-grey-text"></i> {{ __('Logout')}}
							</a></div>
					</li>
				</ul>
			@else
				<ul class="navbar-nav d-md-none d-lg-none">
					<li class="nav-item avatar dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false" title="{{ __('Guest')}}">
							<img src="{{url('img/default-avatar.png')}}" class="rounded-circle z-depth-0"
									alt="{{ __('Guest') }}" style="height: 32px;"> </a>
						<div class="dropdown-menu dropdown-menu-right dropdown-secondary"
								aria-labelledby="navbarDropdownMenuLink-55">
							<a class="dropdown-item" href="{{route('register')}}"><i class="fa fa-user-plus blue-grey-text"></i> {{ __('Sign up')}}
							</a>
							<a class="dropdown-item" href="{{route('login')}}"><i class="fa fa-sign-in blue-grey-text"></i> {{ __('Login')}}
							</a></div>
					</li>
				</ul>
			@endif
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<a class="btn btn-success btn-sm new_paste" href="{{url('/')}}"><i class="fa fa-plus"></i> {{ __('New paste')}}
				</a>
				<ul class="navbar-nav mr-auto">
					<li class="nav-item @if(Route::currentRouteName() == 'home') active @endif">
						<a class="nav-link" href="{{url('/')}}">{{ __('Home')}}</a></li>
					@if(config('settings.trending_page') == 1)
						<li class="nav-item @if(Route::currentRouteName() == 'trending') active @endif">
							<a class="nav-link" href="{{route('trending')}}">{{ __('Trending')}}</a></li>
					@endif
					@if(config('settings.archive_page') == 1)
						<li class="nav-item @if(Route::currentRouteName() == 'archive' || Route::currentRouteName() == 'archive.list') active @endif">
							<a class="nav-link" href="{{route('archive.list')}}">{{ __('Archive')}}</a></li>
					@endif
				</ul>
				<ul class="navbar-nav mr-right">
					<li class="nav-item btn-group">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{App::getLocale()}} </a>
						<div class="dropdown-menu dropdown-primary mw-0 small" aria-labelledby="navbarDropdownMenuLink" style="min-width: 5rem !important;font-size:0.8rem !important;"> @forelse($locales as $lang)
								<a class="dropdown-item pt-0 pb-0 pl-20 pr-0" href="{{url('lang/'.$lang->code)}}" style="font-size: 0.8rem;">{{$lang->name}}</a> @endforeach
						</div>
					</li>
					@if(Auth::check())
						<li class="nav-item avatar dropdown d-none d-sm-block">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false" title="{{Auth::user()->name}}">
								<img src="{{Auth::user()->avatar}}" class="rounded-circle z-depth-0"
										alt="avatar image" style="height: 32px;"> </a>
							<div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary"
									aria-labelledby="navbarDropdownMenuLink-55"> @if(Auth::user()->isAdmin())
									<a class="dropdown-item" href="{{url('admin/dashboard')}}"><i class="fa fa-user-secret blue-grey-text"></i> {{ __('Admin Panel')}}
									</a>
									<div class="dropdown-divider"></div>
								@endif
								<a class="dropdown-item" href="{{route('user.dashboard')}}"><i class="fa fa-dashboard blue-grey-text"></i> {{ __('My Dashboard')}}
								</a>
								<a class="dropdown-item" href="{{route('user.pastes')}}"><i class="fa fa-list-alt blue-grey-text"></i> {{ __('My Pastes')}}
								</a>
								<a class="dropdown-item" href="{{route('profile.edit')}}"><i class="fa fa-user-circle-o blue-grey-text"></i> {{ __('Edit Profile')}}
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out blue-grey-text"></i> {{ __('Logout')}}
								</a></div>
						</li>
					@else
						<li class="nav-item avatar dropdown d-none d-sm-block">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-55" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false" title="{{ __('Guest')}}">
								<img src="{{url('img/default-avatar.png')}}" class="rounded-circle z-depth-0"
										alt="avatar image" style="height: 32px;"> </a>
							<div class="dropdown-menu dropdown-menu-lg-right dropdown-secondary"
									aria-labelledby="navbarDropdownMenuLink-55">
								<a class="dropdown-item" href="{{route('register')}}"><i class="fa fa-user-plus blue-grey-text"></i> {{ __('Sign up')}}
								</a>
								<a class="dropdown-item" href="{{route('login')}}"><i class="fa fa-sign-in blue-grey-text"></i> {{ __('Login')}}
								</a></div>
						</li>
					@endif
				</ul>
				@if(config('settings.search_page') == 1)
					<form class="form-inline" method="get" action="{{route('search')}}">
						<div class="md-form my-0">
							<input class="form-control mr-sm-2" name="keyword" type="text" placeholder="{{ __('Search')}}" aria-label="Search">
						</div>
					</form>
				@endif
			</div>
		</div>
	</nav>
	<!--/.Navbar-->
	@if(Auth::check())
		<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	@endif </header>
