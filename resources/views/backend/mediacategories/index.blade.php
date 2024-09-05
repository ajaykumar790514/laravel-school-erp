@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Media Gallery</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}} </h4>
            </div>
          </div>
          <div class="breadcrumb-line">
    		<ul class="breadcrumb">
    			<li><a href="{{url('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
    			<li class="active">Media Category List</li>
    		</ul>
    	   </div>
      </div>
        <!-- /page header -->
        <!-- Content area -->
         <div class="content">
           @include('layouts.massage') 
           <!-- Vertical form options -->
              <div class="panel panel-flat">
                  <div class="panel-heading">
                      @can('media-category-create')  
                        <a href="{{ url('media-category-create')}}" class="btn btn-primary"> <i class=" icon-plus-circle2 position-left"></i> Add Category</a>
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
                                 <th>Description</th>
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
                        ajax: "{{ url('mediacategorydatatable') }}",
                        columns: [
                            { data: 'id', name: 'id' },
                            { data: 'images', name: 'images' },
                            { data: 'parent_id', name: 'parent_id' },
                            { data: 'title', name: 'title' },
                            { data: 'short_description', name: 'short_description' },
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
                          if (row.image) {
                              return '<a href="public/'+row.image+'" data-popup="lightbox"><img src="public/'+row.image +'" alt="" class="img-rounded img-preview"> </a>';
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

