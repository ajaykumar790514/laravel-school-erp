@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Students List</h4>
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
                    @can('classes-register')
                   <a href="{{ url('classes-register')}}" class="btn btn-primary"><i class="icon-calendar position-left"></i>Back to Class Register</a>
                    @endcan
                    <a href='{{ url("export-student-class-wise/{$sessionId}/{$classMapingId}/{$sectionId}")}}' class="btn btn-primary"></i>Download Excel</a>
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
                                 <th>Old/New</th>
                                 <th>Class</th>
                                 <th>Section</th>
                                 <th>Roll Number</th>
                                 <th>Student Name</th>
                                 <th>Aadhar No.</th>
                                 <th>Father Name</th>
                                 <th>Mother's Name</th>
                                 <th >Action</th>
                              </tr>
                           </thead>
               
                            <tfoot class="thead-dark">
                            <tr role="row">
                                 <th>Id</th>
                                 <th>Session</th>
                                 <th>Old/New</th>
                                 <th>Class</th>
                                 <th>Section</th>
                                 <th>Roll Number</th>
                                 <th>Student Name</th>
                                 <th>Aadhar No.</th>
                                 <th>Father Name</th>
                                 <th>Mother's Name</th>
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
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/pnotify.min.js') }}"></script>
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

           ajax: '{{ url("studentregisterdata/{$sessionId}/{$classMapingId}/{$sectionId}") }}',
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'session_name', name: 'session_name' },
                    { data: 'action_type', name: 'action_type' },
                    { data: 'class_name' },
                    { data: 'section_name', name: 'section_name' },
                    { data: 'roll_no', name: 'roll_no' },
                    { data: 'student_name', name: 'student_name' },
                    { data: 'aadhar_No', name: 'aadhar_No' },
                    { data: 'father_name', name: 'father_name' },
                    { data: 'mothers_name', name: 'mothers_name' },
                    {data: 'reg_date', name: 'reg_date', orderable: false, searchable: false}
                    

                 ],
        columnDefs: [
                    {
                      "render": function(data, type, row) {
                          if (row.action_type==0) {
                              return '<span class="label label-success">New</span>';
                          }else {
                              return '<span class="label label-default">Old</span>';
                          }
                       }, "targets": [2]
                    },
              ],
              
        });

     });
</script>                
@endsection



