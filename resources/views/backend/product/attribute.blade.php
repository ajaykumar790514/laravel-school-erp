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
            <form class="" method="POST" action="{{ url('/product-create')}}" enctype="multipart/form-data" id='CompanyForm-add'>
                    {{ csrf_field() }}
                <div class="row">
                     @include('layouts.massage') 
                      @include('layouts.validation-error') 
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
    											<input type="radio" name="productType" id="productType" value='0' {{ old('productType')==0?"checked":""}}>
    											Single
    										</label>
    										<label class="radio-inline">
    											<input type="radio" name="productType" id='productType' value='1' {{ old('productType')==1?"checked":""}}>
    											Variant
    										</label>
    									</div>
                                    	<div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    		<label>Product Type<span class="text-danger">*</span></label>
                                    		<input type="text" class="form-control" name="title" , id="title" value="{{ old('title')}}" />
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
                                    	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    		<label>Description<span class="text-danger">*</span></label>
                                    		<textarea rows="5" cols="5" class="form-control" id="description" name="description"
                                    			placeholder="Enter your description here">{{ old('description')}}</textarea>
                                    	</div>
                                    	<div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                    		<label>Tag <span class="text-danger">*</span></label>
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
                                    			<label>Product Stock <span class="text-danger">*</span></label>
                                    			<input type="text" class="form-control" name="stock" , id="stock" value="{{ old('stock')}}" />
                                    		</div>
                                    	</div>
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                    			<label>Selling Price</label>
                                    			<input type="text" class="form-control" name="selling_price" , id="selling_price" value="{{ old('selling_price')}}" />
                                    		</div>
                                    	</div>
                                    </div>
                                    <div class="row">
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                    			<label>Discount</label>
                                    			<input type="text" class="form-control" name="discount" , id="discount" value="{{ old('discount')}}" />
                                    		</div>
                                    	</div>
                                    	<div class="col-md-6">
                                    		<div class="form-group">
                                    			<label>Discount Type</label>
                                    			<input type="text" class="form-control" name="discount_type " , id="discount_type " value="{{ old('discount_type ')}}" />
                                    		</div>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
										<div class="multi-select-full">
											<select class="multiselect-onchange-notice" multiple="multiple">
											    @foreach ($attributes as $attribute)
												    <option value="{{$attribute->id}}" {{ old('product_attribute_id')==$attribute->id?"selected":""}}>{{ $attribute->title }}</option>
												@endforeach
											</select>
										</div>
									</div>
                            		<div class="table-responsive">
							            <table class="table bordered table-bordered" >
								            <thead>
            									<tr>
            										<th>Variant</th>
            										<th>SKU</th>
            										<th>Stock </th>
            										<th>Selling Price</th>
            										<th>Images</th>
            									</tr>
        								    </thead>
								            <tbody id='tbl'>
            									<tr>
            										<td>1</td>
            										<td><input type="text" class="form-control" name="stock" , id="stock" value="{{ old('stock')}}" /></td>
            										<td><input type="text" class="form-control" name="stock" , id="stock" value="{{ old('stock')}}" /></td>
            										<td><p><input type="text" class="form-control" name="stock" , id="stock" value="{{ old('stock')}}" placeholder='price'/></p>
            										    <p><input type="text" class="form-control" name="stock" , id="stock" value="{{ old('stock')}}" placeholder='discount'/></p>
            										    <select id="discount_type"  class="form-control" name="discount_type" >
                                                            <option value='1' {{ old('discount_type')==0?"selected":""}}>Percentage</option>   
                                                            <option value='0' {{old('discount_type')==1?"selected":""}}>Fixed</option>
                                                        </select>
            										</td>
            										<td ><input type="file" 
                                                                class="filepond"
                                                                id='attributeImg22'
                                                                name="attributeImg22" 
                                                                allowImagePreview='true'
                                                                data-allow-reorder="true"
                                                                data-max-file-size="3MB"
                                                                data-max-files="1"></td>
            									</tr>
            								
							        	</tbody>
							            </table>
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
										<textarea rows="5" cols="5" class="form-control" id='description' name='meta_description' placeholder="Enter your meta description here">{{ old('meta_description')}}</textarea>
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
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Save</button>
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
                                            <option value='publish' {{ old('status')==0?"selected":""}}>Published</option>   
                                            <option value='draft' {{old('status')==1?"selected":""}}>Un Publish</option>
                                        </select>
								</div>
							</div>
                    </div>
                        <div class="col-md-12">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Stock Information<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								       	<div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
									        <label>Product SKU <span class="text-danger">*</span></label>
									        <input type="text" class="form-control" name='sku' id='sku'  value="{{ old('sku')}}">
								        </div>
								        <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
									        <label>Items in Stock<span class="text-danger">*</span></label>
									        <input type="text" class="form-control" name='quantity' id='quantity'  value="{{ old('quantity')}}">
								        </div>
								</div>
							</div>
                    </div>
                        <div class="col-md-12">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">More Information<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								       	<div class="form-group">
    										<label>Select Category <span class="text-danger">*</span></label>
    										     <?php $flag='-';?>
    											<select class="form-control select" name='category_id' id='category_id'>
    												@foreach ($categories as $category)
                                                        <option value="{{$category->id}}" {{ old('category_id')==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                            @include('backend.product.child_category', ['child_category' => $childCategory])
                                                        @endforeach
                                                    @endforeach
    											</select>
    										
    									</div>
    									<div class="form-group">
    										 <label>Price Hide/Show <span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='price_hide_show' name='price_hide_show'>
    									</div>
								        <div class="row">
											<div class="col-md-6">
												<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
        									        <label>Price </label>
        									        <input type="text" class="form-control" name='price' id='price'  value="{{ old('price')}}">
        								        </div>
											</div>

											<div class="col-md-6">
												<div class="form-group{{ $errors->has('sale_price') ? ' has-error' : '' }}">
        									        <label>Sale Price </label>
        									        <input type="text" class="form-control" name='sale_price' id='sale_price'  value="{{ old('sale_price')}}">
        								        </div>
											</div>
										</div>
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
									<h6 class="panel-title">Gallery  <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <div class="form-group{{ $errors->has('productimages') ? ' has-error' : '' }} imagediv">
											<input type="file" 
                                        class="filepond"
                                        id='productimages'
                                        name="productimages" 
                                        multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="1">
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

<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switch.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/notifications/pnotify.min.js')}}"></script>

 <script type="text/javascript">  
      $(document).ready(function () {
            CKEDITOR.replace( 'description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
             localStorage.removeItem('saved_AttributeData');

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
                
                // onChange
                $('.multiselect-onchange-notice').multiselect({
                    buttonClass: 'btn btn-info',
                    onChange: function(element, checked){
                        $.uniform.update();
                       var attValue= $('.multiselect-onchange-notice').val();
                       if(attValue!=''){
                           $.ajax({
                                type: "POST",
                                url: "/get-attributes-value",
                                data: {attValue:attValue},
                                //dataType: "json",
                                success: function (response) {
                                    console.log(response);
                                    var attribute;
                                    var saved_AttributeData = localStorage.getItem('saved_AttributeData');	
                                    if(saved_AttributeData == null) {
                                        localStorage.setItem('saved_AttributeData', response);
                                        attribute=response;
                                    } else {
                                        localStorage.removeItem('saved_AttributeData');
                                        localStorage.setItem('saved_AttributeData', response);
                                        attribute=localStorage.getItem('saved_AttributeData');
                                    }
                                     var obj = jQuery.parseJSON(attribute);
                                     var table = document.getElementById("tbl"); //get the table   
                                     var rowcount = table.rows.length; //get no. of rows in the table
                                     var tblRow='';
                                    //append the row to the table.
                                    $("#tbl").empty();   
                                    $("#tbl").append(tblRow);   
                                    $.each( obj, function( i, obj ) {
                                      tblRow += '<tr id="row-'+rowcount + '"> ';
                                      tblRow +='<td>'+obj.attributeValueName+'</td>';
                                        tblRow +='<td><input type="text" class="form-control" name="sku" , id="sku" value=""/></td>';
                                        tblRow +='<td><input type="text" class="form-control" name="stock"  id="stock" value="" /></td>';
                                        tblRow +='<td><p><input type="text" class="form-control" name="stock"  id="stock" value="" placeholder="price"/></p>';
            							    tblRow +='<p><input type="text" class="form-control" name="stock"  id="stock" value="" placeholder="discount"/></p>';
            								tblRow +='<p><select id="discount_type"  class="form-control" name="discount_type" >';
            								tblRow +='<option value="1">Percentage</option>';
            								tblRow +='<option value="0" >Fixed</option>';
            								tblRow +='</select></p>';
            								tblRow +='</td>';
            								tblRow +='<td><input type="file" class="filepond" multiple  id="pound'+i+'" name="attributeImg" data-allow-reorder="true" data-max-file-size="3MB" data-max-files="1"></td>';
                                      tblRow +='</tr>'  ;
                                     /// let pondId = "pond" + i;
                                     //  loadFilepond(pondId);
                                      //loadFilepond( "attributeImg"+i );
                                      //append the row to the table.      
                                    });
                                    $("#tbl").append(tblRow);
                                    
                                    
                                }
                            });
                       }else{
                         localStorage.removeItem('saved_AttributeData');  
                       }
                    }
                });
                
                
                //for Gallery
                function uploadFile( filePondId ){
                     FilePond.registerPlugin(FilePondPluginImagePreview);
                        const galeryAttImg = document.querySelector('input[id="pound0"]');
                        FilePond.create(galeryAttImg, {
                        server:{
                            url: '/productgallery',
                            headers: {
                                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                  }
                                }
                        });
                 }
                               
                
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const galeryAttImg = document.querySelector('input[id="pound0"]');
                FilePond.create(galeryAttImg, {
                server:{
                    url: '/productgallery',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                });
                
                
                
                
               // Basic initialization
            $('.tokenfield').tokenfield({
                allowDuplicates: false
            });
            
             if (Array.prototype.forEach) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
                elems.forEach(function(html) {
                    var switchery = new Switchery(html);
                });
            }
            else {
                var elems = document.querySelectorAll('.switchery');
                for (var i = 0; i < elems.length; i++) {
                    var switchery = new Switchery(elems[i]);
                }
            }
            
           
         
            
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
