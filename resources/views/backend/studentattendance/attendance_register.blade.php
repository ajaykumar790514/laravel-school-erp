@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Student Register ({{$sessionName}}->{{$className}}-{{$sectionName}})</h4>
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
                    @can('classes-attendance')
                   <a href="{{ url('/attendance/classes-attendance')}}" class="btn btn-primary"><i class="icon-arrow-left52 position-left"></i>Classes List For Attendance</a>
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
                            <th>Class</th>
                             <th>Section</th>
                            <th>Teacher</th>
                            <th>{{strtoupper("Attendance Date")}}</th>
                            <th>Attendance Status</th>
                            <th >Action</th>
                          </tr>
                       </thead>
                            <tfoot class="thead-dark">
                        <tr role="row">
                            <th>Id</th>
                            <th>Session</th>
                            <th>Class</th>
                             <th>Section</th>
                            <th>Teacher</th>
                            <th>{{strtoupper("Attendance Date")}}</th>
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

           ajax: '{{ url("/attendance/studentattendanceregisterdata/{$sessionIds}/{$classID}/{$sectionID}") }}',
           columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                    { data: 'session_name', name: 'session_id' },
                    { data: 'class_name', name: 'class_maping_id' },
                    { data: 'section_name', name: 'section_maping_id' },
                    { data: 'employee_name', name: 'teacher_id' },
                    { data: 'attendeance_date', name: 'attendeance_date' },
                    { data: 'class_sec_id', name: 'class_sec_id' },
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

