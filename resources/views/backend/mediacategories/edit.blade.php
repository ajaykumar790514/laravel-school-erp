@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Media Gallery</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
          <div class="breadcrumb-line">
    		<ul class="breadcrumb">
    			<li><a href="{{url('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
    			<li class="active">Edit Media Category</li>
    		</ul>
    	</div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action='{{ url("media-category-edit/{$ids}")}}'enctype="multipart/form-data">
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
                                                        <option value="{{$category->id}}" {{ $data->parent_id==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                        @foreach ($category->children as $childCategory)
                                                                    @include('backend.mediacategories.child_category_edit', ['child_category' => $childCategory])
                                                                @endforeach
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" name='title', id='title' value="{{ $data->title}}">
                                                </div>
                                                <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
                                                    <label>Description</label>
                                                    <input class="form-control" name='short_description', id='short_description' value="{{ $data->short_description}}">
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
    										<textarea rows="5" cols="5" class="form-control" id='meta_title' name='meta_title' placeholder="Enter your description here">{{ $data->meta_title}}</textarea>
									    </div>
									    <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
    										<label>Meta Description</label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='meta_description' placeholder="Enter your meta description here">{{ $data->meta_description}}</textarea>
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
									  @can('media-category-list')
                                        <a href="{{ url('media-category-list')}}" class="btn btn-default "> <i class="icon-arrow-left52 position-centre"></i> Back to Category List</a>
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
                                            <option value='0' {{ $data->status==0?"selected":""}}>Published</option>   
                                            <option value='1' {{$data->status==1?"selected":""}}>Un Publish</option>
                                        </select>
								</div>
							</div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Image  <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} ">
											<input type="file" 
                                        class="filepond"
                                        id='image'
                                        name="image" 
                                        multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="1">
                                         <span id='displayImg'><img src='{{  asset($data->image)}}' width='150'></span>
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
 <script type="text/javascript">  
      $(document).ready(function () {
            CKEDITOR.replace( 'short_description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
            //for image
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const galeryImg = document.querySelector('input[id="image"]');
                FilePond.create(galeryImg, {
                server:{
                    url: '/mediacategory',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                });
            
            
    });
 </script>
@endsection
