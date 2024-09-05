@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Students Roll number alloted list</h4>
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
                    @can('roll-number-allotment-list')
                   <a href="{{ url('roll-number-allotment-list')}}" class="btn btn-primary"><i class="icon-calendar position-left"></i>Back to Roll Number Allotment List</a>
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
                     <th>Class</th>
                     <th>Section</th>
                     <th>Roll Number</th>
                     <th>Student Name</th>
                     <th>Father Name</th>
                     <th>Gender</th>
                     <th >Roll No. Allotment Dt.</th>
                     <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
                 <tr role="row">
                     <th>Id</th>
                     <th>Session</th>
                     <th>Class</th>
                     <th>Section</th>
                     <th>Roll Number</th>
                     <th>Student Name</th>
                     <th>Father Name</th>
                     <th>Gender</th>
                     <th >Roll No. Allotment Dt.</th>
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

           ajax: '{{ url("student-list-datatable/{$sessionId}/{$classmapingId}") }}',
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'session_name', name: 'session_name' },
                    { data: 'class_name', name: 'class_id' },
                    { data: 'section_name', name: 'section_name' },
                    { data: 'roll_no', name: 'roll_no' },
                    { data: 'student_name', name: 'student_name' },
                    { data: 'father_name', name: 'father_name' },
                    { data: 'gender', name: 'gender' },
                    { data: 'updated_at', name: 'updated_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                    

                 ],
        columnDefs: [
                  
                  {
                      "render": function(data, type, row) {
                          if (row.gender==0) {
                              return 'Male';
                          } else if(row.gender==1){
                              return 'Female';
                          } else {
                            return 'Other';
                          }
                       }, "targets": [7]
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

