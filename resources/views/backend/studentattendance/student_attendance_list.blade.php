@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Student Attendance List ({{$sessionName}}->{{$className}})</h4>
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
                    @can('student-attendance')
                    <?php
                       $sessionId= base64_encode($sessionIds);
                       $sectionId= base64_encode($sectionId);
                    ?>
                   <a href='{{ url("/attendance/student-attendance/{$sessionId}/{$classSetupId}/{$sectionId}")}}' class="btn btn-primary"><i class=" icon-office position-left"></i>Back To Student Register</a>
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
                    <th>Teacher</th>
                    <th>Attendance Date</th>
                    <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
                <tr role="row">
                    <th>Id </th>
                    <th>Name</th>
                    <th>Father's Name</th>
                     <th>Mobile</th>
                    <th>Teacher</th>
                    <th>Attendance Date</th>
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

           ajax: '{{ url("attendance/studentattendancelistdata/{$id}") }}',
           columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                    { data: 'student_name'},
                    { data: 'father_name' },
                    { data: 'father_mobile_no'},
                    { data: 'employee_name'},
                    { data: 'attendeance_date' },
                    
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
