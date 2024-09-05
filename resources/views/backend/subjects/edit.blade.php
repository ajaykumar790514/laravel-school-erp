@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">User Managment</span> ->Master ->Edit Subject Setup Details</h4>
            </div>
          </div>
         </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <?php $id=base64_encode($data->id);?>
                    <form class="" method="POST" action='{{ url("subjectssetup-edit/{$id}") }}' enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('classsetup-list')
                                <a href='{{ url("subjectssetup-list") }}' class="btn btn-primary "><i class="icon-list position-left"></i> Subject Setup List</a>
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
                                            <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                            <label>Parents</label>

                                            <select id="parent_id"  class="select" name="parent_id" >
                                                <option value=''>--Select--</option>
                                                {{App\Models\SubjectSetups::getSubSubject('0', '', $data->parent_id)}}  
                                               
                                            </select>
                                            @if ($errors->has('parent_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('parent_id') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                            <div class="form-group{{ $errors->has('subject_initial') ? ' has-error' : '' }}">
                                            <label>Subject Initial  <span class="text-danger">*</span></label>
                                            <input type="Year" class="form-control" name='subject_initial', id='subject_initial'  value="{{ $data->subject_initial}}">
                                        </div>
                                        <div class="form-group{{ $errors->has('subject_name') ? ' has-error' : '' }}">
                                            <label>Subject Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='subject_name', placeholder="Hindi" id='subject_name'  value="{{ $data->subject_name }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('subject_type') ? ' has-error' : '' }}">
                                            <label>Subject Type  <span class="text-danger">*</span></label>
                                            <select id="subject_type"  class="form-control" name="subject_type" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->subject_type==0?"selected":""}}>Theory</option>  
                                                <option value='1' {{ $data->subject_type==1?"selected":""}}>Practical</option>  
                                                <option value='2' {{ $data->subject_type==2?"selected":""}}>Both</option>
                                            </select>
                                            
                                        </div>
                                        
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>

                                            <div class="form-group{{ $errors->has('subject_mode') ? ' has-error' : '' }}">
                                            <label>Subject Mode <span class="text-danger">*</span></label>
                                            <select id="subject_mode"  class="form-control" name="subject_mode" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->subject_mode==0?"selected":""}}>Compulsory</option>   
                                                <option value='1' {{ $data->subject_mode==1?"selected":""}}>Optional</option>
                                            </select>
                                           </div>
                                           <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->status==0?"selected":""}}>Active</option>   
                                                <option value='1' {{ $data->status==1?"selected":""}}>Inactive</option>
                                            </select>
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('order_by') ? ' has-error' : '' }}">
                                            <label>Order by <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='order_by',  id='order_by'  value="{{ $data->order_by}}">
                                           
                                        </div>
                                       
                                        </fieldset>
                                    </div>
                                </div>

                               <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Update Records </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /content area -->
@endsection