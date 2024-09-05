@extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Create New Session Setup</h4>
            </div>
          </div>

        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('session-create')}}" enctype="multipart/form-data">
               {{ csrf_field() }}
                <div class="panel panel-flat">
                    @include('layouts.massage') 
                    <div class="panel-heading">
                         @can('session-list')
                            <a href="{{ url('session-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i> Session List</a>
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
                                    <div class="form-group{{ $errors->has('session_year') ? ' has-error' : '' }}">
                                    <label>Session Year <span class="text-danger">*</span></label>
                                    <input type="Year" class="form-control" name='session_year', id='session_year'  value="{{ old('session_year')  }}">
                                   
                                </div>
                                <div class="form-group{{ $errors->has('session_name') ? ' has-error' : '' }}">
                                    <label>Session Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='session_name', id='session_name'  value="{{ old('session_name') }}">
                                </div>
                            </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset>
                                   <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select id="status"  class="form-control" name="status" >
                                        <option value=''>--Select--</option>
                                        <option value='0' {{ old('status')==0?"selected":""}}>Active</option>   
                                        <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                    </select>
                                    
                                </div>
                                <div class="form-group{{ $errors->has('order_by') ? ' has-error' : '' }}">
                                    <label>Order by </label>
                                    <input type="text" class="form-control" name='order_by', id='order_by'  value="{{ old('order_by') }}">
                                </div>
                               
                                </fieldset>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="icon-add position-left"></i> Save New Session Setup </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /content area -->

@endsection

