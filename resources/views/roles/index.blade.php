@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><span class="text-semibold">User Managment</span> <i
                                    class="icon-arrow-right6 position-centre"></i> Roles</h4>
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
                            @can('role-create')
                            <button type="button" id='openModal' class="btn btn-primary btn-sm" >Create New Roles<i class="icon-plus-circle2 position-right"></i></button>
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
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th style='width:50%'>Permission</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    
                </div>
                @include('roles.create')
                <!-- Primary modal -->
                <!-- Primary modal -->
                <div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Roles</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="CompanyForm"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" class="name form-control"  name='name' id='edit_name'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Permission:</strong>
                            <div class="row">
                                @foreach($permissionHeading as $Headingvalue)
                                <div class="col-md-3">
                                    <h4>{{ $Headingvalue->parent_id }}</h4>
                                    <div class="form-group">
                                        <?php
                                                     $permission1=App\Models\User::getPermission($Headingvalue->parent_id);
                                                     ?>
                                        @foreach($permission1 as $value)
                                        <label><input type="checkbox" class='editRoles' id="editRoles{{$value->id}}" name="edit_permission[]" value="{{$value->id}}">
                                             {{ $value->name }}</label>
                                        <br />
                                        @endforeach
                                    </div>

                                </div>

                                @endforeach
                            </div>


                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" id='updateButton' class="btn btn-success  update_roles">Update Roles</button>
                </div>
            </form>
        </div>
    </div>
</div>
                <!-- /primary modal -->
                <!-- /primary modal -->
@endsection
@section('script') 
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/pnotify.min.js') }}"></script>

<script>
    $(document).ready(function() {
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
                $('.addRoles').attr('checked', false);
        });  

        //This function Define add data with ajax
        $(document).on('click', '.add_role', function (e) {
            e.preventDefault();
            $(this).text('Sending..');
            this.disabled=true;
            var checkedAry= [];
            $("input[type=checkbox]:checked").each ( function() {
                checkedAry.push($(this).val());
            });
            var data = {
                'name': $('.name').val(),
                'permission': checkedAry,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                $.ajax({
                    type: "POST",
                    url: "/role-create",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status == 400) {
                            //console.log('Erorr');
                            $('#save_msgList').html("").show();
                            $('#save_msgList').html("");
                            $('#save_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#save_msgList').append('<li>' + err_value + '</li>');
                            });
                            $('.add_role').text('Save');
                            $('.add_role').disabled=false;
                        } else {
                            
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
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
                             $('.add_role').disabled=false;
                        
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
            $('#edit_name').val('');
            $('.editRoles').attr('checked', false);
            var id= $(this).attr("href"); 
            $.get('load-edit/' + id , function (data) {
                    for (let i = 0; i < data.permission.length; i++) {
                    $('#editRoles'+data.permission[i]['id']).prop('checked', data.permission[i]['id']);
                    }
                $('#edit_name').val(data.data.name);
                $('#save_msgList').html("<input type='hidden' id='hiddenId' value='"+data.data.id+"'>");    
            })
        });   


        //This function Define add data with ajax
        $(document).on('click', '.update_roles', function (e) {
            e.preventDefault();
            $(this).text('Updating..');
            this.disabled=true;
            var checkedAry= [];
            $("input[type=checkbox]:checked").each ( function() {
                checkedAry.push($(this).val());
            });
            var UpdateId= $('#hiddenId').val();
            var data = {
                'id':UpdateId,
                'name': $('#edit_name').val(),
                'permission': checkedAry,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                $.ajax({
                    type: "POST",
                    url: "/role-edit",
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
                            $('.update_roles').text('Update Roles');
                            $('.update_roles').removeAttr('disabled');
                        } else {
                            listdata();
                            $('.update_roles').text('Update Roles');
                            $('#edit_modal_theme_primary').modal('hide');
                            // Solid primary
                            new PNotify({
                                    title: 'Notification',
                                    text: response.message,
                                    addclass: 'bg-success'
                                });
                                $('.update_roles').removeAttr('disabled');
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
                ajax: "{{ url('rolesdatatable') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    
                    {
                        data: 'permission',
                        name: 'permission'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }


                ]
            });
        }
        

        // Delete Records throw Ajax
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            //$(this).text('Deleting.');
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
                    
                    //alert(id); return false;       
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({        
                        type: "POST",
                        url: "/role-delete/"+id,
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