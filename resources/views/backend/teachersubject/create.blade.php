@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Create Teacher Subject Maping</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('/academics/teacher-subject-maping-create')}}" enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('teacher-subject-maping-list')
                                    <a href="{{ url('/academics/teacher-subject-maping-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i>Teacher Subject Mapping List</a>
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
                                           <div class="form-group{{ $errors->has('teacher_id') ? ' has-error' : '' }}">
                                            <label>Teacher <span class="text-danger">*</span></label>

                                            <select id="teacher_id"  class="form-control" name="teacher_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($teachers)>0)
                                                    @foreach($teachers as $teacher)
                                                     <option value='{{$teacher->id}}' <?php echo old('teacher_id')==$teacher->id?"selected":"";?>>{{$teacher->employee_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                          </div>
                                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ old('status')==0?'selected':''}}>Active</option>   
                                                <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                            </select>
                                           </div>
                                        
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('subject_id') ? ' has-error' : '' }}">
                                            <label>Subject <span class="text-danger">*</span></label>
                                            <select id="subject_id"  class="form-control" multiple="multiple" name="subject_id[]" >
                                               
                                                @if(count(getSubjectSetup())>0)
                                                    @foreach(getSubjectSetup() as $subject)
                                                     <option value='{{$subject->id}}' <?php  
                                                     if(!empty(old('subject_id'))){
                                                            if(in_array($subject->id, old('subject_id'))) { 
                                                                echo 'selected';
                                                            } else { echo "" ;} 

                                                       } ?> 

                                                     >{{$subject->subject_name}}</option>   
                                                      @endforeach
                                                @endif    
                                                
                                            </select>
                                           </div>

                                           
                                       
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Save New Teacher & Subject </button>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
@endsection
