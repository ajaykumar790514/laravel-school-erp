@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->School Events</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('/academics/events-create')}}"   enctype="multipart/form-data" id='CompanyForm-add'>
                    {{ csrf_field() }}
                <div class="row">
                     @include('layouts.massage') 
                     <div class="col-md-8">
                         <div class="col-md-12">
                        <div class="panel panel-flat">
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                                            <label>Title<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='note' id='note'  value="{{ old('note')  }}">
                                            @if ($errors->has('note'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('note') }}</strong>
                                                </span>
                                            @endif
                                        </div>
								       <div class="form-group{{ $errors->has('descriptions') ? ' has-error' : '' }}">
                                            <label>Description<span class="text-danger">*</span></label>
                                            <textarea rows="10" cols="10" class="form-control" id='descriptions' name='descriptions' placeholder="Enter your description here">
                                                {{ old('descriptions')}}</textarea>
                                            @if ($errors->has('descriptions'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('descriptions') }}</strong>
                                                </span>
                                            @endif
                                        </div>
									    
								        <div class="form-group{{ $errors->has('attachments') ? ' has-error' : '' }}">
											<input type="file" 
                                        class="filepond"
                                        id='attachments'
                                        name="attachments" allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="5MB"
                                        data-max-files="1">
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
									  @can('events-list')
                                        <a  href="{{ url('/academics/events-list')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to School Events List</a>
                                    @endcan
								</div>
							</div>
                        </div>
                    <div class="col-md-12">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">Session/Category <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
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
								        <select id="events_category_id"  class="form-control" name="events_category_id" >
                                                <option value=''>--Select Category--</option>
                                                @if(count($eventsCategory)>0)
                                                    @foreach($eventsCategory as $category)
                                                     <option value='{{$category->id}}' <?php echo old('events_category_id')==$category->id?"selected":"";?>>{{$category->name}}</option>   
                                                      @endforeach
                                                @endif  
                                            </select>
								</div>
							</div>
                    </div>
                    <div class="col-md-12">
                       <div class="panel panel-white">
								<div class="panel-heading">
									<h6 class="panel-title">From Date/To Date <span class="text-danger">*</span><a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
								</div>
								<div class="panel-body">
							        <input type="date" class="form-control" name='date_from' id='date_from'  value="{{ old('date_from')  }}">
                                    <span class="help-block">Date formate:dd-mm-yyy</span>
								</div>
								<div class="panel-body">
							        <input type="date" class="form-control" name='date_to', id='date_to'  value="{{ old('date_to')  }}">
                                   <span class="help-block">Date formate:dd-mm-yyy</span>
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
                                        <option value='0' {{ old('status')==0?'selected':''}}>Active</option>   
                                        <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                    </select>
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
<script type="text/javascript" src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
 <script type="text/javascript">
$(document).ready(function(){
    CKEDITOR.replace( 'descriptions' );
    
    FilePond.registerPlugin(FilePondPluginImagePreview);
    const bannerElement = document.querySelector('input[id="attachments"]');
    FilePond.create(bannerElement, {
    server:{
        url: '/events',
        headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
              }
            }
    })

});
</script>
@endsection
