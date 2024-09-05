@extends('layouts.admin-theme')
@section('content')

        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Employee Attendance List </h4>
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
                    @can('employee-attendance-register')
                    <a href='{{ url("/attendance/employee-attendance-register")}}' class="btn btn-primary"><i class="icon-user-check position-left"></i>Back To Employee Register</a>
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
                    <th>Name</th>
                    <th>Father's Name</th>
                     <th>Mobile</th>
                    <th>Designation</th>
                    <th>Attendance Date</th>
                    <th>Status</th>
                    <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
                <tr role="row">
                    <th>Id </th>
                    <th>Name</th>
                    <th>Father's Name</th>
                     <th>Mobile</th>
                     <th>Designation</th>
                    <th>Attendance Date</th>
                    <th>Status</th>
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

           ajax: '{{ url("attendance/employeeattendancelistdata/{$id}") }}',
           columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                    { data: 'employee_name'},
                    { data: 'father_husband_name' },
                    { data: 'mobile_whatsapp'},
                    { data: 'designation_name'},
                    { data: 'attendance_dt' },
                    { data: 'status' },
                   {data: 'action', name: 'action', orderable: false, searchable: false}
                   ],
                   columnDefs: [
                   {
                      "render": function(data, type, row) {
                          if (row.status==0) {
                              return '<span class="label bg-success">Present</span>';
                          } else if(row.status==1){
                              return '<span class="label bg-danger">Absent</span>';
                          } else if(row.status==2){
                            return '<span class="label bg-blue">Half Time</span>';
                          } else{
                            return '<span class="label bg-grey">Late</span>';
                          }
                       }, "targets": [6]
                  },
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



