@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee</span> ->Create New Designation</h4>
            </div>
          </div>
        </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('designation-create')}}" enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('designation-list')
                                    <a href="{{ url('designation-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i>Designation Setup List</a>
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
                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('designation_name') ? ' has-error' : '' }}">
                                            <label>Designation Name<span class="text-danger">*</span></label>
                                            <input type="Year" class="form-control" name='designation_name', id='designation_name'  value="{{ old('designation_name')  }}">
                                         </div>
                                         <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ old('status')==0?"selected":""}}>Active</option>   
                                                <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                            </select>
                                          </div>
                                         
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            <label>Description</label>
                                            <textarea rows="4" class="form-control" name='description', id='description'>{{ old('description')  }} </textarea>
                                         </div>
                                       
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Save New Designation Setup </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
@endsection