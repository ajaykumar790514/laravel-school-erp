@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
              <div class="page-header-content">
                <div class="page-title">
                  <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Student Admission</h4>
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
                    @can('student-create')
                        <a href="{{ url('student-create')}}" class="btn btn-primary"><i class="icon-calendar position-left"></i>New Student Registration</a>
                    @endcan
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                        </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table  table-bordered table-striped table-hover" id="laravel_datatable" data-order='[[0, "desc" ]]' >
                        <thead class="thead-dark">
                            <tr role="row">
                                 <th>Id</th>
                                 <th>Session</th>
                                 <th>Class</th>
                                 <th>Student Name</th>
                                 <th>Father Name</th>
                                 <th>Mobile</th>
                                 <th>Gender</th>
                                 <th >Reg. Date</th>
                                 <th >Action</th>
                             </tr>
                        </thead>
                            
                        
                        <tfoot class="thead-dark">
                            <tr role="row">
                                 <th>Id</th>
                                 <th>Session</th>
                                 <th>Class</th>
                                 <th>Student Name</th>
                                 <th>Father Name</th>
                                  <th>Mobile</th>
                                 <th>Gender</th>
                                 <th>Reg. Date</th>
                                 <th>Action</th>
                              </tr>
                        </tfoot>
                    </table>
                </div>
         </div>
        </div>
@endsection
@section('script') 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
     $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
       listdata();
        // Data Listing data in ajax formate
        function listdata(){ 
                    $('#laravel_datatable').DataTable({
                         destroy: true,
                         fixedHeader: {
                            header: true,
                            footer: true
                        },
                    "stripeClasses": [ 'odd-row', 'even-row' ],
                       processing: true,
                       serverSide: true,
                       ajax: "{{ url('studentdatatable') }}",
                       columns: [
                                { data: 'id', name: 'id'},
                                { data: 'sessionName', name: 'sessionName' },
                                { data: 'className', name: 'className' },
                                { data: 'student_name', name: 'student_name' },
                                { data: 'fatherNAme', name: 'fatherNAme' },
                                { data: 'father_mobile_no', name: 'father_mobile_no' },
                                { data: 'gender', name: 'gender' },
                                { data: 'reg_date', name: 'reg_date' },
                               {data: 'action', name: 'action', orderable: false, searchable: false}
                               ],
                        columnDefs: [
                                {
                                  "render": function(data, type, row) {
                                      if (row.gender==0) {
                                          return 'Male';
                                      }else {
                                          return 'Female';
                                      }
                                   }, "targets": [6]
                                }
                      ]
                });
                }
      
    });
</script>
@endsection



