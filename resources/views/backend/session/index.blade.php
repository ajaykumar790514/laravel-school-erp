@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Session Setup</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <div class="content">
                @include('layouts.massage') 
             <div class="panel panel-flat">
                 <div class="panel-heading">
                    @can('session-create')
                   <a href="{{ url('session-create')}}" class="btn btn-primary"><i class="icon-calendar position-left"></i>New Session Setup</a>
                    @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[3, "desc" ]]'>
               <thead class="thead-dark">
                  <tr role="row">
                     <th>Id</th>
                     <th>Session Year</th>
                     <th>Session Name</th>
                     <th>Default</th>
                     <th>Order By</th>
                     <th>Status</th>
                     <th >Created at</th>
                     <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
                <tr role="row">
                     <th>Id</th>
                     <th>Session Year</th>
                     <th>Session Name</th>
                     <th>Default</th>
                     <th>Order By</th>
                     <th>Status</th>
                     <th >Created at</th>
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
        $(document).ready(function() {
            $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            listdata();
            // Data Listing data in ajax formate
            function listdata(){ 
                    $('#laravel_datatable').DataTable({
                      fixedHeader: {
                        header: true,
                        footer: true
                    },
        "stripeClasses": [ 'odd-row', 'even-row' ],
           processing: true,
           serverSide: true,

           ajax: "{{ url('sessiondatatable') }}",
           columns: [
                    { data: 'id', name: 'id', orderable: false, searchable: false },
                    { data: 'session_year', name: 'session_year' },
                    { data: 'session_name', name: 'session_name' },
                    { data: 'default_session', name: 'default_session' },
                    { data: 'order_by', name: 'order_by' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                    

                 ],
                 columnDefs: [
                {
                    "render": function(data, type, row) {
                        if (row.status==0) {
                            return '<span class="label label-success">Active</span>';
                        }else {
                            return '<span class="label label-default">Inactive</span>';
                        }
                     }, "targets": [5]
         },
         {
                    "render": function(data, type, row) {
                        if (row.default_session==0) {
                            return 'No';
                        }else {
                            return 'Yes';
                        }
                     }, "targets": [3]
         },
        ]
        });
                }

        });
</script>                
@endsection