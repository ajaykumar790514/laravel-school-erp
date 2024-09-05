@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
<style>
    .multiselect-container{
        padding-left:20px !important;
    }
    .dropdown-menu > li {
        margin-bottom: -9px !important;
    }
</style>

        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Products Module</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="javascript:void(0)"  enctype="multipart/form-data" >
                    {{ csrf_field() }}
                <div class="row">
                     @include('layouts.massage') 
                      @include('layouts.validation-error') 
                      <ul id="save_msgList"></ul>
                     <div class="col-md-12">
                         <div class="col-md-12">
                            <div class="panel panel-flat">
                            <div id="success_message"></div>
                            <div class="panel-body">
                                <div class="row">
                                   <div class="col-md-6">
                                       <div class="form-group">
    										<label class="text-bold">Product Name : </label>
    										{{$product->title}}
    									</div>
                                        <div class="form-group">
    										<label class="text-bold">Product Type : </label>
    										{{$product->product_type==0?"single":"Variant"}}
    									</div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
    										<a href='{{ url("product-inventory/{$product->id}")}}' class="btn btn-primary ">Add Variant More</a>
    									</div>
                                        <div class="form-group">
    										<a href="{{ url('product')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Product List</a>
    									</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                         @if($product->product_type==1)    
                                @if(count($attributesDetails)>0)
                                    <div class="col-md-12">
                                        <div class="panel panel-flat">
                                            <div class="panel-heading">
        								        <h6 class="panel-title">Selected Variant<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
        								        <div class="heading-elements">
            									<ul class="icons-list">
            				                		<li><a data-action="collapse"></a></li>
            				                	</ul>
        			                	    </div>
        							        </div>
                                            <div class="panel-body">
                                    		    <div class="table-responsive">
        							                <table class="table bordered table-bordered" >
            								            <thead>
                        									<tr>
                        									    <th>Attribute</th>
                        										<th>Attribute Value</th>
                        										<th>SKU</th>
                        										<th>Qty</th>
                        										<th>Price/Special</th>
                        										<th>Disscount/Discount Type</th>
                        									    <th>Images</th>
                        									    <th>Action</th>
                        									</tr>
                    								    </thead>
            								            <tbody>
            								                @foreach($attributesDetails as $attributesDetail)
                            									<tr>
                            									    <td>{{$attributesDetail->attributeTitle}}</td>
                            									    <td>{{$attributesDetail->terms}}</td>
                            									    <td>{{$attributesDetail->sku}}</td>
                            										<td>{{$attributesDetail->stock}}</td>
                            										<td>{{$attributesDetail->selling_price}} {{$attributesDetail->special_price==""?"":'/'.$attributesDetail->special_price}}</td>
                            										<td> @if($attributesDetail->discount!=0 || !empty($attributesDetail->discount) ||$attributesDetail->discount!="")
                            										        {{$attributesDetail->discount}}/{{$attributesDetail->discount_type==0?"Fixed":"%"}}
                            										      @endif
                            										   </td>
                            										<td><img src='{{asset($attributesDetail->images)}}' width='70'></td>
                            										<td>
                            										    <ul class="icons-list">
                                                                            <li class="dropdown">
                                                                            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                            		<i class="icon-menu9"></i>
                                                                            	</a>
                                                                            	<ul class="dropdown-menu dropdown-menu-right">
                                                                            	    <li><a class='openEditModal' edit-id='{{$attributesDetail->id}}'  id='editID' href='{{$attributesDetail->id}}'><i class="icon-pencil7"></i> Update Stock</a></li>
                                                                            		<li class="divider"></li>
                                                                                    <li>
                                                                                        <a href='{{url("/variant-stock-delete/{$attributesDetail->id}")}}'  onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Move to trash</a>
                                                                                    </li>
                                                                            	</ul>
                                                                            </li>
                                                                        </ul>
                            										</td>
                            									</tr>
                            								@endforeach
            							        	    </tbody>
        							                </table>
        						                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                             @endif
                        
                     </div>
                     
                </div>
            </form>
            
        </div>
        <!--stock update div -->
    <div id="edit_modal_theme_primary"  class="modal fade ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h6 class="modal-title" id='headerHeading'>Stock Update</h6>
                </div>
                <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                    <ul id="edit_save_msgList"></ul>
                    <div id="edit_success_message"></div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <strong>Attribute<span class="text-danger">*</span></strong>
                                    <div id='edit_attribute'></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                    <div class="form-group">
                                        <strong>Attribute<span class="text-danger">*</span></strong>
                                        <div id='edit_attributeValue'></div>
                                    </div>
                            </div>
                                
                            <div class="col-md-6 col-6">
                                 <div class="form-group">
                                    <strong>Stock (Qty)<span class="text-danger">*</span></strong>
                                    <input class="form-control" name='edit_stock' id='edit_stock'>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                 <div class="form-group">
                                    <strong>Price<span class="text-danger">*</span></strong>
                                    <input class="form-control" name='edit_selling_price' id='edit_selling_price'>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                 <div class="form-group">
                                    <strong>Discount</strong>
                                    <input class="form-control" name='edit_discount' id='edit_discount'>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>Discount Type</label>
                                    <select id="edit_discount_type"  class="form-control" name="edit_discount_type" >
                                        <option value=''>--Select--</option>
                                        <option value='0'>Fixed</option>   
                                        <option value='1'>Percentage</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <span id='displayImgEdit'></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" 
                                        class="filepond"
                                        id='productimages'
                                        name="productimages" 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        accept="image/png, image/jpeg, image/gif"/
                                        data-max-files="1">
                                </div>
                            </div>
                        </div>
    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                        <button type="submit" id='editButton' class="btn btn-success edit_button">Update Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
@endsection
@section('script')    
<script type="text/javascript" src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/notifications/pnotify.min.js')}}"></script>

 <script type="text/javascript">  
      $(document).ready(function () {
            //for Gallery
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const galeryImg = document.querySelector('input[id="productimages"]');
                FilePond.create(galeryImg, {
                server:{
                    url: '/productgallery',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                });
            
            $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            
            // This function for Open modal and fill update data in modal               
                $(document).on('click', '.openEditModal', function (e) {
                    e.preventDefault();   
                    $('#edit_modal_theme_primary').modal({
                        keyboard: false
                    })  
                    $('#form_edit')[0].reset();
                    var id= $(this).attr("href"); 
                    $.get('/variant-loaddata/' + id , function (data) {
                       $('#edit_attribute').text(data.data.attributeTitle); 
                       $('#edit_attributeValue').text(data.data.terms); 
                       $('#edit_stock').val(data.data.stock); 
                       $('#edit_selling_price').val(data.data.selling_price);  
                       $('#edit_discount').val(data.data.discount);
                       $('#edit_discount_type option[value="'+data.data.discount_type+'"]').prop('selected', true);
                       document.getElementById('displayImgEdit').innerHTML ='';
                       var outputdisplay = document.getElementById('displayImgEdit');
                       $("<img />", {
                                        "src": '/public/'+data.data.images,
                                         "class": "thumb-image rounded float-start",
                                         "style":"width:150px"
                                     }).appendTo(outputdisplay);
                       $('#edit_save_msgList').html("<input type='hidden' id='hiddenId' name='hiddenId' value='"+data.data.id+"'>");    
                    })
                });
                
                //This function Define add data with ajax
                $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#form_edit').serialize();
                    $.ajax({
                            type: "POST",
                            url: "/variant-stock-edit",
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
                                    $('.edit_button').text('Update Stock');
                                    $('#edit_modal_theme_primary').modal('hide');
                                    // Solid primary
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                    location.reload();
                                }
                            }
                        });

                }); 
            
    });
 </script>
@endsection
