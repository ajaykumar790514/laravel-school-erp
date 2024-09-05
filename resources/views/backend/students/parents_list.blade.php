@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
              <div class="page-header-content">
                <div class="page-title">
                  <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Parents Module</span> ->Parent List</h4>
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
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                        </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table  table-bordered table-striped table-hover" id="laravel_datatable">
                        <thead class="thead-dark">
                            <tr role="row">
                                 <th>Id</th>
                                 <th>Children</th>
                                 <th>Father Name</th>
                                 <th>Mother Nqme</th>
                                 <th>Mobile</th>
                                 <th>Email</th>
                                 <th >Action</th>
                             </tr>
                        </thead>
                            
                        
                        <tfoot class="thead-dark">
                            <tr role="row">
                                 <th>Id</th>
                                 <th>Children</th>
                                 <th>Father Name</th>
                                 <th>Mother Nqme</th>
                                 <th>Mobile</th>
                                 <th>Email</th>
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
                       ajax: "{{ url('parentdatatable') }}",
                       columns: [
                                { data: 'id', name: 'id'},
                                { data: 'student', name: 'student',  orderable: false, searchable: false },
                                { data: 'father_name', name: 'father_name' },
                                { data: 'mothers_name', name: 'mothers_name' },
                                { data: 'father_mobile_no', name: 'father_mobile_no' },
                                { data: 'father_email', name: 'father_email' },
                                {data: 'action', name: 'action', orderable: false, searchable: false}
                               ],
                        columnDefs: [
                               
                      ]
                });
                }
      
    });
</script>
@endsection



