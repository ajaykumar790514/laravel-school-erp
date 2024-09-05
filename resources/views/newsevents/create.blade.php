@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">News Events Management</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('/newsevents-create')}}" enctype="multipart/form-data" id='CompanyForm-add'>
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
                            <div class="panel-heading">
                                @can('newsevents-list')
                                    <a href="{{ url('newsevents-list')}}" class="btn btn-primary "> <i class="icon-add position-centre"></i> News Events List</a>
                                @endcan
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>
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
    										<textarea rows="5" cols="5" class="form-control" id='short_description' name='short_description'>{{ old('short_description')}}</textarea>
									    </div>
									    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ old('description')}}</textarea>
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
											<label>Banner</label>
											<input type="file" class="file-styled" id='banner' name='banner' >
											<span class="help-block">Accepted formats: jpeg, png, jpg. Max file size 1Mb</span>
										</div> 
										<div class="form-group{{ $errors->has('video_content') ? ' has-error' : '' }} videodiv">
    										<label>Video <small>(Video embedded code pasted here)</small><span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='video_content' name='video_content' placeholder="Video embedded code pasted here">{{ old('video_content')}}</textarea>
									    </div>
									<div class="form-group{{ $errors->has('post_date') ? ' has-error' : '' }}">
                                            <label>Post Date</label>
                                            <input type='date' class="form-control" name='post_date', id='post_date' value="{{ old('post_date')  }}">
                                        </div>
									
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select id="status"  class="form-control" name="status" >
                                            <option value=''>--Select--</option>
                                            <option value='0' {{ old('status')==0?"selected":""}}>Published</option>   
                                            <option value='1' {{old('status')==1?"selected":""}}>Un Publish</option>
                                        </select>
                                    </div>
                                </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success add_button"><i class="icon-add position-left"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
@endsection
@section('script')    
<script src="{{ asset('admin/ckeditor/ckeditor/ckeditor.js') }}"> </script>
 <script type="text/javascript">  

      CKEDITOR.replace( 'description' );  
       $(document).ready(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });   
           
           
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
