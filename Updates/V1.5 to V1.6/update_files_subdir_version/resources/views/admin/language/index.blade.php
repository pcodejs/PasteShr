@extends('admin.layouts.default')

@section('after_styles')
<link rel="stylesheet" type="text/css" href="{{url('css/addons/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
@stop

@section('after_scripts') 
<script type="text/javascript" src="{{url('js/addons/datatables.min.js')}}"></script> 
<script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script> 
<script>
$(function () {
 
   var table =  $('#example1').DataTable({
      /*  order: [[ 0, 'desc' ]],*/
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[ 0, 'desc' ]],            
        ajax: '{{route("site_languages.get")}}',
        columns: [
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

});
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
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">Admin</a> <span>/</span> <span>{{$page_title}}</span> </h4>
        <a href="{{url('admin/site-languages/create')}}" class="btn btn-sm btn-primary">Create</a> </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row wow fadeIn"> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} </div>
          
          <!--Card content-->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Language Code</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Language Code</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
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