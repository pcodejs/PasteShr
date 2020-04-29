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
                <label class="font-weight-bold">New Paste</label>
                <textarea name="content" class="form-control" rows="10">{{old('content')}}</textarea>
              </div>
              <h5>Paste Settings</h5>
              <hr class="extra-margin" />
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group pb-2">
                    <label>Syntax Highlighting : <small class="text-muted">[Optional]</small></label>
                    @php $selected = old('syntax'); @endphp
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
                    <label>Paste Expiration : <small class="text-muted">[Optional]</small></label>
                    @php $selected = old('expire'); @endphp
                    <select class="form-control" name="expire">
                      <option value="N" @if($selected == 'N') selected @endif>Never</option>
                      <option value="SD" @if($selected == 'SD') selected @endif>Self Destroy</option>
                      <option value="10M" @if($selected == '10M') selected @endif>10 Minutes</option>
                      <option value="1H" @if($selected == '1H') selected @endif>1 Hour</option>
                      <option value="1D" @if($selected == '1D') selected @endif>1 Day</option>
                      <option value="1W" @if($selected == '1W') selected @endif>1 Week</option>
                      <option value="2W" @if($selected == '2W') selected @endif>2 Weeks</option>
                      <option value="1M" @if($selected == '1M') selected @endif>1 Month</option>
                      <option value="6M" @if($selected == '6M') selected @endif>6 Months</option>
                      <option value="1Y" @if($selected == '1Y') selected @endif>1 Year</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Paste Status : <small class="text-muted">[Optional]</small></label>
                    @php $selected = old('status'); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>Public</option>
                      <option value="2" @if($selected == 2) selected @endif>Unlisted</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      Private (members only)
                      </option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Paste Title : <small class="text-muted">[Optional]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="Paste Title" value="{{old('title')}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Password : <small class="text-muted">[Optional]</small></label>
                    <input type="text" name="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="encrypted">
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