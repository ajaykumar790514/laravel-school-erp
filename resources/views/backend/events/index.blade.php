@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Menu->School Events</h4>
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
                    @can('events-create')
                   <a href="{{ url('/academics/events-create')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Create School Events</a>
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
                    <th>Category</th>
                     <th>From</th>
                    <th>To</th>
                    <th>note</th>
                    <th>Status</th>
                    <th >Created By</th>
                    <th >Action</th>
                  </tr>
               </thead>
               
                <tfoot class="thead-dark">
               <tr role="row">
                    <th>Id </th>
                    <th>Session</th>
                    <th>Category</th>
                     <th>From</th>
                    <th>To</th>
                    <th>note</th>
                    <th>Status</th>
                    <th >Created By</th>
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

           ajax: "{{ url('academics/eventdata') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'session_name' },
                    { data: 'catName' },
                    { data: 'date_from', name: 'date_from' },
                    { data: 'date_to', name: 'date_to' },
                    { data: 'note', name: 'note' },
                    { data: 'status', name: 'status' },
                    { data: 'name' },
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
                       }, "targets": [6]
                    }
          ]
        });

     });
  </script>
@endsection



