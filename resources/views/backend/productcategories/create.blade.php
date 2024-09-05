@extends('layouts.admin-theme')
@section('content')
<link href="{{ asset('admin/filepond/filepond.css')}}" rel="stylesheet" />
<link href="{{ asset('admin/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet"/>
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
            <form class="" method="POST" action="{{ url('/product-category-create')}}" enctype="multipart/form-data">
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
                                                <div class="form-group{{ $errors->has('parent_id ') ? ' has-error' : '' }}">
                                                    <label>Select Parent </label>
                                                     <?php $flag='-';?>
                                                    <select name="parent_id" id="parent_id" class="form-control select">
                                                        <option value=''>--Select--</option>
                                                        @foreach ($categories as $category)
                                                        <option value="{{$category->id}}" {{ old('parent_id')==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                                    @include('backend.productcategories.child_category', ['child_category' => $childCategory])
                                                                @endforeach
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" name='title', id='title' value="{{ old('title')  }}">
                                                </div>
                                                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
											        <label>Slug <span class="text-danger">*</span></label>
											        <input type="text" class="form-control" name='slug', id='slug'  value="{{ old('slug')}}">
										        </div>
                                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                                    <label>Description</label>
                                                    <textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your meta description here">{{ old('description')}}</textarea>
                                                    
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
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
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
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Save</button>
									  @can('product-category-list')
                                        <a href="{{ url('product-category-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Category List</a>
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
									<h6 class="panel-title">More Information<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
    									<div class="form-group">
    										 <label>Home Page Show<span class="text-danger">*</span></label>
                                             <input type="checkbox" class="switchery" value='0' checked="checked"  id='home_page_show' name='home_page_show'>
    									</div>
								</div>
							</div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Image  <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }} ">
											<input type="file" 
                                        class="filepond"
                                        id='images'
                                        name="images" 
                                       allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="1">
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

<script src="{{ asset('admin/filepond/filepond.js')}}"></script>
<script src="{{ asset('admin/filepond/filepond-plugin-image-preview.js')}}"></script>
<script src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tagsinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/tags/tokenfield.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('admin/js/plugins/forms/styling/switch.min.js')}}"></script>
 <script type="text/javascript">  
      $(document).ready(function () {
            CKEDITOR.replace( 'description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
            //for image
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const galeryImg = document.querySelector('input[id="images"]');
                FilePond.create(galeryImg, {
                server:{
                    url: '/categoryimg',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
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
