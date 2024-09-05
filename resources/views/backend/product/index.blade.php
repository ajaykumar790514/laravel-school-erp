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
                        @can('product-edit')  
                        <a href="{{ url('product-create')}}" class="btn btn-primary"> <i class=" icon-plus-circle2 position-left"></i> Create New Product</a>
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
                    <th>#</th>
                    <th>Banners</th>
                    <th>Product Type </th>
                     <th>Title </th>
                     <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
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
                   ajax: "{{ url('productdatatable') }}",
                   columns: [
                            { data: 'id', name: 'id' },
                             { data: 'product_img', name: 'product_img' , orderable: false, searchable: false},
                             { data: 'product_type', name: 'product_type' }, 
                            { data: 'title', name: 'title' }, 
                             { data: 'prcatName', name: 'prcatName' },
                             { data: 'status', name: 'status' },
                             {data: 'action', name: 'action', orderable: false, searchable: false}
                           ],
                    columnDefs: [
                            {
                              "render": function(data, type, row) {
                                  if (row.status=="0") {
                                      return '<span class="label label-success">Publish</span>';
                                  }else {
                                      return '<span class="label label-default">Un-Publish</span>';
                                  }
                               }, "targets": [5]
                            }, 
                            {
                              "render": function(data, type, row) {
                                      return '<a href="public/'+row.product_img+'" data-popup="lightbox"><img src="public/'+row.product_img+'" alt="" class="img-rounded img-preview"> </a>';
                               }, "targets": [1]
                            }
                            
                  ]
                });
                }

               

        });
</script>                
@endsection

