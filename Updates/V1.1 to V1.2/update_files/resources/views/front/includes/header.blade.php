<header> 
  
  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container"> <a class="navbar-brand" href="{{url('/')}}">{{config('settings.site_name')}}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent"> <a class="btn btn-success btn-sm" href="{{url('/')}}"><i class="fa fa-plus"></i> {{ __('New paste')}}</a>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item @if(Route::currentRouteName() == 'home') active @endif"> <a class="nav-link" href="{{url('/')}}">{{ __('Home')}}</a> </li>
          <li class="nav-item @if(Route::currentRouteName() == 'archive' || Route::currentRouteName() == 'archive.list') active @endif"> <a class="nav-link" href="{{url('archive')}}">{{ __('Archive')}}</a> </li>
          @if(Auth::check())
          <li class="nav-item btn-group"> <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} </a>
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink"> @if(Auth::user()->isAdmin()) <a class="dropdown-item" href="{{url('admin/dashboard')}}">{{ __('Admin Panel')}}</a>
              <div class="dropdown-divider"></div>
              @endif <a class="dropdown-item" href="{{url('my-pastes')}}">{{ __('My Pastes')}}</a> <a class="dropdown-item" href="{{url('profile')}}">{{ __('Edit Profile')}}</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Logout')}}</a> </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>
          @else
          <li class="nav-item"> <a class="nav-link" href="{{url('register')}}">{{ __('Sign up')}}</a> </li>
          <li class="nav-item"> <a class="nav-link" href="{{url('login')}}">{{ __('Login')}}</a> </li>
          @endif
        </ul>

        <ul class="navbar-nav mr-right">
          <li class="nav-item btn-group"> <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{App::getLocale()}} </a>
            <div class="dropdown-menu dropdown-primary mw-0 small" aria-labelledby="navbarDropdownMenuLink" style="min-width: 5rem !important;font-size:0.8rem !important;">  
              @forelse($locales as $lang)
                <a class="dropdown-item pt-0 pb-0 pl-20 pr-0" href="{{url('lang/'.$lang->code)}}" style="font-size: 0.8rem;">{{$lang->name}}</a> 
              @endforeach
            </div>

          </li>
        </ul>
        <form class="form-inline" method="get" action="{{url('search')}}">
          <div class="md-form my-0">
            <input class="form-control mr-sm-2" name="keyword" type="text" placeholder="Search" aria-label="Search">
          </div>
        </form>
      </div>
    </div>
  </nav>
  <!--/.Navbar--> 
  
</header>
