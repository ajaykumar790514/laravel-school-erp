@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><span class="text-semibold">Product Module</span> <i
                                    class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
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
                                <thead class="bg-slate-600">
                                    <tr role="row">
                                        <th>#</th>
                                        <th>State/City</th>
                                        <th>Area</th>
                                        <th>Pin Code</th>
                                        <th>Availability</th>
                                        <th>Days</th>
                                        <th>Charges</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                        </table>
                        </div>
                    </div>
                </div>
               @include('backend.zip_availability.create')
               @include('backend.zip_availability.edit')

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
            
            //This function Define add data with ajax
            $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#form-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "/zip-availability-create",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                console.log(response);
                                if (response.status == 400) {
                                    $('#save_msgList').html("").show();
                                    $('#save_msgList').addClass('alert alert-danger');
                                    $.each(response.errors, function (key, err_value) {
                                        $('#save_msgList').append('<li>' + err_value + '</li>');
                                    });
                                    $('.add_button').text('Save');
                                    $('.add_button').removeAttr('disabled');
                                } else if(response.status == 500){
                                    $('#success_message').html("").show();
                                    $('#success_message').addClass('alert alert-danger');
                                    $('#success_message').text(response.message);
                                    $('.add_button').text('Save');
                                    $('.add_button').disabled=false;
                                } else {
                                    listdata();
                                    $('#form-add').find('input').val('');
                                    $('#modal_theme_primary').modal('hide');
                                    // Solid primary
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                $('.add_button').removeAttr('disabled');
                                }
                            }
                        });

            }); 
    

                  


                //This function Define add data with ajax
                $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var UpdateId= $('#hiddenId').val();
                    var data = $('#form_edit').serialize();
                    $.ajax({
                            type: "POST",
                            url: "/zip-availability-edit",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                console.log(response);
                                if (response.status == 400) {
                                    $('#edit_save_msgList').show();
                                    $('#edit_save_msgList').html("");
                                    $('#edit_save_msgList').addClass('alert alert-danger');
                                    $.each(response.errors, function (key, err_value) {
                                        $('#edit_save_msgList').append('<li>' + err_value + '</li>');
                                    });
                                    $('.edit_button').removeAttr('disabled');
                                }  else if(response.status == 500){
                                    $('#edit_success_message').html("").show();
                                    $('#edit_success_message').addClass('alert alert-danger');
                                    $('#edit_success_message').text(response.message);
                                    $('.edit_button').removeAttr('disabled');
                                }else {
                                    listdata();
                                    $('.edit_button').text('Update');
                                    $('#edit_modal_theme_primary').modal('hide');
                                    // Solid primary
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                $('.edit_button').removeAttr('disabled');
                                }
                            }
                        });

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
                        ajax: "{{ url('zipavailabilitydatatable') }}",
                        columns: [{data: 'id', name: 'id'},
                                {data: 'state_id', name: 'state_id'},
                                {data: 'area',name: 'area'},
                                {data: 'pincode',name: 'pincode'},
                                {data: 'available',name: 'available'},
                                {data: 'deliver_with_days',name: 'deliver_with_days'},
                                {data: 'extra_charges',name: 'extra_charges'},
                                {data: 'status ',name: 'status '},
                                {data: 'action',name: 'action',orderable: false,searchable: false}
                        ],
                        columnDefs: [
                            {
                              "render": function(data, type, row) {
                                  if (row.status==0) {
                                      return '<span class="label label-success">Active</span>';
                                  }else {
                                      return '<span class="label label-default">Inactive</span>';
                                  }
                               }, "targets": [7]
                            }, 
                             
                            
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
                                url: "/zip-availability-delete/"+id,
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

