@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Menu->Circular/Notices</h4>
            </div>
          </div>
      </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
           @include('layouts.massage') 
           <!-- Vertical form options -->
              <div class="panel panel-flat">
                  <div class="panel-heading">
                    @can('notice-create')
                   <a href="{{ url('/academics/notice-create')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Circular/Notices</a>
                    @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">
                    <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'>
                       <thead class="thead-dark">
                          <tr role="row">
                            <th>Id</th>
                            <th>Session</th>
                           <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th >Created at</th>
                            <th >Action</th>
                          </tr>
                       </thead>
                       
                        <tfoot class="thead-dark">
                       <tr role="row">
                            <th>Id</th>
                            <th>Session</th>
                          <th>Title</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th >Created at</th>
                            <th >Action</th>
                          </tr>
                </tfoot>
                    </table>
                  </div>
         </div>
  
</div>
@endsection
@section('script')   
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
 <script>
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
          fixedHeader: {
            header: true,
            footer: true
        },
        "stripeClasses": [ 'odd-row', 'even-row' ],
           processing: true,
           serverSide: true,

           ajax: "{{ url('academics/noticedata') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'session_name', name: 'session_id' },
                    { data: 'title', name: 'title' },
                    { data: 'priority', name: 'priority' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                   ],
            columnDefs: [
                    {
                      "render": function(data, type, row) {
                          if (row.status==0) {
                              return '<span class="label label-success">Active</span>';
                          }else {
                              return '<span class="label label-default">Inactive</span>';
                          }
                       }, "targets": [4]
                    },
                    {
                      "render": function(data, type, row) {
                          if(row.priority==0) {
                              return '<span class="label label-success">Normal</span>';
                          }else if(row.priority==1) {
                              return '<span class="label label-danger">High</span>';
                          }else {
                              return '<span class="label label-default">Low</span>';
                          }
                       }, "targets": [3]
                    }
          ]
        });

     });
  </script>              
@endsection







