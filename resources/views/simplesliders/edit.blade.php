@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Website</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action='{{ url("simple-sliders-edit/{$id}")}}' enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row">
                    @include('layouts.massage') 
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                 <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									    <label>Name <span class="text-danger">*</span></label>
									    <input type="text" class="form-control" name='name', id='name'  value="{{ $data->name}}">
								        </div>
								        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
									        <label>Key <span class="text-danger">*</span></label>
									     <input type="text" class="form-control" name='key', id='key'  value="{{ $data->key}}" placeholder='home-holder'>
								        </div>
								        
    									<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ $data->description}}</textarea>
    									</div>
                                </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                @can('simple-sliders-item-create')  
                                    <button type="button" id='openModal' class="btn btn-primary btn-sm" >Add New<i class="icon-plus-circle2 position-right"></i></button>
                                @endcan
                            </div>
                            <div class="panel-body table-responsive">
                                 <table class="table  table-bordered table-striped table-hover">
                                  <thead class="bg-slate-600">
                                      <tr role="row">
                                        <th>#</th>
                                        <th>Image</th>
                                         <th>Title </th>
                                         <th>Order </th>
                                        <th>Status</th>
                                        <th >Action</th>
                                      </tr>
                                   </thead>
                                   <thead>
                                     @if(count($sliderItemData)>0)  
                                        @foreach($sliderItemData as $sliderItemDetails)
                                            <tr role="row">
                                                <td>{{$sliderItemDetails->id}}</td>
                                                <td><img src='{{asset($sliderItemDetails->image)}}' width='100'></td>
                                                <td>{{$sliderItemDetails->title}}</td>
                                                <td>{{$sliderItemDetails->order_by}}</td>
                                                <td>{{$sliderItemDetails->status==0?"Published":"Un Published"}}</td>
                                                <td>
                                            <ul class="icons-list">
                                                <li class="dropdown">
                                                	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                		<i class="icon-menu9"></i>
                                                	</a>
                                                	<ul class="dropdown-menu dropdown-menu-right">
                                                	    @can('simple-sliders-item-edit')
                                                		    <li><a class="openEditModal" edit-id='{{$sliderItemDetails->id}}'  id='editID' href='{{$sliderItemDetails->id}}'><i class=' icon-pencil'></i> Edit</a> 
                                                		   </li>
                                                		@endcan
                                                            <li class="divider"></li>
                                                        @can('simple-sliders-item-delete')
                                                        <li><a href='{{$sliderItemDetails->id}}' class=' delete  ' delete-id='{{$sliderItemDetails->id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Delete</a></li>
                                                		@endcan
                                                	</ul>
                                                    </li>
                                            </ul>
                                        </td>
                                            </tr>
                                        @endforeach
                                      @endif
                                   </thead>
                                 </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Publish<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>

								<div class="panel-body">
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Update</button>
									  @can('simple-sliders')
                                        <a href="{{ url('simple-sliders')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Slider List</a>
                                    @endcan
								</div>
							</div>
                    </div>
                    <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Status <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>

								<div class="panel-body">
									<select id="status"  class="form-control" name="status" >
                                        <option value=''>--Select--</option>
                                        <option value='0' {{ $data->status==0?"selected":""}}>Published</option>   
                                        <option value='1' {{$data->status==1?"selected":""}}>Un Published</option>
                                    </select>
								</div>
							</div>
                    </div>
                </div>
            </form>
            
        </div>
         @include('simplesliders.slideritemcreate')
         @include('simplesliders.slideritemedit')
@endsection

@section('script') 
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
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
            $('#success_message').html("").hide();
            $('#save_msgList').html("").hide();
            $('#modal_theme_primary').modal({
                keyboard: false
            }) 
            // reset 
             $('#form-add')[0].reset();
        });  

        //This function Define add data with ajax
        $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#form-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "/simple-sliders-item-create",
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
                                    location.reload();
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
                    $('#form_edit')[0].reset();
                    $('.edit_button').attr('disabled', 'disabled');
                    
                    var id= $(this).attr("href"); 
                    $.get('/simple-sliders-item-loaddata/' + id , function (data) {
                       $('#edit_title').val(data.data.title); 
                       $('#edit_descraption').val(data.data.description); 
                       $('#edit_order_by').val(data.data.order_by);
                       $('#edit_link').val(data.data.link);
                       $('#ckfinder-input-edit').val(data.data.image);
                       document.getElementById('displayImgEditslider').innerHTML ='';
                       var outputdisplay = document.getElementById('displayImgEditslider');
                       $("<img />", {
                                        "src": 'public/'+data.data.image,
                                         "class": "thumb-image rounded float-start",
                                         "style":"width:100px"
                                     }).appendTo(outputdisplay);
                       $('#edit_status').val(data.data.status);
                       $('#edit_save_msgList').html("<input type='hidden' id='hiddenId' name='id' value='"+data.data.id+"'>");  
                        $('.edit_button').removeAttr('disabled');
                    })
                });   


        //This function Define add data with ajax
        $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#form_edit').serialize();
                    $.ajax({
                            type: "POST",
                            url: "/simple-sliders-item-edit",
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
                                   location.reload();
                                }
                            }
                        });

                }); 
                
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
                                url: "/simple-sliders-item-delete/"+id,
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
                                        $('#modal_theme_primary').modal('hide');
                                        // Solid primary
                                        swal({
                                            title: "Deleted!",
                                            text: "Your record has been deleted.",
                                            confirmButtonColor: "#66BB6A",
                                            type: "success"
                                        });
                                        location.reload();
                                                                    
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
