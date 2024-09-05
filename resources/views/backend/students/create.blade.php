@extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Student Registration</h4>
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
                <div class="fieldset"> 
                    <div class="col-md-12">@include('layouts.validation-error')</div>
                </div>
                <form class="stepy-clickable" method="POST" action="{{ url('student-create')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <fieldset>
                        <legend class="text-semibold">Official Information:</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                    <label>Session <span class="text-danger">*</span></label>
                                    <select id="session_id"  class="select" name="session_id" >
                                        <option value=''>--Select--</option>
                                        @if(count(getSession())>0)
                                            @foreach(getSession() as $session)
                                             <option value='{{$session->id}}' <?php echo getSessionDefault()==$session->id?"selected":"";?>>{{$session->session_name}}</option>   
                                              @endforeach
                                        @endif  
                                    </select>
                                    @if ($errors->has('session_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('session_id') }}</strong>
                                        </span>
                                    @endif
                                </div>   
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                    <label>Class <span class="text-danger">*</span></label>
                                     <select id="class_id"  class="select" name="class_id" >
                                        <option value=''>--Select--</option>
                                        @if(count(getClasses())>0)
                                            @foreach(getClasses() as $classe)
                                             <option value='{{$classe->id}}' <?php echo old('class_id')==$classe->id?"selected":"";?>>{{$classe->class_name}}</option>   
                                              @endforeach
                                        @endif  
                                     </select>

                                     @if ($errors->has('class_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('class_id') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('reg_date') ? ' has-error' : '' }}">
                                    <label>Reg. Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='reg_date', id='reg_date'  value="{{ date('d-m-Y')  }}">
                                    <span class="help-block">Reg. Date formate:dd-mm-yyy</span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-semibold">Student Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('student_name') ? ' has-error' : '' }}">
                                    <label>Student Name<span class="text-danger">*</span></label>
                                    <input type="Year" class="form-control" name='student_name' id='student_name'  value="{{ old('student_name')  }}">
                                    <span class="help-block">Full Name</span>
                                </div>
                                <div class="form-group{{ $errors->has('aadhar_No') ? ' has-error' : '' }}">
                                    <label>Student Aadhaar</label>
                                    <input type="text" class="form-control" name='aadhar_No' id='aadhar_No'  value="{{ old('aadhar_No')  }}">
                                </div>
                                <div class="form-group{{ $errors->has('cast_category_setups_id') ? ' has-error' : '' }}">
                                    <label>Category<span class="text-danger">*</span></label>
                                    <select id="cast_category_setups_id"  class="select" name="cast_category_setups_id">
                                         <option value=''>--Select--</option>
                                        @if(count(getCategory())>0)
                                            @foreach(getCategory() as $castCategores)
                                             <option value='{{$castCategores->id}}' <?php echo old('cast_category_setups_id')==$castCategores->id?"selected":"";?>>{{$castCategores->category_initial}}</option>   
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
                                    <input type="text" class="form-control" name='last_attended_class', id='last_attended_class'  value="{{ old('last_attended_class')  }}">
                                    
                                </div>
                                <div class="form-group{{ $errors->has('mark_identification') ? ' has-error' : '' }}">
                                    <label>Mark Identification</label>
                                    <input type="text" class="form-control" name='mark_identification', id='mark_identification'  value="{{ old('mark_identification')  }}">
                                   
                                </div>
                            </div>
                            <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                            <label>Student DOB<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='dob', id='dob'  value="{{ old('dob')  }}">
                                            <span class="help-block">DOB formate:dd-mm-yyy</span>
                                           
                                        </div>
                                         <div class="form-group{{ $errors->has('gender ') ? ' has-error' : '' }}">
                                            <label>Gender  <span class="text-danger">*</span></label>
                                            <select id="gender"  class="select" name="gender" >
                                                <option value=''>--Select--</option>
                                                <option value='0' <?php echo old('status')==0?"selected":"";?>>Male</option>   
                                                <option value='1' <?php echo old('status')==1?"selected":"";?>>Female</option>
                                                <option value='2' <?php echo old('status')==2?"selected":"";?>>Other</option>
                                            </select>
                                             @if ($errors->has('gender'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('religions_id') ? ' has-error' : '' }}">
                                            <label>Religions<span class="text-danger">*</span></label>
                                            <select id="religions_id"  class="select" name="religions_id">
                                                 <option value=''>--Select--</option>
                                                @if(count(getReligions())>0)
                                                    @foreach(getReligions() as $religion)
                                                     <option value='{{$religion->id}}' <?php echo old('religions_id')==$religion->id?"selected":"";?>>{{$religion->short_name}}</option>
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
                                            <input type="text" class="form-control" name='last_attended_school' id='last_attended_school'  value="{{ old('last_attended_school')  }}">
                                            
                                        </div>
                                        <div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                            <label>Blood Group</label>
                                            <input type="text" class="form-control" maxlength="5" name='blood_group' id='blood_group'  value="{{ old('blood_group')  }}">
                                        </div>
                                    </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-semibold">Parent’s Information</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                    <label>Father's Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='father_name', id='father_name'  value="{{ old('father_name')  }}">
                                   
                                </div>

                                <div class="form-group{{ $errors->has('father_occupation') ? 'has-error' : '' }}">
                                    <label>Father Occupation </label>
                                    <input type="text" class="form-control" name='father_occupation', id='father_occupation'  value="{{ old('father_occupation')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('father_qualification') ? 'has-error' : '' }}">
                                    <label>Father Qualification</label>
                                    <input type="text" class="form-control" name='father_qualification', id='father_qualification'  value="{{ old('father_qualification')  }}">
                                 </div>
                                <div class="form-group{{ $errors->has('father_mobile_no') ? 'has-error' : '' }}">
                                    <label>Father Mobile No.<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" maxlength='10' name='father_mobile_no' id='father_mobile_no'  value="{{ old('father_mobile_no')  }}">
                                </div>
                                <div class="form-group{{ $errors->has('father_email') ? 'has-error' : '' }}">
                                    <label>Father Email</label>
                                    <input type="text" class="form-control"name='father_email' id='father_email'  value="{{ old('father_email')  }}">
                                </div>
                                <div class="form-group{{ $errors->has('father_whatsapp_mobile') ? 'has-error' : '' }}">
                                    <label>Father Whatsapp No</label>
                                    <input type="text" class="form-control" maxlength='10' name='father_whatsapp_mobile' id='father_whatsapp_mobile'  value="{{ old('father_whatsapp_mobile')  }}">
                                </div>
                                 <div class="form-group{{ $errors->has('fathere_income') ? 'has-error' : '' }}">
                                    <label>Annual Income </label>
                                    <input type="text" class="form-control" maxlength='7' name='fathere_income' id='fathere_income'  value="{{ old('fathere_income')  }}">
                                </div>

                                  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label>Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='address', id='address'  value="{{ old('address')  }}">
                                 </div>

                                 <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label>City<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control typeahead " name='city', id='city'  value="{{ old('city')  }}">
                                 </div>

                                
                                        
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('mothers_name') ? ' has-error' : '' }}">
                                    <label>Mother's Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='mothers_name', id='mothers_name'  value="{{ old('mothers_name')  }}">
                                 </div>

                                <div class="form-group{{ $errors->has('mother_occup') ? 'has-error' : '' }}">
                                    <label>Mother Occupation </label>
                                    <input type="text" class="form-control" name='mother_occup', id='mother_occup'  value="{{ old('mother_occup')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_qalification') ? 'has-error' : '' }}">
                                    <label>Mother Qualification</label>
                                    <input type="text" class="form-control" name='mother_qalification', id='mother_qalification'  value="{{ old('mother_qalification')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_mobile_no') ? ' has-error' : '' }}">
                                    <label>Mother's Mobile</label>
                                    <input type="text" class="form-control" name='mother_mobile_no' id='mother_mobile_no'  value="{{ old('mother_mobile_no')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_whatsapp_no') ? ' has-error' : '' }}">
                                    <label>Mother's Whatsapp No</label>
                                    <input type="text" class="form-control" name='mother_whatsapp_no' id='mother_whatsapp_no'  value="{{ old('mother_whatsapp_no')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('guardian_name') ? 'has-error' : '' }}">
                                    <label>Guardian Name</label>
                                    <input type="text" class="form-control" name='guardian_name', id='guardian_name'  value="{{ old('guardian_name')  }}">
                                 </div>

                                 <div class="form-group{{ $errors->has('guardian_occupation') ? 'has-error' : '' }}">
                                    <label>Guardian Occupation</label>
                                    <input type="text" class="form-control" name='guardian_occupation', id='guardian_occupation'  value="{{ old('guardian_occupation')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_qalification') ? 'has-error' : '' }}">
                                    <label>Guardian Qualification</label>
                                    <input type="text" class="form-control" name='guardian_qualification', id='guardian_qualification'  value="{{ old('guardian_qualification')  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('guardian_mobile') ? 'has-error' : '' }}">
                                    <label>Guardian Mobile</label>
                                    <input type="text" class="form-control" name='guardian_mobile' id='guardian_mobile'  value="{{ old('guardian_mobile')  }}">
                                 </div>

                            </div>
                             <div class="col-md-12"><hr></div>
                              <div class="col-md-6">
                                     <legend class="text-semibold"><i class="icon-reading position-left"></i> Relatives who reads this school (First)</legend>
                                    <div class="form-group{{ $errors->has('relatives_first_name') ? 'has-error' : '' }}">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name='relatives_first_name', id='relatives_first_name'   value="{{ old('relatives_first_name')  }}">
                                    </div>
                                    <div class="form-group{{ $errors->has('relative_first_class') ? ' has-error' : '' }}">
                                            <label>Class</label>
                                             <select id="relative_first_class"  class="select" name="relative_first_class" >
                                                <option value=''>--Select--</option>
                                                @if(count(getClasses())>0)
                                                    @foreach(getClasses() as $classe)
                                                     <option value='{{$classe->id}}' <?php echo old('relative_first_class')==$classe->id?"selected":"";?>>{{$classe->class_name}}</option>   
                                                      @endforeach
                                                @endif  
                                             </select>

                                             @if ($errors->has('relative_first_class'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('relative_first_class') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                              <div class="col-md-6">
                                    <legend class="text-semibold"><i class="icon-reading position-left"></i> Relatives who reads this school (Second)</legend>
                                    <div class="form-group{{ $errors->has('relative_second_name') ? 'has-error' : '' }}">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name='relative_second_name', id='relative_second_name'   value="{{ old('relative_second_name')  }}">
                                    </div>
                                    <div class="form-group{{ $errors->has('relative_second_class') ? ' has-error' : '' }}">
                                    <label>Class</label>
                                     <select id="relative_second_class"  class="select" name="relative_second_class" >
                                        <option value=''>--Select--</option>
                                        @if(count(getClasses())>0)
                                            @foreach(getClasses() as $classe)
                                             <option value='{{$classe->id}}' <?php echo old('relative_second_class')==$classe->id?"selected":"";?>>{{$classe->class_name}}</option>   
                                              @endforeach
                                        @endif  
                                     </select>

                                     @if ($errors->has('relative_second_class'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('relative_second_class') }}</strong>
                                        </span>
                                    @endif
                                  </div>

                                </div>  
                            
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-success stepy-finish btn-loading" data-loading-text="<i class='icon-spinner4 spinner position-left'></i> Loading state">Submit <i class="icon-check position-right"></i></button>
                </form>
            </div>
        </div>
        <!-- /content area -->
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/wizards/stepy.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/pages/wizard_stepy.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('#dob').mask('00-00-0000');
      $('#reg_date').mask('00-00-0000');
    });
</script>
@endsection
