@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Product Module</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}} </h4>
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
                      @can('product-category-create')  
                        <a href="{{ url('product-category-create')}}" class="btn btn-primary"> <i class=" icon-plus-circle2 position-left"></i> Add Category</a>
                      @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'  >
                          <thead class="bg-slate-600">
                              <tr role="row">
                                <th>Id</th>
                                <th>Image</th>
                                 <th>Parent </th>
                                <th>Name</th>
                                 <th>Show Home Page</th>
                                <th>Status</th>
                                <th >Action</th>
                              </tr>
                           </thead>
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
                         "lengthMenu": [[20, 40, 80, -1], [20, 40, 80, "All"]],
                        "stripeClasses": [ 'success', 'danger' ],
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        ajax: "{{ url('productcategorydatatable') }}",
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'images', name: 'images' },
                            { data: 'parent_id', name: 'parent_id' },
                            { data: 'title', name: 'title' },
                            { data: 'home_page_show', name: 'home_page_show' },
                            { data: 'status', name: 'status' },
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                           ],
                        columnDefs: [
                    {
                      "render": function(data, type, row) {
                          if (row.status=="0") {
                              return '<span class="label label-success">Published</span>';
                          }else {
                              return '<span class="label label-default">Draft</span>';
                          }
                       }, "targets": [5]
                    },
                    {
                      "render": function(data, type, row) {
                          if (row.home_page_show==0) {
                              return '<span class="label label-success">Yes</span>';
                          }else {
                              return '<span class="label label-default">No</span>';
                          }
                       }, "targets": [4]
                    },
                    {
                      "render": function(data, type, row) {
                          if (row.images) {
                              return '<a href="public/'+row.images+'" data-popup="lightbox"><img src="public/'+row.images +'" alt="" class="img-rounded img-preview"> </a>';
                          }else {
                              return '<a taget="_new" href="./uploads/empty.jpg" data-popup="lightbox"><img src="public/uploads/empty.jpg" alt="" class="img-rounded img-preview"> </a>';
                          }
                       }, "targets": [1]
                    },
                    
          ]
                    });
            }

               

        });
</script>                
@endsection

