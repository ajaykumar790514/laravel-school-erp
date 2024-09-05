@extends('layouts.admin-theme')
@section('content')
<link href="{{ asset('admin/filepond/filepond.css')}}" rel="stylesheet" />
<link href="{{ asset('admin/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet"/>
<style>
    .filepond--item{
        width: 200px!important;
    }
</style>
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Meida Gallery</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
          <div class="breadcrumb-line">
    		<ul class="breadcrumb">
    			<li><a href="{{url('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
    			<li class="active">Add Video Gallery</li>
    		</ul>
    	</div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('video-gallery-create')}}" >
                     @csrf
                <div class="row">
                    @include('layouts.massage') 
                    <div class="col-md-8">
                        <div class="panel panel-flat">
                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('media_content') ? ' has-error' : '' }}">
                                            <label>Youtube Embed Video <span class="text-danger">*</span></label>
                                            <textarea rows="5" cols="5" class="form-control" name='media_content' id='media_content'>{{ old('media_content')}}</textarea>
                                        </div>
										<div class="form-group{{ $errors->has('media_categories_id ') ? ' has-error' : '' }}">
                                            <label>Select Category <span class="text-danger">*</span></label>
                                             <?php $flag='-';?>
                                            <select name="media_categories_id" id="media_categories_id" class="form-control select">
                                                <option value=''>--Select--</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}" {{ old('media_categories_id')==$category->id?"selected":""}}>{{ $category->title }}</option>
                                                    @foreach ($category->children as $childCategory)
                                                        @include('mediagallery.child_category', ['child_category' => $childCategory])
                                                    @endforeach
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
									    <label>Title</label>
									    <input type="text" class="form-control" name='title', id='title'  value="{{ old('title')}}">
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
									  @can('video-gallery-list')
                                        <a href="{{ url('video-gallery-list')}}" class="btn btn-default "> <i class="icon-arrow-left52 position-centre"></i> Back to Video Gallery List</a>
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
@endsection
@section('script')
<script src="{{ asset('admin/filepond/filepond.js')}}"></script>
<script src="{{ asset('admin/filepond/filepond-plugin-image-preview.js')}}"></script>
 <script type="text/javascript">  
       $(document).ready(function () {
           
            FilePond.registerPlugin(FilePondPluginImagePreview);
             const inputElement = document.querySelector('input[id="media"]');
                FilePond.create(inputElement, {
                server:{
                    url: '/gallerymultipal',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                });
    });
 </script>
@endsection
