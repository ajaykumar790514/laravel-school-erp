@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Blog Management</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('/blog-create')}}" enctype="multipart/form-data" id='CompanyForm-add'>
                    {{ csrf_field() }}
                <div class="row">
                     @include('layouts.massage') 
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                           
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
									    <label>Title <span class="text-danger">*</span></label>
									    <input type="text" class="form-control" name='title', id='title'  value="{{ old('title')}}">
								        </div>
								       
								        <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }}">
    										<label>Short Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='short_description' name='short_description' placeholder="Enter your description here">{{ old('short_description')}}</textarea>
									    </div>
									    <div class="form-group{{ $errors->has('page_content') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ old('page_content')}}</textarea>
    									</div>
    									<div class="form-group{{ $errors->has('media_type') ? ' has-error' : '' }}">
                                            <label>Media Type <span class="text-danger">*</span></label>
                                            <select id="media_type"  class="form-control" name="media_type" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ old('media_type')==0?"selected":""}}>Image</option>   
                                                <option value='1' {{old('media_type')==1?"selected":""}}>Video</option>
                                            </select>
                                        </div>
								        <div class="form-group{{ $errors->has('banner') ? ' has-error' : '' }} imagediv">
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
										<div class="form-group{{ $errors->has('video_content') ? ' has-error' : '' }} videodiv">
    										<label>Video <small>(Video embedded code pasted here)</small><span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='video_content' name='video_content' placeholder="Video embedded code pasted here">
    											{{ old('video_content')}}</textarea>
									    </div>
									
                                </div>
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
									  @can('blog-list')
                                        <a href="{{ url('blog-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Health Servise List</a>
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
                                            <option value='0' {{ old('status')==0?"selected":""}}>Published</option>   
                                            <option value='1' {{old('status')==1?"selected":""}}>Un Publish</option>
                                        </select>
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
            CKEDITOR.replace( 'description', {
                enterMode : CKEDITOR.ENTER_BR,
                shiftEnterMode: CKEDITOR.ENTER_P,
                allowedContent:true,
            } );
            
            //for banner
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const bannerElement = document.querySelector('input[id="banner"]');
                FilePond.create(bannerElement, {
                server:{
                    url: '/blogBanner',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                })
           
        $('.imagediv').hide();
        $('.videodiv').hide();   
        $("#media_type").change(function(){
                    $(this).find("option:selected").each(function(){
                        var optionValue = $(this).attr("value");
                        if(optionValue){
                           if(optionValue==0){
                                $('.imagediv').show();
                                $('.videodiv').hide();
                           } else if(optionValue==1){
                               $('.videodiv').show();
                               $('.imagediv').hide();
                           } 
                        } else{
                            $('.imagediv').hide();
                            $('.videodiv').hide();
                        }
                    });
            }).change();
            
   
    });
 </script>
@endsection
