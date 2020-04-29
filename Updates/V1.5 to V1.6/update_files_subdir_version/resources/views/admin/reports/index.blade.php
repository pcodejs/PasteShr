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
        order: [[ 1, 'desc' ]],        
        ajax: '{{route("reports.get")}}',
        columns: [
            {data: 'check', name: 'id', orderable:false, searchable:false, width:'2%'},
            {data: 'id', name: 'id'},
            {data: 'paste', name: 'paste_id',orderable:false, searchable:false},
            {data: 'user', name: 'user_id',orderable:false, searchable:false},
            {data: 'reason', name: 'reason', orderable:false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

$("#check_all").on('click',function(){
    if($('#check_all').is(':checked')){
      $('.check').prop('checked',true);
    }
    else{
      $('.check').prop('checked',false);
    }
});


$('.del_selected').on('click',function(){
  var url = "{{url('admin/reported-pastes/delete-selected')}}";
  var data = { 'ids[]' : []};
  $(".check:checked").each(function() {
      data['ids[]'].push($(this).val());
    });
  $.ajax({
    url: url,
    type: 'POST',
    data : data,
  })
  .done(function(data) {
    if(data == 'success'){
      $("#response").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Reports successfully deleted.</div>');
     /* setTimeout(function(){ 
          window.location.reload();
      }, 2000);*/
      table.ajax.reload();
      $('#check_all').prop('checked',false);
    }
    else{
      $("#response").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No reports selected.</div>');
    }
  });
});

$('.del_selected_pastes').on('click',function(){
  var url = "{{url('admin/pastes/delete-selected')}}";
  var data = { 'ids[]' : []};
  $(".check:checked").each(function() {
      data['ids[]'].push($(this).data('pid'));
    });
  $.ajax({
    url: url,
    type: 'POST',
    data : data,
  })
  .done(function(data) {
    if(data == 'success'){
      $("#response").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Pastes successfully deleted.</div>');
     /* setTimeout(function(){ 
          window.location.reload();
      }, 2000);*/
      table.ajax.reload();
      $('#check_all').prop('checked',false);
    }
    else{
      $("#response").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No pastes selected.</div>');
    }
  });
});

$('table').on('click','.view_report', function(event) {
  event.preventDefault();
  $('#report_reason').html($(this).data('reason'));
  $('#reportModal').modal('toggle');
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
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row wow fadeIn"> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages')
        <div id="response"></div>
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header">
            <h4 class="float-left"> {{$page_title}}</h4>
            
            <!-- Basic dropdown -->
            <button class="btn btn-primary btn-sm dropdown-toggle mr-4 float-right" type="button" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="false">Action</button>
            <div class="dropdown-menu"> <a class="dropdown-item del_selected"><i class="fa fa-trash"></i> Delete Selected Reports</a> <a class="dropdown-item del_selected_pastes"> <i class="fa fa-trash"></i> Delete Selected Pastes</a> </div>
            <!-- Basic dropdown --> 
            
          </div>
          
          <!--Card content-->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><input type="checkbox" id="check_all" class="check_all"></th>
                  <th>ID</th>
                  <th>Paste</th>
                  <th>User</th>
                  <th>Reason</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>ID</th>
                  <th>Paste</th>
                  <th>User</th>
                  <th>Reason</th>
                  <th>Created at</th>
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

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <div id="report_reason"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop