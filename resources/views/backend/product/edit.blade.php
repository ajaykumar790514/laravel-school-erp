@extends('layouts.admin-theme')
@section('content')
<link href="{{asset('admin/css/filepond.css')}}" rel="stylesheet" />
<link href="{{asset('admin/css/filepond-plugin-image-preview.css')}}" rel="stylesheet"/>
    <!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><span class="text-semibold">Blog Managment</span> <i class="icon-arrow-right6 position-centre"></i>{{$title}}</h4>
			</div>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">
			<!-- Vertical form options -->
			<?php $id=base64_encode($product->id);?>
			<form class="form-horizontal" method="POST" action="javascript:void(0)" enctype="multipart/form-data" id="form-add">
		      {{ csrf_field() }}
		       <div class="row">
                     @include('layouts.massage') 
                      @include('layouts.validation-error') 
                      <ul id="save_msgList"></ul>
                      <div id="success_message"></div>
                     <div class="col-md-8">
                         <div class="col-md-12">
                            <div class="panel panel-flat">
                            <div class="panel-body">
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
									    <label>Product Name <span class="text-danger">*</span></label>
									    <input type="text" class="form-control" name='title', id='title'  value="{{ $product->title}}">
								        </div>
								        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
									        <label>Slug <span class="text-danger">*</span></label>
									        <input type="text" class="form-control" name='slug', id='slug'  value="{{ $product->slug}}">
								        </div>
								       
								        <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
    										<label>Summary<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='short_description' name='short_description' placeholder="Enter your description here">{{ $product->short_description}}</textarea>
									    </div>
									    <div class="form-group{{ $errors->has('long_description') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='long_description' name='long_description' placeholder="Enter your description here">{{ $product->long_description}}</textarea>
    									</div>
    									<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
    									   @php
                                                $tags = $product->tags;
                                                $tags_str = "";
                                                if($tags) {
                                                    foreach ($tags as $key => $product_tag) {
                                                        $seperator = $key != count($tags) - 1 ? "," : "";
                                                        $tags_str .= $product_tag->tags . $seperator;
                                                    }
                                                    
                                                }
                                            @endphp
									        <label>Tags <span class="text-danger">*</span></label>
									        <input type="text" class="form-control tokenfield" name='tags' data-limit="10" id='input-tags'  value=" {{ $tags_str }}">
								        </div>
								        <div class="form-group{{ $errors->has('productmultipal') ? ' has-error' : '' }} ">
								             <label>Multipal Images </label>
    											<input type="file" class="filepond" id='productmultipal'  name="productmultipal[]"  multiple allowImagePreview='true'
                                            data-allow-reorder="true" data-max-file-size="3MB" data-max-files="10">
										</div> 
										<div class="row">
										    @if(!empty($product->multipalimages))
    										    @foreach($product->multipalimages as $key=>$multipalimg)
    										       @if($multipalimg->image_type!=0) 
                        						        <div class="col-lg-3 col-sm-6" id="id-{{$multipalimg->id}}">
                                							<div class="thumbnail">
                                								<div class="thumb">
                                									<img src="{{asset($multipalimg->images)}}" alt="" width='100'>
                                									<div class="caption-overflow">
                                										<span>
                                											<a href="{{asset($multipalimg->images)}}" data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded">
                                											    <i class="icon-plus3"></i></a>
                                											<a href='#' data-id="{{$multipalimg->id}}" onclick="return confirm('Are you sure?');" class="btn border-white text-white btn-flat btn-icon btn-rounded deleteimage"><i class="icon-trash"></i></a>
                                										</span>
                                									</div>
                                								</div>
                                							</div>
                        						      </div>
                        						   @endif
                        						@endforeach
                        					@endif
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
                                    	<div class="form-group" style="margin-right:8px">
                                    		<label>Sku <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="sku" id="sku" value="{{ $product->sku }}"/>
                                    	</div>
                                   </div>
                                    <div class="col-md-2">
                                    	<div class="form-group" style="margin-right:8px">
                                    		<label>Price <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="price"  id="price"  maxlength='5' value="{{ $product->price }}"/>
                                    	</div>
                                    
                                    </div>
                                    <div class="col-md-2">
                                    	<div class="form-group" style="margin-right:8px">
                                    		<label>Quantity <span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="quantity"  id="quantity" maxlength='5'  value="{{ $product->quantity }}"/>
                                    	</div>
                                    
                                    </div>
                                     <div class="col-md-2">
                                    	<div class="form-group" >
                                    		<label>Discount </label>
                                    		<input type="text" class="form-control" name="discount"  id="discount"  maxlength='5'  value="{{ $product->discount }}"/>
                                    	</div>
                                    </div>
                                    <div class="col-md-3">
                                    	<div class="">
                                    		<label>Discount Type </label>
                                    		<select id="discount_type"  class="form-control select" name="discount_type" >
                                                <option value='0' {{ $product->discount_type==0?"selected":""}}>Fixed</option>   
                                                <option value='1' {{$product->discount_type==1?"selected":""}}>Percentage</option>
                                            </select>
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
    										<textarea rows="5" cols="5" class="form-control" id='meta_title' name='meta_title' placeholder="Enter your description here">{{ isset($product->seo->meta_title)}}</textarea>
									    </div>
									    <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
    										<label>Meta Description</label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='meta_description' placeholder="Enter your meta description here">{{ isset($product->seo->meta_description)}}</textarea>
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
    									<button type="submit" class="btn btn-primary edit_button"> <i class=" icon-floppy-disk position-centre"></i> Update</button>
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
                                                <option value='0' {{ $product->status=='0'?"selected":""}}>Published</option>   
                                                <option value='1' {{$product->status=='1'?"selected":""}}>Un Publish</option>
                                            </select>
        								</div>
        							</div>
                            </div>
                         <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Category <span class="text-danger">*</span> <a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								       	<div class="form-group">
    										<?php $flag='-';?>
    											<select class="form-control select" name='category_id' id='category_id'>
    												@foreach ($categories as $category)
                                                        <option value="{{$category->id}}" {{ $product->product_categories_id==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                            @include('backend.product.edit_child_category', ['child_category' => $childCategory])
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
									<h6 class="panel-title">Product Collections<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								    <div class="col-md-4">
                                        <div class="form-group">
    										 <label>Best Seller <span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' id='best_seller' name='best_seller' {{ $product->best_seller==0?"checked='checked' ":""}}  >
									    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
    										 <label>Future Products<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' id='feacture_product' name='feacture_product' {{ $product->feacture_product==0?"checked='checked' ":""}}>
    									</div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
    										 <label>New Product<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' id='newest_product' name='newest_product' {{ $product->newest_product==0?"checked='checked' ":""}} > 
    									</div>
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
								    <div class="col-md-4">
                                       <div class="form-group">
    										 <label>Hot</label>
                                             <input type="checkbox" class="switchery" value='0'   id='lable_hot' name='lable_hot' {{$product->lable_hot==0?"checked='checked' ":""}}>
    									</div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
    										 <label>New</label>
                                             <input type="checkbox" class="switchery" value='0'   id='lable_new' name='lable_new' {{ $product->lable_new==0?"checked='checked' ":""}}>
    									</div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
    										 <label>Sale</label>
                                             <input type="checkbox" class="switchery" value='0'  id='lable_sale' name='lable_sale' {{ $product->lable_sale==0?"checked='checked' ":""}}>
    									</div>
                                    </div>
								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                           <div class="panel panel-white">
    								<div class="panel-heading">
    									<h6 class="panel-title">Thumbnail <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    								</div>
    								<div class="panel-body">
    								        <div class="form-group{{ $errors->has('productimages') ? ' has-error' : '' }} imagediv">
    											<input type="file" class="filepond" id='productimages' name="productimages" allowImagePreview='true' data-allow-reorder="true" data-max-file-size="3MB" data-max-files="1">
    										</div> 
    										<div class="row">
        								    @if(!empty($product->multipalimages))
    										    @foreach($product->multipalimages as $multipalimg)
    										       @if($multipalimg->image_type==0) 
        									        <div class="col-lg-6 col-sm-6" id="thum-{{$multipalimg->id}}">
                        							<div class="thumbnail">
                        								<div class="thumb">
                        									<img src="{{asset($multipalimg->images)}}" alt="{{$product->title}}" title='{{$product->title}}'>
                        									<div class="caption-overflow">
                        										<span>
                        											<a href="{{asset($multipalimg->images)}}" title='{{$product->title}}' data-popup="lightbox" rel="gallery" class="btn border-white text-white btn-flat btn-icon btn-rounded">
                        											    <i class="icon-plus3"></i></a>
                        											<a href='#' data-id="{{$multipalimg->id}}" onclick="return confirm('Are you sure?');" class="btn border-white text-white btn-flat btn-icon btn-rounded deleteThumImage"  onclick="return confirm('Are you sure?');" title='{{$product->title}}' ><i class="icon-trash"></i></a>
                        										</span>
                        									</div>
                        								</div>
                        							</div>
                        						</div>
                        					       @endif
                        					    @endforeach
                        					@endif
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
								    <div class="col-md-6">
                                       <div class="form-group" style='margin-right:5px'>
                                        <label>Weight (in Kg)</label>
                                        <input class="form-control" name='weight', id='weight' value="{{ $product->weight }}" maxlength='4'>
                                        </div> 
                                    </div>
								    <div class="col-md-6">
                                       <div class="form-group" >
                                            <label>Length(in CM) </label>
                                            <input class="form-control" name='length', id='length' value="{{ $product->length }}" maxlength='4'>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group" style='margin-right:5px'>
                                            <label>Breadth (in CM) </label>
                                            <input class="form-control" name='breadth', id='breadth' value="{{ $product->breadth  }}" maxlength='4'>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group{{ $errors->has('length') ? ' has-error' : '' }}">
                                            <label>Height (in CM) </label>
                                            <input class="form-control" name='height', id='height' value="{{ $product->height }}" maxlength='4'>
                                        </div> 
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
								       <div class="form-group{{ $errors->has('video_content') ? ' has-error' : '' }} ">
    										<textarea rows="5" cols="5" class="form-control" id='video_content' name='video_content' placeholder="Video embedded code pasted here">{{ $product->product_video}}</textarea>
									    </div> 
								</div>
							</div>
                        </div>
                     </div>
                    
                </div>
            </form>
		
	</div>
	<!-- /content area -->
@endsection
@section('script')    
<script type="text/javascript" src="{{asset('admin/filepond/filepond.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/filepond/filepond-plugin-image-preview.js')}}"></script>
<script src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switch.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/media/fancybox.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/pages/gallery.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/notifications/pnotify.min.js')}}"></script>

 <script type="text/javascript">  
    $(document).ready(function () {
            CKEDITOR.replace( 'long_description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
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
                
               // Basic initialization
            $('.tokenfield').tokenfield({
                allowDuplicates: false
            });
            
             
            
             $.ajaxSetup({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });
            
             $(document).on('click', '.edit_button', function (e) {
                    e.preventDefault();
                    //for pass ckeditor textare value with ajax
                    for (instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    this.disabled=true;
                    var data = $('#form-add').serialize();
                        $.ajax({
                            type: "POST",
                            url: "/product-edit/<? echo $id;?>",
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
                                    $('.edit_button').text('Update');
                                    $('.edit_button').removeAttr('disabled');
                                } else if(response.status == 500){
                                    $('#success_message').html("").show();
                                    $('#success_message').addClass('alert alert-danger');
                                    $('#success_message').text(response.message);
                                    $('.edit_button').text('Update');
                                    $('.edit_button').removeAttr('disabled');
                                } else {
                                    $('#form-add').find('input').val('');
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                    $('.edit_button').removeAttr('disabled');
                                    window.location="/product";
                                }
                            }
                        });

            }); 
            
            
            // Delete Records throw Ajax
            //url("/product-gallery-delete/{$multipalimg->id}")
              $(document).on('click', '.deleteimage', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var id= $(this).attr("data-id"); 
                    $.ajax({        
                                type: "POST",
                                url: "/product-gallery-delete/"+id,
                                dataType: "json",
                                success: function (response) {
                                    console.log(response);
                                    $("#id-"+id).remove();
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                }
                            });
                });
             $(document).on('click', '.deleteThumImage', function (e) {
                    e.preventDefault();
                    this.disabled=true;
                    var id= $(this).attr("data-id"); 
                    $.ajax({        
                                type: "POST",
                                url: "/product-gallery-delete/"+id,
                                dataType: "json",
                                success: function (response) {
                                    console.log(response);
                                    $("#thum-"+id).remove();
                                    new PNotify({
                                            title: 'Notification',
                                            text: response.message,
                                            addclass: 'bg-success'
                                        });
                                }
                            });
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
