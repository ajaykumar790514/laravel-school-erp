@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->Assignment/Holidays Homework</h4>
        </div>
      </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
                    <!-- 2 columns form -->
                     <form class="" method="POST" action="{{ url('/academics/assignment-holidays-create')}}" enctype="multipart/form-data" id='CompanyForm-add'>
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
                                            <label>Title<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='title' id='title'  value="{{ old('title')  }}">
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
								       <div class="form-group{{ $errors->has('upload_content') ? ' has-error' : '' }}">
                                            <label>Description<span class="text-danger">*</span></label>
                                            <textarea rows="10" cols="10" class="form-control" id='upload_content' name='upload_content' placeholder="Enter your description here">
                                                {{ old('upload_content')}}</textarea>
                                            @if ($errors->has('upload_content'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('upload_content') }}</strong>
                                                </span>
                                            @endif
                                        </div>
									    
								        <div class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
											<input type="file" 
                                        class="filepond"
                                        id='attachment'
                                        name="attachment" allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="5MB"
                                        data-max-files="1">
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
									  @can('assignment-holidays-list')
                                        <a  href="{{ url('/academics/assignment-holidays-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Holidays Homework List</a>
                                    @endcan
								</div>
							</div>
                    </div>
                    <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Session/Class/Section <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
								        <select id="session_id"  class="form-control" name="session_id" >
                                        <option value=''>--Select Section--</option>
                                        @if(count(getSession())>0)
                                            @foreach(getSession() as $session)
                                             <option value='{{$session->id}}' <?php echo getSessionDefault()==$session->id?"selected":"";?>>{{$session->session_name}}</option>   
                                              @endforeach
                                        @endif  
                                    </select>
								</div>
								<div class="panel-body">
							        <select id="class_id"  class="form-control" name="class_id" >
                                            <option value=''>--Select Class--</option>
                                            @if(count(getClasses())>0)
                                                @foreach(getClasses() as $classesmaping)
                                                 <option value='{{$classesmaping->id}}' <?php echo old('class_id')==$classesmaping->id?"selected":"";?>>{{$classesmaping->class_name}}</option>   
                                                  @endforeach
                                            @endif  
                                           
                                        </select>
								</div>
								<div class="panel-body">
							        <select id="section_id"  class="form-control" name="section_id" >
                                        <option value=''>--Select Section--</option>
                                    </select>
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
                                        <option value='0' {{ old('status')==0?'selected':''}}>Active</option>   
                                        <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
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
<script type="text/javascript" src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
 <script type="text/javascript">
$(document).ready(function(){
    CKEDITOR.replace( 'upload_content' );
    
    FilePond.registerPlugin(FilePondPluginImagePreview);
    const bannerElement = document.querySelector('input[id="attachment"]');
    FilePond.create(bannerElement, {
    server:{
        url: '/homework',
        headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            }
    })

    var url = "{{url('/')}}";
      $('#class_id').bind('load, change', function () {
        $('#section_id').empty();
        var id = $('#class_id').val();
        $('#section_id').html('<option selected="selected" value="">Loading...</option>');
        $.ajax({
            url: "{{ url('get-section') }}",
            type: "GET",
            data: {
                     id:id,
                    
                  },
            dataType: "json",
            success:function(data) {
                //alert(data);
                $('#section_id').html('<option selected="selected" value="">Select Section</option>');
                $.each(data, function(key, value) {
                    $('#section_id').append('<option value="'+key+'">'+value+'</option>');
                });

            }
        });
      });
       $('#class_id').trigger('change');
});
    </script>
@endsection