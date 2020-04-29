@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 wow fadeIn"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <a href="{{url('admin/pastes')}}">{{$page_title}}</a> <span>/</span> <span>Edit</span> </h4>
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
          <div class="card-header"> {{$page_title}} Edit </div>
          
          <!--Card content-->
          <div class="card-body">
            <form method="post" action="">
              @csrf
              <div class="form-group">
                <label class="font-weight-bold">Edit Paste</label>
                <textarea name="content" class="form-control" rows="10">{{old('content',$paste->content_f)}}</textarea>
              </div>
              <h5>Paste Settings</h5>
              <hr class="extra-margin" />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group pb-2">
                    <label>Syntax Highlighting : <small class="text-muted">[Optional]</small></label>
                    @php $selected = old('syntax',$paste->syntax); @endphp
                    <select class="form-control select2" name="syntax">
                      <option value="markup">Select</option>
                      <optgroup label="Popular Languages">
                                                        @foreach($popular_syntaxes as $syntax)
                                                        
                      <option value="{{$syntax->slug}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                      
                                                        @endforeach
                                                    </optgroup>
                      <optgroup label="All Languages">
                                                        @foreach($syntaxes as $syntax)
                                                        
                      <option value="{{$syntax->slug}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}</option>
                      
                                                        @endforeach
                                                    </optgroup>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Paste Title : <small class="text-muted">[Optional]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="Paste Title" value="{{old('title',$paste->title)}}">
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Paste Status : <small class="text-muted">[Optional]</small></label>
                    @php $selected = old('status',$paste->status); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>Public</option>
                      <option value="2" @if($selected == 2) selected @endif>Unlisted</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      Private (members only)
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Password : <small class="text-muted">[Optional]</small></label>
                    <input type="text" name="password" class="form-control" placeholder="Password">
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="encrypted" @if($paste->encrypted == 1) checked @endif>
                        <label class="custom-control-label" for="defaultUnchecked">Encrypt Paste</label>
                    </div>
                  </div>
                </div>                
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{url('admin/pastes')}}" class="btn btn-default">Cancel</a> </div>
                </div>
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