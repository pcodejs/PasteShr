@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5">
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> 
          <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> 
          <a href="{{url('admin/syntax-languages')}}">{{$page_title}}</a> <span>/</span> 
          <a href="{{$syntax->url}}" target="_blank">{{$syntax->name}}</a> <span>/</span> 
          <span>Edit</span> 
        </h4>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row "> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} Edit </div>
          
          <!--Card content-->
          <div class="card-body">
            <form method="post">
              @csrf
              <div class="form-group col-md-6">
                <label>Name</label>
                <input type="text" class="form-control" name="name" placeholder="Syntax Name" value="{{old('name',$syntax->name)}}">
              </div>
              <div class="form-group col-md-6">
                <label>Extension</label>
                <input type="text" class="form-control" name="extension" placeholder="Extension [optional]" value="{{old('extension',$syntax->extension)}}">
              </div>
              <div class="form-group col-md-6">
                <label>Popular</label>
                @php
                $selected = old('popular',$syntax->popular);
                @endphp
                <select class="form-control" name="popular">
                  <option value="1" @if($selected == 1) selected @endif>Yes</option>
                  <option value="0" @if($selected == 0) selected @endif>No</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Active</label>
                @php
                $selected = old('active',$syntax->active);
                @endphp
                <select class="form-control" name="active">
                  <option value="1" @if($selected == 1) selected @endif>Yes</option>
                  <option value="0" @if($selected == 0) selected @endif>No</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{url('admin/syntax-languages')}}" class="btn btn-default">Cancel</a> </div>
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