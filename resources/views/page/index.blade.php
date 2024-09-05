@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Website</span> <i class="icon-arrow-right6 position-centre"></i> CMS List </h4>
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
                    @can('cms-edit')  
                    <a href="{{ url('cms-create')}}" class="btn btn-primary"> <i class=" icon-plus-circle2 position-left"></i> Add CMS</a>
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
                    <th>Banners</th>
                     <th>Title </th>
                     <th>Slug</th>
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
                   ajax: "{{ url('cmsdatatable') }}",
                   columns: [
                            { data: 'id', name: 'id' },
                             { data: 'banner', name: 'banner' },
                             { data: 'page_title', name: 'page_title' }, 
                             { data: 'slug', name: 'slug' },
                             { data: 'show_home_page', name: 'show_home_page' }, 
                             { data: 'status', name: 'status' },
                             {data: 'action', name: 'action', orderable: false, searchable: false}
                           ],
                    columnDefs: [
                            {
                              "render": function(data, type, row) {
                                  if (row.show_home_page==0) {
                                      return '<span class="label label-success">Active</span>';
                                  }else {
                                      return '<span class="label label-default">Inactive</span>';
                                  }
                               }, "targets": [4]
                            }, 
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
                                  if (row.banner) {
                                      return '<a href="public/'+row.banner+'" data-popup="lightbox"><img src="public/'+row.banner+'" alt="" class="img-rounded img-preview" width="100"> </a>';
                                  }else {
                                      return '<a href="public/uploads/empty.jpg" data-popup="lightbox"><img src="public/uploads/empty.jpg" alt="" class="img-rounded img-preview"> </a>';
                                  }
                               }, "targets": [1]
                            }
                  ]
                });
                }

                // Delete Records throw Ajax
                $(document).on('click', '.delete', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var id= $(this).attr("href"); 
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this data!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#EF5350",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel pls!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({        
                                type: "POST",
                                url: "/cms-delete/"+id,
                                dataType: "json",
                                success: function (response) {
                                    console.log(response);
                                    // on Alert Error 
                                    if (response.status == 400) {
                                        console.log('Erorr');
                                        swal({
                                            title: "Error Massage!",
                                            text: response.message,
                                            confirmButtonColor: "#66BB6A",
                                            type: "error"
                                        });
                                    } else {
                                        listdata();
                                        // Solid primary
                                        swal({
                                            title: "Deleted!",
                                            text: "Your record has been deleted.",
                                            confirmButtonColor: "#66BB6A",
                                            type: "success"
                                        });
                                                                    
                                    }
                                }
                            });
                        }
                        else {
                            swal({
                                title: "Cancelled",
                                text: "Your data is safe :)",
                                confirmButtonColor: "#2196F3",
                                type: "error"
                            });
                        }
                    });
                

                });

        });
</script>                
@endsection

