@extends('layouts.admin-theme')
@section('content')
 <!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><span class="text-semibold">Block Managment</span> <i class="icon-arrow-right6 position-centre"></i>{{$title}}</h4>
			</div>
		</div>
	</div>
	<!-- /page header -->
	<div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action='{{ url("blocks-edit/{$ids}")}}' enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="row">
                    @include('layouts.massage') 
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                 <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
									    <label>Name <span class="text-danger">*</span></label>
									    <input type="text" class="form-control" name='name', id='name' disabled='disabled'  value="{{ $data->name}}">
								        </div>
								        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='content' name='content' placeholder="Enter your description here">@php echo $data->content@endphp</textarea>
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
									<button type="submit" class="btn btn-primary"> <i class=" icon-floppy-disk position-centre"></i> Update</button>
									  @can('simple-sliders')
                                        <a href="{{ url('blocks')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Block List</a>
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
                                        <option value='0' {{ $data->status==0?"selected":""}}>Published</option>   
                                        <option value='1' {{$data->status==1?"selected":""}}>Un Published</option>
                                    </select>
								</div>
							</div>
                    </div>
                </div>
            </form>
            
        </div>

@endsection
@section('script')   
<script src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
<script>
$(document).ready(function() {
     CKEDITOR.replace( 'content', {
       enterMode : CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
        allowedContent:true,
        filebrowserBrowseUrl: '/browser/browse.php',
    filebrowserUploadUrl: '/uploader/upload.php'
         
     } );
     
//     ClassicEditor
// 	.create( document.querySelector( '#content' ), {
// 		ckfinder: {
// 			uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
// 		},
// 		toolbar: [ 'ckfinder', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo', 'numberedList', 'bulletedList'],

// 	} )
// 	.catch( error => {
// 		console.error( error );
// 	} );
		

});            
   </script>               
@endsection
    