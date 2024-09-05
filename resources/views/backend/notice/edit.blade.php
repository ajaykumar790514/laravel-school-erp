@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->Edit Circular/Notices</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <?php $id=base64_encode($data->id);?>
            <form class="" method="POST" action='{{ url("/academics/notice-edit/{$id}") }}' enctype="multipart/form-data" id='CompanyForm-add'>
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
                                            <input type="text" class="form-control" name='title' id='title'  value="{{ $data->title}}">
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
								       <div class="form-group{{ $errors->has('upload_content') ? ' has-error' : '' }}">
                                            <label>Description<span class="text-danger">*</span></label>
                                            <textarea rows="10" cols="10" class="form-control" id='upload_content' name='upload_content' placeholder="Enter your description here">
                                                {{ $data->upload_content}}</textarea>
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
                                        <span id='bannerImg'><img src='{{asset($data->attachment)}}' width='400'></span>
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
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Update </button>
									  @can('notice-list')
                                        <a  href="{{ url('/academics/notice-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Circular/Notices List</a>
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
                                             <option value='{{$session->id}}' <?php echo $data->session_id==$session->id?"selected":"";?>>{{$session->session_name}}</option>   
                                              @endforeach
                                        @endif  
                                    </select>
								</div>
							</div>
                    </div>
                    <div class="col-md-4">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Priority <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
							        <select id="priority"  class="form-control" name="priority" >
                                        <option value=''>--Select--</option>
                                        <option value='0' {{ $data->priority==0?'selected':''}}>Normal</option>   
                                        <option value='1' {{ $data->priority==1?"selected":""}}>High</option>
                                        <option value='2' {{ $data->priority==2?"selected":""}}>Low</option>
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
                                        <option value='0' {{ $data->status==0?'selected':''}}>Active</option>   
                                        <option value='1' {{$data->status==1?"selected":""}}>Inactive</option>
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
        url: '/notice',
        headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            }
    })
});
    </script>
@endsection
