<header> 
  
  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid"> 
      
      <!-- Brand --> 
      <a class="navbar-brand waves-effect" href="{{url('admin/dashboard')}}"> <strong class="blue-text">{{config('settings.site_name')}}</strong> </a> 
      
      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      
      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
        
        <!-- Left -->
        <ul class="navbar-nav mr-auto d-md-none">
          <li class="nav-item @if(Request::segment(2) == 'dashboard') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'syntax-languages') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/syntax-languages')}}"><i class="fa fa-code"></i> Syntax Languages </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'pastes') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/pastes')}}"><i class="fa fa-paste"></i> Pastes </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'reported-pastes') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/reported-pastes')}}"><i class="fa fa-flag"></i>Reported Pastes </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'users') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/users')}}"><i class="fa fa-users"></i> Users </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'pages') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/pages')}}"><i class="fa fa-file"></i> Pages </a> </li>        
        <li class="nav-item @if(Request::segment(2) == 'site-languages') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/site-languages')}}"><i class="fa fa-language"></i> Site Languages </a> </li>            
        <li class="nav-item @if(Request::segment(2) == 'settings') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/settings')}}"><i class="fa fa-cogs"></i> Settings </a> </li>
       
        </ul>
        
        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item btn-group"> <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user"></i> {{Auth::user()->name}} </a>
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink"> <a class="dropdown-item" href="{{url('profile')}}">Edit Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a> </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed"> <a class="logo-wrapper waves-effect"> <img src="{{\Auth::user()->avatar}}" class="rounded-circle z-depth-1-half avatar-pic" alt="avatar" style="height: 130px;max-height: 130px !important;"> </a>
    <div class="list-group list-group-flush"> <a href="{{url('admin/dashboard')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'dashboard') active @endif"> <i class="fa fa-dashboard mr-3"></i>Dashboard </a> <a href="{{url('admin/syntax-languages')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'syntax-languages') active @endif"> <i class="fa fa-code mr-3"></i>Syntax Languages</a> <a href="{{url('admin/pastes')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'pastes') active @endif"> <i class="fa fa-paste mr-3"></i>Pastes</a> <a href="{{url('admin/reported-pastes')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'reported-pastes') active @endif"> <i class="fa fa-flag mr-3"></i>Reported Pastes</a> <a href="{{url('admin/users')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'users') active @endif"> <i class="fa fa-users mr-3"></i>Users</a> <a href="{{url('admin/pages')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'pages') active @endif"> <i class="fa fa-file mr-3"></i>Pages</a> <a href="{{url('admin/site-languages')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'site-languages') active @endif"> <i class="fa fa-language mr-3"></i>Site Languages</a> <a href="{{url('admin/settings')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'settings') active @endif"> <i class="fa fa-cogs mr-3"></i>Settings</a>   <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action waves-effect"> <i class="fa fa-power-off mr-3"></i>Logout</a> </div>
  </div>
  <!-- Sidebar --> 
  
</header>
<!--Main Navigation-->