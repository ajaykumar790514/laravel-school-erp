@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Edit Student Details</h4>
        </div>
      </div>
    </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    @include('layouts.massage') 
                        <!-- Clickable title -->
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            @can('student-list')
                             <a href="{{ url('student-list')}}" class="btn btn-primary"><i class=" icon-people position-left"></i>Student List</a>
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
                            <?php $id=base64_encode($data->id);?>
                            <form class="stepy-clickable" method="POST" action='{{ url("student-edit/{$id}") }}' enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('student_name') ? ' has-error' : '' }}">
                                            <label>Student Name<span class="text-danger">*</span></label>
                                            <input type="Year" class="form-control" name='student_name', id='student_name'  value="{{ $data->student_name  }}">
                                            <span class="help-block">Full Name</span>
                                        </div>

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label>Student Email</label>
                                            <input type="text" class="form-control" name='email' id='email'  value="{{ $data->email  }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('mobile_whatsapp') ? ' has-error' : '' }}">
                                            <label>Whatsapp Mobile</label>
                                            <input type="text" class="form-control" name='mobile_whatsapp' placeholder="Whatsapp number" id='mobile_whatsapp'  value="{{ $data->mobile_whatsapp }}">
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('aadhar_No') ? ' has-error' : '' }}">
                                            <label>Student Aadhaar</label>
                                            <input type="text" class="form-control" name='aadhar_No', id='aadhar_No'  value="{{ $data->aadhar_No  }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('cast_category_setups_id') ? ' has-error' : '' }}">
                                            <label>Category<span class="text-danger">*</span></label>
                                            <select id="cast_category_setups_id"  class="select" name="cast_category_setups_id">
                                                 <option value=''>--Select--</option>
                                                @if(count(getCategory())>0)
                                                    @foreach(getCategory() as $castCategores)
                                                     <option value='{{$castCategores->id}}' <?php echo $data->cast_category_setups_id==$castCategores->id?"selected":"";?>>{{$castCategores->category_initial}}</option>   
                                                      @endforeach
                                                @endif    
                                            </select>
                                            @if ($errors->has('cast_category_setups_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cast_category_setups_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('last_attended_class') ? ' has-error' : '' }}">
                                            <label>Last Attended Class</label>
                                            <input type="text" class="form-control" name='last_attended_class' id='last_attended_class'  value="{{ $data->last_attended_class }}">
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('mark_identification') ? ' has-error' : '' }}">
                                            <label>Mark Identification</label>
                                            <input type="text" class="form-control" name='mark_identification' id='mark_identification'  value="{{ $data->mark_identification  }}">
                                           
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                            <label>Student DOB<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name='dob', id='dob'  value="{{ date('Y-m-d', strtotime($data->dob))  }}">
                                            <span class="help-block">DOB formate:dd-mm-yyy {{$data->dob}}</span>
                                           
                                        </div>
                                         <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                            <label>Gender  <span class="text-danger">*</span></label>
                                            <select id="gender"  class="select" name="gender" >
                                                <option value=''>--Select--</option>
                                                <option value='0' <?php echo $data->gender==0?"selected":"";?>>Male</option>   
                                                <option value='1' <?php echo $data->gender==1?"selected":"";?>>Female</option>
                                                <option value='2' <?php echo $data->gender==2?"selected":"";?>>Other</option>
                                            </select>
                                             @if ($errors->has('gender'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('secondary_mobile') ? ' has-error' : '' }}">
                                            <label>Secondary Mobile</label>
                                            <input type="text" class="form-control" name='secondary_mobile',  id='secondary_mobile'  value="{{ $data->secondary_mobile  }}">
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('religions_id') ? ' has-error' : '' }}">
                                            <label>Religions<span class="text-danger">*</span></label>
                                            <select id="religions_id"  class="select" name="religions_id">
                                                 <option value=''>--Select--</option>
                                                    @if(count(getReligions())>0)
                                                        @foreach(getReligions() as $religion)
                                                         <option value='{{$religion->id}}' <?php echo $data->religions_id==$religion->id?"selected":"";?>>{{$religion->short_name}}</option>
                                                          @endforeach
                                                    @endif    
                                              </select>
                                              @if ($errors->has('religions_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('religions_id') }}</strong>
                                                </span>
                                            @endif
                                         </div>
                                          <div class="form-group{{ $errors->has('last_attended_school') ? ' has-error' : '' }}">
                                            <label>Last Attended School</label>
                                            <input type="text" class="form-control" name='last_attended_school', id='last_attended_school'  value="{{ $data->last_attended_school }}">
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                            <label>Blood Group</label>
                                            <input type="text" class="form-control" name='blood_group', id='blood_group'  value="{{ $data->blood_group }}">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="icon-add position-left"></i>Update Student Records</button>
                                </div>
                            </form>
                        </div>
                        
                        
                        
                        
                         
                          
                    </div>
                    
                </div>
@endsection
@section('script')
    <!-- /page container -->
<script type="text/javascript">
    $(document).ready(function(){
      $('#dob').mask('00-00-0000');
       $('#reg_date').mask('00-00-0000');
    });
</script>
@endsection
