@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Parents Maodule</span>->Menu->Parents Login List</h4>
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
                    @can('parent-login-create')
                   <a href="{{ url('parents/parent-login-create')}}" class="btn btn-primary"><i class="icon-user-plus position-left"></i>Create Parents Login</a>
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
                             <th>Parent Name</th>
                             <th>Students</th>
                             <th>User</th>
                             <th>Created at</th>
                             <th >Action</th>
                          </tr>
                        </thead>
                        <tfoot class="thead-dark">
                        <tr>
                             <th>Parent Name</th>
                             <th>Students</th>
                             <th>Username</th>
                             <th>Created at</th>
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

           ajax: "{{ url('parents/parentslogindata') }}",
           columns: [
                    { data: 'name', name: 'name' },
                    { data: 'student', name: 'student' },
                    { data: 'email', name: 'email' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                 ],
                 columnDefs: [
                   
          ]
        });
     });
  </script>               
@endsection


