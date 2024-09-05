@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><span class="text-semibold">User Managment</span> <i
                                    class="icon-arrow-right6 position-centre"></i> User List</h4>
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
                            @can('user-create')
                            <button type="button" id='openModal' class="btn btn-primary btn-sm" >Create New User<i class="icon-plus-circle2 position-right"></i></button>
                             @endcan
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                    <li><a data-action="close"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered hover compact" id="laravel_datatable"
                                data-order='[[0, "desc" ]]'>
                            <thead class="bg-slate-600">
                                <tr role="row">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
               
                @include('users.create')
                @include('users.show')
                @include('users.edit')
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

                // This function for Open modal and save roles data
                $(document).on('click', '#openModal', function (e) {
                        e.preventDefault();   
                        // sucess massage display in this div
                        $('#success_message').html("").hide();
                        $('#save_msgList').html("").hide();
                        $('#modal_theme_primary').modal({
                            keyboard: false
                        }) 
                        // reset 
                        $('#name').val('');
                        
                });  

                //This function Define add data with ajax
                $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    $(this).text('Creating...');
                    this.disabled=true;
                    var data = {
                        'email': $('#email').val(),
                        'roles_id': $('#roles_id').val(),
                        'password': $('#password').val(),
                        'confirmpassword': $('#confirmpassword').val(),
                        'name': $('#name').val(),
                        'qualification': $('#qualification').val(),
                        'mobile': $('#mobile').val(),
                        'address': $('#address').val(),
                    }

                        $.ajax({
                            type: "POST",
                            url: "/user-create",
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
                                    $('.add_button').text('Create User');
                                    $('.add_button').removeAttr('disabled');
                                } else if(response.status == 500){
                                    $('#success_message').html("").show();
                                    $('#success_message').addClass('alert alert-danger');
                                    $('#success_message').text(response.message);
                                    $('.add_button').text('Create User');
                                    $('.add_button').disabled=false;
                                } else {
                                    //$('#success_message').addClass('alert alert-success');
                                    //$('#success_message').text(response.message);
                                    listdata();
                                    $('#CompanyForm').find('input').val('');
                                    $('.add_role').text('Save');
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


                // This function for Open modal and fill update data in modal               
                $(document).on('click', '.openEditModal', function (e) {
                    e.preventDefault();   
                    $('#edit_modal_theme_primary').modal({
                        keyboard: false
                    })  
                    $('#edit_save_msgList').html("").hide();
                    $('#edit_CompanyForm').find("input[type=text] , select ").each(function() {
                        $(this).val('');
                    });
                    var id= $(this).attr("href"); 
                    $.get('user-loaddata/' + id , function (data) {
                       $('#edit_email').val(data.data.email); 
                       $('#edit_roles_id').val(data.data.roles_id); 
                       $('#edit_name').val(data.data.name); 
                       $('#edit_qualification').val(data.userdetails.qualification);
                       $('#edit_mobile').val(data.userdetails.mobile);
                       $('#edit_address').val(data.userdetails.address);
                       $('#save_msgList').html("<input type='text' id='hiddenId' value='"+data.data.id+"'>");    
                    })
                });   


                //This function Define add data with ajax
                $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    $(this).text('Updating..');
                    this.disabled=true;
                    var UpdateId= $('#hiddenId').val();
                    var data = {
                        'id':UpdateId,
                        'email': $('#edit_email').val(),
                        'roles_id': $('#edit_roles_id').val(),
                        'name': $('#edit_name').val(),
                        'qualification': $('#edit_qualification').val(),
                        'mobile': $('#edit_mobile').val(),
                        'address': $('#edit_address').val(),
                    }

                    $.ajax({
                            type: "POST",
                            url: "/user-edit",
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
                                    $('.edit_button').text('Update Roles');
                                    $('.edit_button').removeAttr('disabled');
                                }  else if(response.status == 500){
                                    $('#edit_success_message').html("").show();
                                    $('#edit_success_message').addClass('alert alert-danger');
                                    $('#edit_success_message').text(response.message);
                                    $('.edit_button').text('Create User');
                                }else {
                                    listdata();
                                    $('.edit_button').text('Update Roles');
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

                // This function for Open modal for showing data               
                $(document).on('click', '.openShowModal', function (e) {
                    e.preventDefault();   
                    $('#show_modal_theme_primary').modal({
                        keyboard: false
                    })  
                    var id= $(this).attr("href"); 
                    $.get('user-loaddata/' + id , function (data) {
                        $('#show_username').html(data.data.email);
                        $('#show_role').html(data.data.rolename);
                        $('#show_name').html(data.data.name);
                        $('#show_qualification').html(data.userdetails.qualification);
                        $('#show_mobile').html(data.userdetails.mobile);
                        $('#show_address').html(data.userdetails.address);
                    })
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
                        ajax: "{{ url('userdatatable') }}",
                        columns: [{data: 'id', name: 'id'},
                                  {data: 'name', name: 'name'},
                                {data: 'email',name: 'email'},
                                {data: 'roles_id',name: 'roles_id'},
                                {data: 'created_at',name: 'created_at'},
                                {data: 'action',name: 'action',orderable: false,searchable: false}
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
                                url: "/user-delete/"+id,
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

