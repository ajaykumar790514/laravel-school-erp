@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><span class="text-semibold">Website</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action='{{ url("simple-sliders-create")}}' enctype="multipart/form-data">
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
									    <input type="text" class="form-control" name='name', id='name'  value="{{ old('name')}}">
								        </div>
								        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
									        <label>Key <span class="text-danger">*</span></label>
									     <input type="text" class="form-control" name='key', id='key'  value="{{ old('key')}}" placeholder='home-holder'>
								        </div>
								        
    									<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    										<label>Description<span class="text-danger">*</span></label>
    										<textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ old('description')}}</textarea>
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
									  @can('simple-sliders')
                                        <a href="{{ url('simple-sliders')}}" class="btn btn-default "> <i class="icon-arrow-right6 position-centre"></i> Back to Slider List</a>
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
                                        <option value='1' {{old('status')==1?"selected":""}}>Un Published</option>
                                    </select>
								</div>
							</div>
                    </div>
                </div>
            </form>
            
        </div>
        
@endsection

@section('script')    

 
@endsection
