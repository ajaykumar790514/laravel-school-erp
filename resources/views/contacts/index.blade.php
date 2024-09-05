@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Contact Us</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}} </h4>
            </div>
          </div>
      </div>
      <div class="content">
           @include('layouts.massage') 
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
                        <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'  >
                           <thead class="bg-slate-600">
                              <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Massege</th>
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
                    destroy: true,
                   ajax: "{{ url('contactdatatable') }}",
                   columns: [
                            { data: 'id', name: 'id' },
                             { data: 'name', name: 'name' },
                             { data: 'email', name: 'email' }, 
                             { data: 'mobile', name: 'mobile' },
                             { data: 'massage', name: 'massage' },
                             {data: 'action', name: 'action', orderable: false, searchable: false}
                           ],
                    columnDefs: [
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
                                url: "/contact-delete/"+id,
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
                                        $('#modal_theme_primary').modal('hide');
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