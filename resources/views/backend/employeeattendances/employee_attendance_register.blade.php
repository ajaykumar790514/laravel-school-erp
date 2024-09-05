@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Employee Attendance Register</h4>
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
                    @can('employee-attendance')
                   <a href="{{ url('/attendance/employee-attendance')}}" class="btn btn-primary"><i class=" icon-user-check position-left"></i>Employee List For Attendance </a>
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
                    <th>Id </th>
                    <th>Session</th>
                    <th>Attendance Taken</th>
                    <th>Attendance Date</th>
                    <th>Attendance Status</th>
                    <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
                 <tr role="row">
                    <th>Id </th>
                    <th>Session</th>
                    <th>Attendance Taken</th>
                    <th>Attendance Date</th>
                    <th>Attendance Status</th>
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

           ajax: '{{ url("attendance/employeeattendanceregisterdata") }}',
           columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                    { data: 'session_name', name: 'session_id' },
                    { data: 'email', name: 'created_by' },
                    { data: 'attendance_dt', name: 'attendance_dt' },
                    { data: 'created_at', name: 'created_at' },
                   {data: 'action', name: 'action', orderable: false, searchable: false}
                   ],
                   columnDefs: [
                  {
                    "render": function ( data, type, full, meta ) {
                        return  meta.row + 1;
                    },  "targets": [0]
                  }
                  
                  
              ],
            
        });

     });
  </script>
  @endsection



