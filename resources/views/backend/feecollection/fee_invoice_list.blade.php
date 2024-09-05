@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fees Module </span> ->Menu->Fee Collection Invoice </h4>
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
                            @can('zip-availability-create')
                                <button type="button" id='openModal' class="btn btn-primary btn-sm" >Create New Zip Availability<i class="icon-plus-circle2 position-right"></i></button>
                            @endcan
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered hover compact" id="laravel_datatable"
                                data-order='[[0, "desc" ]]'>
                                 <thead class="thead-dark">
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Admission/Roll No.</th>
                                        <th>Student</th>
                                        <th>Session</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot class="thead-dark">
                                    <tr role="row">
                                        <th>#</th>
                                        <th>Admission/Roll No.</th>
                                        <th>Student</th>
                                        <th>Session</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Status</th>
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
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/pnotify.min.js') }}"></script>
<script>
        $(document).ready(function() {
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
                        "lengthMenu": [
                            [20, 40, 80, -1],
                            [20, 40, 80, "All"]
                        ],
                        "stripeClasses": ['success', 'danger'],
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ url('feeinvoicelistdatatable') }}",
                        columns: [{data: 'id', name: 'id'},
                                {data: 'admission_no', name: 'admission_no'},
                                {data: 'student_name',name: 'student_name'},
                                {data: 'session_name',name: 'session_name'},
                                {data: 'class_name',name: 'class_name'},
                                {data: 'section_name',name: 'section_name'},
                                {data: 'grand_total',name: 'grand_total'},
                                {data: 'curent_balance',name: 'curent_balance'},
                                {data: 'status ',name: 'status'},
                                {data: 'action',name: 'action',orderable: false,searchable: false}
                        ],
                        columnDefs: [
                            {
                              "render": function(data, type, row) {
                                  if (row.status==0) {
                                      return '<span class="label label-success">Un Paid</span>';
                                  }else {
                                      return '<span class="label label-default">Paid</span>';
                                  }
                               }, "targets": [8]
                            }, 
                             
                            
                  ]
                    });
                }
            
        });
</script>                
@endsection

