@extends('admin.layouts.default')

@section('after_styles')
<style>
.ck-editor__editable {
    max-height: 400px !important;
    min-height: 300px !important;
}
</style>
@stop

@section('after_scripts') 
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script> 
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script> 
@stop

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 wow fadeIn"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <a href="{{url('admin/pages')}}">{{$page_title}}</a> <span>/</span> <span>Create</span> </h4>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row wow fadeIn"> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} Create </div>
          
          <!--Card content-->
          <div class="card-body">
            <form method="post">
              @csrf
              <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="title" placeholder="Page Title" value="{{old('title')}}">
              </div>
              <div class="form-group">
                <label>Content</label>
                <textarea class="textarea" id="editor" name="content" placeholder="Page content" rows="20">{!!old('content')!!}</textarea>
              </div>
              <div class="form-group">
                <label>Active</label>
                @php
                $selected = old('active');
                @endphp
                <select class="form-control" name="active">
                  <option value="1" @if($selected == 1) selected @endif>Yes</option>
                  <option value="0" @if($selected == 0) selected @endif>No</option>
                </select>
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{url('admin/pages')}}" class="btn btn-default">Cancel</a> </div>
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