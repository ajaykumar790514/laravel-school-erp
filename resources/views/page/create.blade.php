@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
 <style>
           .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 400px;
            }
            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }
        </style>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Website</span> <i class="icon-arrow-right6 position-centre"></i> Add Page</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('/cms-create')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('page_title') ? ' has-error' : '' }}">
									    <label>Title <span class="text-danger">*</span></label>
									    <input type="text" class="form-control" name='page_title', id='page_title'  value="{{ old('page_title')}}">
							        </div>
									<div class="form-group{{ $errors->has('page_content') ? ' has-error' : '' }}">
										<label>Description<span class="text-danger">*</span></label>
										<textarea rows="5" cols="5" class="form-control" id='page_content' name='page_content' placeholder="Enter your description here">{{ old('page_content')}}</textarea>
									</div>
									<div class="form-group{{ $errors->has('show_home_page') ? ' has-error' : '' }}">
                                        <label>Show on page <span class="text-danger">*</span></label>
                                        <select id="show_home_page"  class="form-control" name="show_home_page" >
                                            <option value=''>--Select--</option>
                                            <option value='0' {{ old('show_home_page')==0?"selected":""}}>Yes</option>   
                                            <option value='1' {{old('show_home_page')==1?"selected":""}}>No</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
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
                                            <option value='0' {{ old('status')==0?"selected":""}}>Published</option>   
                                            <option value='1' {{old('status')==1?"selected":""}}>Un Publish</option>
                                        </select>
								</div>
							</div>
                    </div>
                    <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Images<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								    <div class="form-group{{ $errors->has('banner') ? ' has-error' : '' }}">
								        <input type="file" 
                                        class="filepond"
                                        id='banner'
                                        name="banner" 
                                        multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="1">
								    </div>
							    </div>
                    </div>
                </div>
                <div class="col-md-4">
               <div class="panel panel-white">
						<div class="panel-heading">
							<h6 class="panel-title">Slider<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
						</div>
						<div class="panel-body">
						    <div class="form-group{{ $errors->has('slider_id') ? ' has-error' : '' }}">
						        <select id="slider_id"  class="form-control" name="slider_id" >
                                    <option value=''>--Select--</option>
                                     @if(count($sliders)>0) 
                                        @foreach($sliders as $slider)
                                            <option value='{{$slider->id}}' {{ old('lider_id')==$slider->id?"selected":""}}>{{$slider->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
						    </div>
					    </div>
                </div>
            </div>
            <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Publish<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>

								<div class="panel-body">
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Save</button>
									  @can('cms-list')
                                        <a href="{{ url('cms-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to CMS List</a>
                                    @endcan
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
        CKEDITOR.replace( 'page_content', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } ); 
        
        
        /*ClassicEditor
            .create(document.querySelector('#page_content'), {
               ckfinder: {
                    uploadUrl: '{{ route('image.upload').'?_token='.csrf_token() }}',
                }
            })
            .catch(error => {
                console.error(error);
            });*/
            
            //for banner
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const bannerElement = document.querySelector('input[id="banner"]');
                FilePond.create(bannerElement, {
                server:{
                    url: '/cmsBanner',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                }
                });
            
    });
 </script>
@endsection
