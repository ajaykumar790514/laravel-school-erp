@extends('layouts.admin-theme')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><span class="text-semibold">Website Modules</span> <i
                                    class="icon-arrow-right6 position-centre"></i> Menu List</h4>
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
                            @can('menu-create')
                            <button type="button" id='openModal' class="btn btn-primary btn-sm" >Create New Menu<i class="icon-plus-circle2 position-right"></i></button>
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
                                    <th>Parent </th>
                                    <th>Name</th>
                                    <th>Url</th>
                                    <th>Orderby</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
                @include('menu.create')
                @include('menu.edit')
               
@endsection
@section('script')   
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/pnotify.min.js') }}"></script>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            //For Add Model
            $('#url_link_internal1').hide();
            $('#url_link_external1').hide();
            $("#link_type").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue = $(this).attr("value");
                        if(optionValue){
                           if(optionValue==0){
                               
                            $('#url_link_internal1').show();
                            $('#url_link_external1').hide();
                           } else if(optionValue==1){
                               $('#url_link_external1').show();
                               $('#url_link_internal1').hide();
                           } 
                        } else{
                            $('#url_link_internal1').hide();
                            $('#url_link_external1').hide();
                        }
                    });
            }).change();
            
            //For Edir Modal
                $('#url_link_internal1_edit').hide();
                $('#url_link_external1_edit').hide();
                function changeLinkType(){
                    $("#link_type_edit").change(function(){
                        $(this).find("option:selected").each(function(){
                            var optionValue = $(this).attr("value");

                            if(optionValue){
                               if(optionValue==0){
                                $('#url_link_internal1_edit').show();
                                $('#url_link_external1_edit').hide();
                               } else if(optionValue==1){
                                   $('#url_link_external1_edit').show();
                                   $('#url_link_internal1_edit').hide();
                               } 
                            } else{
                                $('#url_link_internal1_edit').hide();
                                $('#url_link_external1_edit').hide();
                            }
                        });
                }).change();
                }
            

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
                         $('#CompanyForm-add')[0].reset();
                        
                });  

                //This function Define add data with ajax
                $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#CompanyForm-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "/menu-create",
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
                                    $('.add_button').removeAttr('disabled');
                                } else if(response.status == 500){
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-danger'
                                        });
                                    $('.add_button').disabled=false;
                                } else {
                                    listdata();
                                    $('#CompanyForm-add')[0].reset();
                                    $('#modal_theme_primary').modal('hide');
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
                    
                    $('#edit_form')[0].reset();
                    var id= $(this).attr("href"); 
                    $.get('menu-loaddata/' + id , function (data) {
                       
                       $('#parent_id_edit').val(data.data.parent_id); 
                       $('#link_type_edit').val(data.data.link_type); 
                       $('#name_edit').val(data.data.name); 
                       $('#order_by_edit').val(data.data.order_by); 
                       $('#url_link_internal_edit').val(data.data.url_link);
                       $('#url_link_external_edit').val(data.data.url_link);
                       $('#target_window_edit').val(data.data.target_window);
                       $('#status_edit').val(data.data.status);
                       changeLinkType();
                       $('#edit_save_msgList').html("<input type='hidden' id='hiddenId' name='id' value='"+data.data.id+"'>");    
                    })
                });   


                //This function Define add data with ajax
                $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var UpdateId= $('#hiddenId').val();
                    var data = $('#edit_form').serialize();
                    $.ajax({
                            type: "POST",
                            url: "/menu-edit",
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
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-danger'
                                        });
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
                        ajax: "{{ url('menudatatable') }}",
                        columns: [{data: 'parent_id', name: 'parent_id'},
                                  {data: 'name', name: 'name'},
                                  {data: 'url_link',name: 'url_link'},
                                  {data: 'order_by',name: 'order_by'},
                                  {data: 'status',name: 'status'},
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
                                   }, "targets": [4]
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
                                url: "/menu-delete/"+id,
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

