@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5">
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <a href="{{url('admin/site-languages')}}">{{$page_title}}</a> <span>/</span> <span>Translations</span> </h4>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row wow"> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} Translations </div>
          
          <!--Card content-->
          <div class="card-body">
            <form method="post">
              @csrf
                <div class="row"> 
                    <div class="col-md-6">
                        <b>English</b>
                    </div>
                    <div class="col-md-6">
                      <b>{{$language->name}}</b>
                    </div>
                </div>

                @foreach($default_words as $dw)
                <div class="row">
                  <div class="form-group col-md-6">
                    <textarea class="form-control" rows="2" disabled>{{$dw}}</textarea>
                  </div>
                  <div class="form-group col-md-6">
                    <textarea class="form-control" placeholder="{{$language->name}} Translation" name="{{$dw}}">@if(isset($words->$dw)){{$words->$dw}}@else{{$dw}}@endif</textarea>
                  </div>
                </div>
                @endforeach
            
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{url('admin/site-languages')}}" class="btn btn-default">Cancel</a> </div>
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