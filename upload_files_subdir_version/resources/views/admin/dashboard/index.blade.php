@extends('admin.layouts.default')

@section('after_scripts') 
<script type="text/javascript">
        //Syntax pie
        var ctxP = document.getElementById("syntaxPie").getContext('2d');
        var syntax_inactive = '{{$syntax_inactive}}';
        var syntax_active = '{{$syntax_active}}';
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Inactive", "Active"],
                datasets: [{
                    data: [syntax_inactive, syntax_active],
                    backgroundColor: ["#F7464A", "#46BFBD"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        });    

        //Page pie
        var ctxP = document.getElementById("pageChart").getContext('2d');
        var pages_inactive = '{{$pages_inactive}}';
        var pages_active = '{{$pages_active}}';
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Inactive", "Active"],
                datasets: [{
                    data: [pages_inactive, pages_active],
                    backgroundColor: ["#F7464A", "#46BFBD"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        });    


        //Syntax pie
        var ctxP = document.getElementById("pasteChart").getContext('2d');
        var paste_public = '{{$paste_public}}';
        var paste_unlisted = '{{$paste_unlisted}}';
        var paste_private = '{{$paste_private}}';
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Private", "Public", "Unlisted"],
                datasets: [{
                    data: [paste_private, paste_public, paste_unlisted],
                    backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        });          

        //Syntax pie
        var ctxP = document.getElementById("userChart").getContext('2d');
        var user_active = '{{$user_active}}';
        var user_inactive = '{{$user_inactive}}';
        var user_banned = '{{$user_banned}}';
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Banned", "Active", "Inactive"],
                datasets: [{
                    data: [user_banned, user_active, user_inactive],
                    backgroundColor: ["#F7464A", "#46BFBD", "#949FB1"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#A8B3C5"]
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        });      
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
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <span>{{$page_title}}</span> </h4>
        <div>
          <a href="http://market.ecodevs.com/downloads/category/plugins/" target="_blank" class="btn btn-sm btn-warning">
              <i class="fa fa-plug"> </i> Plug-Ins </a>
        </div>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Section: Classic admin cards-->
    <section> 
      
      <!--Grid row-->
      <div class="row"> 
        
        <!--Grid column-->
        <div class="col-xl-3 col-md-6 mb-4"> 
          
          <!--Card Success-->
          <div class="card classic-admin-card primary-color">
            <div class="card-body">
              <div class="pull-right"> <i class="fa fa-code fa-4x"></i> </div>
              <p class="white-text">Syntax Languages</p>
              <h3>{{\App\Models\Syntax::count()}}</h3>
            </div>
            <div class="card-body"> <a href="{{url('admin/syntax-languages')}}" class="text-white">View more</a> </div>
          </div>
          <!--/.Card Success--> 
          
        </div>
        <!--Grid column--> 
        
        <!--Grid column-->
        <div class="col-xl-3 col-md-6 mb-4"> 
          
          <!--Card Default-->
          <div class="card classic-admin-card warning-color">
            <div class="card-body">
              <div class="pull-right"> <i class="fa fa-paste fa-4x"></i> </div>
              <p class="white-text">Pastes</p>
              <h3>{{\App\Models\Paste::count()}}</h3>
            </div>
            <div class="card-body"> <a href="{{url('admin/pastes')}}" class="text-white">View more</a> </div>
          </div>
          <!--/.Card Default--> 
          
        </div>
        <!--Grid column--> 
        
        <!--Grid column-->
        <div class="col-xl-3 col-md-6 mb-4"> 
          
          <!--Card Blue-->
          <div class="card classic-admin-card light-blue lighten-1">
            <div class="card-body">
              <div class="pull-right"> <i class="fa fa-users fa-4x"></i> </div>
              <p class="white-text">Users</p>
              <h3>{{\App\User::count()}}</h3>
            </div>
            <div class="card-body"> <a href="{{url('admin/users')}}" class="text-white">View more</a> </div>
          </div>
          <!--/.Card Blue--> 
          
        </div>
        <!--Grid column--> 
        
        <!--Grid column-->
        <div class="col-xl-3 col-md-6 mb-4"> 
          
          <!--Card Purple-->
          <div class="card classic-admin-card red accent-2">
            <div class="card-body">
              <div class="pull-right"> <i class="fa fa-flag fa-4x"></i> </div>
              <p class="white-text">Reported Pastes</p>
              <h3>
              {{\App\Models\Report::count()}}
              </h3d>
            </div>
            <div class="card-body"> <a href="{{url('admin/reported-pastes')}}" class="text-white">View more</a> </div>
          </div>
          <!--/.Card Purple--> 
          
        </div>
        <!--Grid column--> 
        
      </div>
      <!--Grid row--> 
      
    </section>
    <!--Section: Classic admin cards--> 
    
    <!--Grid row-->
    <div class="row "> 
      
      <!--Grid column-->
      <div class="col-md-3 mb-4"> 
        
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header text-center"> Syntax Languages </div>
          
          <!--Card content-->
          <div class="card-body">
            <canvas id="syntaxPie"></canvas>
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
      <!--Grid column--> 
      
      <!--Grid column-->
      <div class="col-md-3 mb-4"> 
        
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header text-center"> Pastes </div>
          
          <!--Card content-->
          <div class="card-body">
            <canvas id="pasteChart"></canvas>
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
      <!--Grid column--> 
      
      <!--Grid column-->
      <div class="col-md-3 mb-4"> 
        
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header text-center"> Users </div>
          
          <!--Card content-->
          <div class="card-body">
            <canvas id="userChart"></canvas>
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
      <!--Grid column--> 
      
      <!--Grid column-->
      <div class="col-md-3 mb-4"> 
        
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header text-center"> Pages </div>
          
          <!--Card content-->
          <div class="card-body">
            <canvas id="pageChart"></canvas>
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
      <!--Grid column--> 
      
    </div>
    <!--Grid row-->
    
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"> Recently Joined Members </div>
          <div class="card-body">
            <ul style="list-style: none;margin: 0;padding: 0;">
              @forelse($users as $user)
              <li class="col-md-2 col-sm-6" style="float: left;padding: 10px;text-align: center;"> <img src="{{$user->avatar}}" class="rounded-circle z-depth-1-half avatar-pic mb-1" height="80"><br/>
                <a class="justify-content-center" href="{{url('admin/users/'.$user->id.'/edit')}}">{{$user->name}}</a>
                <p><small class="text-muted">{{$user->created_ago}}</small></p>
              </li>
              @empty
              <p>No results</p>
              @endforelse
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<!--Main layout--> 
@stop