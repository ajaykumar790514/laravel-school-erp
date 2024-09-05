@extends('layouts.admin-theme')
@section('content')
<link href="{{asset('admin/css/filepond.css')}}" rel="stylesheet" />
<link href="{{asset('admin/css/filepond-plugin-image-preview.css')}}" rel="stylesheet"/>
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
            <form class="" method="POST" action="javascript:void(0)" id="form-add">
                    {{ csrf_field() }}
                    <div class="row">
                     @include('layouts.massage') 
                     @include('layouts.validation-error') 
                     <div id="success_message"></div>
                     <ul id="save_msgList"></ul>
                     <div class="col-md-8">
                         <div class="col-md-12">
                            <div class="panel panel-flat">
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
                            <div class="panel-body">
                                <div class="row">
                                   <div class="col-md-12">
                                        <div class="form-group">
    										<label class="display-block text-semibold">Product Type<span class="text-danger">*</span></label>
    										<label class="radio-inline">
    											<input type="radio" name="productType" id="productType" value='0' class="productType">
    											Single
    										</label>
    										<label class="radio-inline">
    											<input type="radio" name="productType" id='productType' value='1' class="productType">
    											Variant
    										</label>
    									</div>
                                    
                                    	<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    		<label>Product Name <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="title" , id="title" value="{{ old('title')}}" />
                                    	</div>
                                    	<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                    		<label>Slug <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="slug" , id="slug" value="{{ old('slug')}}" />
                                    	</div>
                                    
                                    	<div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                                    		<label>Short Description<span class="text-danger">*</span></label>
                                    		<textarea rows="5" cols="5" class="form-control" id="short_description" name="short_description"
                                    			placeholder="Enter your short description here">{{ old('short_description')}}</textarea>
                                    	</div>
                                    	<div class="form-group{{ $errors->has('long_description') ? ' has-error' : '' }}">
                                    		<label>Description</label>
                                    		<textarea rows="5" cols="5" class="form-control" id="long_description" name="long_description" placeholder="Enter your description here"></textarea>
                                    	</div>
                                    	<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                    		<label>Tag </label>
                                    		<input type="text" class="form-control tokenfield" name="tags" data-limit="10" id="input-tags"
                                    			value="{{ old('tags')}}" />
                                    	</div>
                                    	<div class="form-group{{ $errors->has('productmultipal') ? ' has-error' : '' }} ">
                                    		<label>Multipal Images </label>
                                    		<input type="file" class="filepond" id="productmultipal" name="productmultipal[]" multiple
                                    			allowImagePreview="true" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="10" />
                                    	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                         <div class="col-md-12" id='singleProduct'>
                            <div class="panel panel-flat">
                           	<div class="panel-heading">
								<h6 class="panel-title">Inventry<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                	</ul>
			                	</div>
							</div>
                            <div class="panel-body">
                                <div class="row">
                                   <div class="col-md-3">
                                    	<div class="form-group">
                                    		<label>Sku <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="sku" id="sku"/>
                                    	</div>
                                   </div>
                                    <div class="col-md-2">
                                    	<div class="form-group">
                                    		<label>Price <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="price"  id="price"  maxlength='5' />
                                    	</div>
                                    
                                    </div>
                                    <div class="col-md-2">
                                    	<div class="form-group">
                                    		<label>Quantity <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="quantity"  id="quantity" maxlength='5'  />
                                    	</div>
                                    
                                    </div>
                                     <div class="col-md-2">
                                    	<div class="form-group">
                                    		<label>Discount </label>
                                    		<input type="text" class="form-control" name="discount"  id="discount" placeholder="optional" maxlength='5'  />
                                    	</div>
                                    </div>
                                    <div class="col-md-3">
                                    	<div class="">
                                    		<label>Discount Type </label>
                                    		<select id="discount_type"  class="form-control select" name="discount_type" >
                                                <option value='0' {{ old('discount_type')==0?"selected":""}}>Fixed</option>   
                                                <option value='1' {{old('discount_type')==1?"selected":""}}>Percentage</option>
                                            </select>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12" id='variationProduct'>
                            <div class="panel panel-flat">
                           	<div class="panel-heading">
								<h6 class="panel-title">Inventry<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								<div class="heading-elements">
								<a hrf="#" id='addAttribute'>Add more attributes</a>
			                	</div>
							</div>
                            <div class="panel-body">
                                <div class="row" id="attributeCantener">
                                    <div id="id-1" class='panel panel-body border-top-primary'>
                                        <div class="col-md-6">
                                            <div class="form-group">
        										<label>Attribute<span class="text-danger">*</span></label>
        										<select class="form-control"  id='attribute1' name='attribute[]' onchange="loadAttributeValue('attribute1','attributeVal1')">
        										    <option value="">--Select--</option>
        										    @foreach (productAttributes() as $attribute)
        											    <option value="{{$attribute->id}}" >{{ $attribute->title }}</option>
        											@endforeach
        										</select>
        									</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
        										<label>Attribute Value<span class="text-danger">*</span></label>
        										<select class="form-control select"  id='attributeVal1' name='attributeVal[]'>
    											    
    										   </select>
        									</div>
                                        </div>
                                        <div class="col-md-3">
                                        	<div class="form-group{{ $errors->has('variation_sku') ? ' has-error' : '' }}">
                                        		<label>Sku <span class="text-danger">*</span></label>
                                        		<input type="text" class="form-control" name="variation_sku[]" id="variation_sku" />
                                        	</div>
                                       </div>
                                        <div class="col-md-2">
                                        	<div class="form-group{{ $errors->has('variation_price') ? ' has-error' : '' }}">
                                        		<label>Price <span class="text-danger">*</span></label>
                                        		<input type="text" class="form-control" name="variation_price[]"  id="variation_price"/>
                                        	</div>
                                        
                                        </div>
                                        <div class="col-md-2">
                                        	<div class="form-group{{ $errors->has('variation_quantity') ? ' has-error' : '' }}">
                                        		<label>Quantity <span class="text-danger">*</span></label>
                                        		<input type="text" class="form-control" name="variation_quantity[]"  id="variation_quantity" />
                                        	</div>
                                        
                                        </div>
                                        <div class="col-md-2">
                                        	<div class="form-group{{ $errors->has('variation_discount') ? ' has-error' : '' }}">
                                        		<label>Discount </label>
                                        		<input type="text" class="form-control" name="variation_discount[]"  id="variation_discount"  />
                                        	</div>
                                        </div>
                                        <div class="col-md-3">
                                        	<div class="form-group{{ $errors->has('variation_discount_type') ? ' has-error' : '' }}">
                                        		<label>Discount Type </label>
                                        		<select id="variation_discount_type"  class="form-control select" name="variation_discount_type[]" >
                                                    <option value=''>--Select--</option>
                                                    <option value='0'>Fixed</option>   
                                                    <option value='1' >Percentage</option>
                                                </select>
                                        	</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-flat">
                                <div class="panel-heading">
								<h6 class="panel-title">SEO Information<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								<div class="heading-elements">
									<ul class="icons-list">
				                		<li><a data-action="collapse"></a></li>
				                	</ul>
			                	</div>
							</div>
                                <div class="panel-body">
                           
                            <div class="row">
                            <div class="col-md-12">
                                    
							        <div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
										<label>Meta Title</label>
										<textarea rows="5" cols="5" class="form-control" id='meta_title' name='meta_title' placeholder="Enter your description here">{{ old('meta_title')}}</textarea>
								    </div>
								    <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
										<label>Meta Description</label>
										<textarea rows="5" cols="5" class="form-control" id='meta_description' name='meta_description' placeholder="Enter your meta description here">{{ old('meta_description')}}</textarea>
									</div>
								
                            </div>
                            </div>

                        </div>
                            </div>
                        </div>
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
                         <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Status <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <select id="status"  class="form-control" name="status" >
                                            <option value=''>--Select--</option>
                                            <option value='0' {{ old('status')==0?"selected":""}}>Published</option>   
                                            <option value='1' {{old('status')==1?"selected":""}}>Un Publish</option>
                                        </select>
								</div>
							</div>
                         </div>
                         <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Category<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								       	<div class="form-group">
    										<label>Select Category <span class="text-danger">*</span></label>
    										     <?php $flag='-';?>
    											<select class="form-control select" name='category_ids' id='category_ids'>
    												@foreach ($categories as $category)
                                                        <option value="{{$category->id}}" {{ old('category_id')==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                            @include('backend.product.child_category', ['child_category' => $childCategory])
                                                        @endforeach
                                                    @endforeach
    											</select>
    										
    									</div>
								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Product collections<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
										<div class="form-group">
    										 <label>Best Seller<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='best_seller' name='best_seller'>
    									</div>
    									<div class="form-group">
    										 <label>Future Products<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='feacture_product' name='feacture_product'>
    									</div>
										<div class="form-group">
    										 <label>News Product<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='newest_product' name='newest_product'>
    									</div>

								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Labels<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
										<div class="form-group">
    										 <label>Hot<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='lable_hot' name='lable_hot'>
    									</div>
    									<div class="form-group">
    										 <label>New<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='lable_new' name='lable_new'>
    									</div>
										<div class="form-group">
    										 <label>Sale<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='	lable_sale' name='lable_sale'>
    									</div>

								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Product images (Thumbnail) <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <div class="form-group{{ $errors->has('productimages') ? ' has-error' : '' }} imagediv">
											<input type="file" class="filepond"  id='productimages' name="productimages" allowImagePreview='true' data-allow-reorder="true"
                                                data-max-file-size="3MB"  data-max-files="1">
										</div> 
								</div>
						</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Dimension</i></a></h6>
								</div>
								<div class="panel-body">
								    <div class="form-group{{ $errors->has('weight') ? ' has-error' : '' }}">
                                        <label>Weight (in Kg)</label>
                                        <input class="form-control" name='weight', id='weight' value="{{ old('weight')  }}" maxlength='4'>
                                    </div> 
                                    <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}">
                                        <label>Length(in CM) </label>
                                        <input class="form-control" name='length', id='length' value="{{ old('length')  }}" maxlength='4'>
                                    </div> 
                                    <div class="form-group{{ $errors->has('breadth') ? ' has-error' : '' }}">
                                        <label>Breadth (in CM) </label>
                                        <input class="form-control" name='breadth', id='breadth' value="{{ old('breadth')  }}" maxlength='4'>
                                    </div> 
                                    <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}">
                                        <label>Height (in CM) </label>
                                        <input class="form-control" name='height', id='height' value="{{ old('height')  }}" maxlength='4'>
                                    </div> 
								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Video<small>(Video embedded code pasted here)</small><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								       <div class="form-group{{ $errors->has('video_content') ? ' has-error' : '' }} videodiv">
    										<textarea rows="5" cols="5" class="form-control" id='video_content' name='video_content' placeholder="Video embedded code pasted here">
    											{{ old('video_content')}}</textarea>
									    </div> 
								</div>
							</div>
                        </div>
                     </div>
                    
                    
                </div>
            </form>
            
        </div>
@endsection
@section('script')    

<script type="text/javascript" src="{{asset('admin/filepond/filepond.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/filepond/filepond-plugin-image-preview.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switch.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/notifications/pnotify.min.js')}}"></script>

 <script type="text/javascript">  
    function loadAttributeValue( atribute, atributeval){
            //alert("hgjhg");      return false;  
            $("#"+atributeval).empty(); 
            $("#"+atributeval).append('<option>Loading...</option>');
            var attId= $('#'+atribute).val();
            if(attId!=''){
                       $.ajax({
                            type: "POST",
                            url: "/get-attributes-value",
                            data: {attValue:attId},
                            //dataType: "json",
                            success: function (response) {
                                //console.log(response);
                                 var obj = jQuery.parseJSON(response);
                                 $("#"+atributeval).empty(); 
                                var tblRow='';
                                $.each( obj, function( i, obj ) { 
                                  tblRow += '<option value="'+obj.attributeValueId+'">'+obj.attributeValueName+'</option> ';
                                });
                                $("#"+atributeval).append(tblRow);
                            }
                        });
                   }
       
    }
      $(document).ready(function () {
            CKEDITOR.replace('long_description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
            $('.productType').change(function() {
               if($(this).val()==0){
                   $("#variationProduct").hide();
                   $("#singleProduct").show();
               }else{
                   $("#singleProduct").hide();
                   $("#variationProduct").show();
               }
            }).change();
           
            
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
            
            //for multipal media
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const multipalImg = document.querySelector('input[id="productmultipal"]');
                FilePond.create(multipalImg, {
                server:{
                    url: '/productgallerymultipal',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }}
                });
                
                $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
                
                var i=2;
                $(document).on('click', '#addAttribute', function (e) {
                    e.preventDefault();
                    $("#attributeCantener").append('<div id="id-'+i+'" class="panel panel-body border-top-primary">\n' +
                        '<div class="col-md-5"><div class="form-group">\n' +
                        '<label>Attribute<span class="text-danger">*</span></label>\n' +
                          '<select class="form-control"  id="attribute'+i+'" name="attribute[]" onchange="loadAttributeValue('+"'attribute"+i+"'"+','+"'attributeVal"+i+"'"+')">\n' +
        				  '@foreach (productAttributes() as $attribute)\n' +
        					'<option value="{{$attribute->id}}">{{ $attribute->title }}</option>\n' +
        					'@endforeach\n' +
        					'</select>\n' +
                        '</div></div>\n' +
                        '<div class="col-md-5"><div class="form-group">\n' +
        				   '<label>Attribute Value<span class="text-danger">*</span></label>\n' +
        					'<select class="form-control"  id="attributeVal'+i+'" name="attributeVal[]"></select>\n' +
        				'</div></div>\n' +
        				'<div class="col-md-2"><div class="form-group">\n' +
        				 '<span class="remove_attributes" data-id="'+i+'" style="float:right"><i class="icon-minus3" style="top:35px"></i></span>\n' +
                        '</div></div>\n' +
        				'<div class="col-md-3"><div class="form-group">\n' +
                            '<label>Sku</label><input type="text" class="form-control" name="variation_sku[]" />\n' +
                        '</div></div>\n' +
                        '<div class="col-md-2"><div class="form-group">\n' +
                            '<label>Price</label><input type="text" class="form-control" name="variation_price[]"/>\n' +
                         '</div></div>\n' +
                         '<div class="col-md-2"><div class="form-group">\n' +
                            '<label>Quantity</label><input type="text" class="form-control" name="variation_quantity[]"/>\n' +
                         '</div></div>\n' +
                         '<div class="col-md-2"><div class="form-group">\n' +
                            '<label>Discount</label><input type="text" class="form-control" name="variation_discount[]"/>\n' +
                          '</div></div>\n' +
                           '<div class="col-md-3"><div class="form-group">\n' +
                             '<label>Discount Type </label><select id="discount_type"  class="form-control" name="variation_discount_type[]">\n' +
                                '<option value="">--Select--</option><option value="0">Fixed</option>\n' +   
                                '<option value="1">Percentage</option></select>\n' +
                            '</div></div\n' +
                        '</div>');
                        i++;
                        
                }); 
              
              $(document).on('click', '.remove_attributes', function (e) {
                e.preventDefault();
                var id= $(this).attr("data-id");
                $("#id-"+id).remove();
            });
            
             $(document).on('click', '.add_button', function (e) {
                    e.preventDefault();
                    //for pass ckeditor textare value with ajax
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    this.disabled=true;
                    var data = $('#form-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "product-create",
                            data: data,
                            dataType: "json",
                            success: function (response) {
                               // console.log(response); return false;
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
                                    window.location="/product";
                                }
                            }
                        });

            }); 
           
            // Basic initialization
            $('.tokenfield').tokenfield({
                allowDuplicates: false
            });
        $("#title").keyup(function(){
             var Text = $(this).val();
            Text = Text.toLowerCase();
            Text = Text.replace(/ /g,'-');
            Text = Text.replace(/[^\w-]+/g,'')
            $("#slug").val(Text);    
        });
            
   
    });
 </script>
@endsection
