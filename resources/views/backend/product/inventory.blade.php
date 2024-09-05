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
            <form class="" method="POST" action="javascript:void(0)"  enctype="multipart/form-data" id="form-add">
                    {{ csrf_field() }}
                <div class="row">
                     @include('layouts.massage') 
                      @include('layouts.validation-error') 
                      <ul id="save_msgList"></ul>
                     <div class="col-md-8">
                         <div class="col-md-12">
                            <div class="panel panel-flat">
                            
                            <div id="success_message"></div>
                            <div class="panel-body">
                                <div class="row">
                                   <div class="col-md-12">
                                       <div class="form-group">
    										<label class="text-bold">Product Name : </label>
    										{{$product->title}}
    									</div>
                                        <div class="form-group">
    										<label class="text-bold">Product Type : </label>
    										{{$product->product_type==0?"single":"Variant"}}
    									</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @if($product->product_type==1)
                            <div class="col-md-12">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
								    <h6 class="panel-title">Price Info And Stock<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								    <div class="heading-elements">
    									<ul class="icons-list">
    				                		<li><a data-action="collapse"></a></li>
    				                	</ul>
			                	    </div>
							    </div>
                                <div class="panel-body">
                                    <div class="form-group">
										<label>Attribute<span class="text-danger">*</span></label>
										<select class="form-control select"  id='attribute' name='attribute'>
										    @foreach ($attributes as $attribute)
											    <option value="{{$attribute->id}}" {{ old('attribute')==$attribute->id?"selected":""}}>{{ $attribute->title }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label>Attribute Value<span class="text-danger">*</span></label>
										<select class="form-control select"  id='attributeVal' name='attributeVal'>
											    
										</select>
									</div>
                            		<div class="table-responsive">
							            <table class="table bordered table-bordered" >
								            <thead>
            									<tr>
            										<th>SKU<span class="text-danger">*</span></th>
            										<th>Stock<span class="text-danger">*</span></th>
            										<th>Selling Price<span class="text-danger">*</span></th>
            										<th>Images<span class="text-danger">*</span></th>
            									</tr>
        								    </thead>
								            <tbody>
            									<tr>
            										<td><input class="form-control" name='sku' id='sku'></td>
            										<td><input class="form-control" name='stock' id='stock' maxlength='3'></td>
            										<td><p><input class="form-control" name='price' id='price' maxlength='5' placeholder='Price'></p>
            										    <p><input class="form-control" name='discount' id='discount' maxlength='3' placeholder='discount'></p>
            										    <p><select class="form-control select"  id='discount_type' name='discount_type'>
											                <option value='0'>Fixed</option>
											                <option value='1'>Percentage</option>
										                </select></p>
            										</td>
            										<td width='200'><input type="file" class="filepond"  id='productimages' name="productimages" allowImagePreview='true' data-allow-reorder="true"
                                                data-max-file-size="3MB"  data-max-files="1"></td>
            									</tr>
							        	</tbody>
							            </table>
						            </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($product->product_type==0)
                            <div class="col-md-12">
                                <div class="panel panel-flat">
                                    <div class="panel-heading">
    								    <h6 class="panel-title">Price Info And Stock<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    								    <div class="heading-elements">
        									<ul class="icons-list">
        				                		<li><a data-action="collapse"></a></li>
        				                	</ul>
    			                	    </div>
    							    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                        		<div class="form-group">
                                        			<label>SKU <span class="text-danger">*</span></label>
                                        			<input type="text" class="form-control" name="sku"  id="sku"/>
                                        		</div>
                                        	</div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                        			<label>Stock <span class="text-danger">*</span></label>
                                        			<input type="text" class="form-control" name="stock" id="stock" />
                                        		</div>
                                        	</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                        		<div class="form-group">
                                        			<label>Price <span class="text-danger">*</span></label>
                                        			<input type="text" class="form-control" name="price"  id="price"/>
                                        		</div>
                                        	</div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                        			<label>Discount</label>
                                        			<input type="text" class="form-control" name="discount" , id="discount" value="{{ old('discount')}}" />
                                        		</div>
                                        		
                                        	</div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-md-6">
                                            		<div class="form-group">
                                            			<label>Discount Type</label>
                                            			<select class="form-control select"  id='discount_type' name='discount_type'>
    											                <option value='0'>Fixed</option>
    											                <option value='1'>Percentage</option>
    										                </select>
                                            		</div>
                                        	    </div>
                                        	<div class="col-md-6">
                                        		<div class="form-group">
                                        			<label>Image<span class="text-danger">*</span></label>
                                        			<input type="file" class="filepond"  id='productimages' name="productimages" allowImagePreview='true' data-allow-reorder="true"
                                                data-max-file-size="3MB"  data-max-files="1">
                                        		</div>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                      
                     </div>
                     <div class="col-md-4">
                         <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Publish<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>

								<div class="panel-body">
									<button type="submit" class="btn btn-primary add_button"> <i class=" icon-floppy-disk position-centre"></i> Save</button>
									  @can('product')
                                        <a href="{{ url('product')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Product List</a>
                                    @endcan
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
                										<th>Variant</th>
                										<th>Qty</th>
                										<th>Price/Special</th>
                									    <th>Images</th>
                									</tr>
            								    </thead>
    								            <tbody style="font-size:10px">
    								                @foreach($attributesDetails as $attributesDetail)
                    									<tr>
                    									    <td>{{$attributesDetail->attributeTitle}}<br>({{$attributesDetail->terms}})</td>
                    										<td>{{$attributesDetail->stock}}</td>
                    										<td>{{$attributesDetail->selling_price}}<br>{{$attributesDetail->special_price==""?"":'('.$attributesDetail->special_price.')'}}</td>
                    										<td><img src='{{asset($attributesDetail->images)}}' width='70'></td>
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
@endsection
@section('script')    
<script type="text/javascript" src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script type="text/javascript" src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/notifications/pnotify.min.js')}}"></script>

 <script type="text/javascript">  
      $(document).ready(function () {
             localStorage.removeItem('saved_AttributeData');
            // onChange
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
            $('#attribute').change(function() {
                $("#attributeVal").empty(); 
                $("#attributeVal").append('<option>Loading...</option>');
                var attId= $('#attribute').val();
                if(attId!=''){
                           $.ajax({
                                type: "POST",
                                url: "/get-attributes-value",
                                data: {attValue:attId},
                                //dataType: "json",
                                success: function (response) {
                                    //console.log(response);
                                     var obj = jQuery.parseJSON(response);
                                     $("#attributeVal").empty(); 
                                    var tblRow='';
                                    $.each( obj, function( i, obj ) { 
                                      tblRow += '<option value="'+obj.attributeValueId+'">'+obj.attributeValueName+'</option> ';
                                    });
                                    $("#attributeVal").append(tblRow);
                                }
                            });
                       }
            }).change();    
            
             $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var data = $('#form-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "/product-inventory/<?php echo $id?>",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                                //console.log(response);
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
                                    $('.add_button').removeAttr('disabled');
                                } else {
                                    $('#form-add').find('input').val('');
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                    $('.add_button').removeAttr('disabled');
                                    window.location="/product-inventory/<?php echo $id?>";
                                }
                            }
                        });

            }); 
            
            
            
            
    });
 </script>
@endsection
