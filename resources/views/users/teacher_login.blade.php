@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee/Teacher</span>->Menu->Teacher Login List</h4>
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
                    @can('teacher-login-create')
                   <a href="{{ url('teacher-login-create')}}" class="btn btn-primary"><i class="icon-user-plus position-left"></i>Create Teacher Login</a>
                    @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                        <li><a data-action="collapse"></a></li>
                        <li><a data-action="close"></a></li>
                      </ul>
                      </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered hover compact" id="laravel_datatable" data-order='[[0, "desc" ]]'>
                        <thead class="thead-dark">
                          <tr role="row">
                             <th>Id</th>
                             <th>Employee Type</th>
                             <th>Name</th>
                             <th>Email (Username)</th>
                             <th>Roles</th>
                              <th>Status</th>
                             <th >Created at</th>
                             <th >Action</th>
                          </tr>
                        </thead>
                        <tfoot class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Employee Type</th>
                             <th>Name</th>
                             <th>Email (Username)</th>
                             <th>Roles</th>
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
           processing: true,
           serverSide: true,

           ajax: "{{ url('teacherlogindata') }}",
           columns: [
                    { data: 'id', name: 'id' },
                     { data: 'user_type', name: 'user_type' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'roles', name: 'roles', orderable: false, searchable: false },
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
                       }, "targets": [5]
                    },
                    {
                      "render": function(data, type, row) {
                          if (row.user_type==4) {
                              return 'Teacher';
                          } else if(row.user_type==1){
                              return 'Staff & Other';
                          } 
                       }, "targets": [1]
                  }
          ]
        });
     });
  </script>               
@endsection


