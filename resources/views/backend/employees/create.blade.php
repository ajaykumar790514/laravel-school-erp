@extends('layouts.admin-theme')
@section('content')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-users4 position-left"></i> <span class="text-semibold">Employee</span>->Menu->Register New Employee</h4>
            </div>
          </div>
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('employees-create')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="panel panel-flat">
                    @include('layouts.massage') 
                    @include('layouts.validation-error')
                    <div class="panel-heading">
                                @can('employees-list')
                                <a href="{{ url('employees-list')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Employee List</a>
                                @endcan
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                        <fieldset>
                                            <legend class="text-semibold"><i class=" icon-office position-left"></i>Official Information</legend>
                                             <div class="form-group{{ $errors->has('joining_dt') ? ' has-error' : '' }}">
                                            <label>joining Dt.<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name='joining_dt', id='joining_dt'  value="{{ date('Y-m-d')  }}">
                                            <span class="help-block">Joining. Date formate:dd-mm-yyyy</span>
                                        </div>
                                            <div class="form-group{{ $errors->has('employee_type') ? ' has-error' : '' }}">
                                                <label>Employee Type<span class="text-danger">*</span></label>
                                                <select id="employee_type"  class="select" name="employee_type" >
                                                    <option value=''>--Select--</option>
                                                    <option value='0' {{ old('employee_type')==0?"selected":""}}>Teacher</option>   
                                                    <option value='1' {{old('employee_type')==1?"selected":""}}>Staff & Other</option>
                                                </select>
                                             @if ($errors->has('employee_type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('employee_type') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('employee_category') ? ' has-error' : '' }}">
                                                <label>Employee Category<span class="text-danger">*</span></label>
                                                <select id="employee_category"  class="select" name="employee_category" >
                                                <option value=''>--Select--</option>
                                                <option value='0' <?php echo old('employee_category')==0?"selected":"";?>>Permanent</option>   
                                                <option value='1' <?php echo old('employee_category')==1?"selected":"";?>>Guest/Visiting</option>
                                                
                                            </select>
                                             @if ($errors->has('employee_category'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('employee_category') }}</strong>
                                                </span>
                                            @endif
                                            </div>

                                            <div class="form-group{{ $errors->has('designation_id') ? ' has-error' : '' }}">
                                                <label>Designation <span class="text-danger">*</span></label>
                                                 <select id="designation_id"  class="select" name="designation_id" >
                                                    <option value=''>--Select--</option>
                                                    @if(count(getDesig())>0)
                                                        @foreach(getDesig() as $Designation)
                                                         <option value='{{$Designation->id}}' <?php echo old('designation_id')==$Designation->id?"selected":"";?>>{{$Designation->designation_name}}</option>   
                                                          @endforeach
                                                    @endif  
                                                 </select>
                                                @if ($errors->has('designation_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('designation_id') }}</strong>
                                                    </span>
                                                @endif
                                          </div> 
                                          <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                                                <label>Department <span class="text-danger">*</span></label>
                                                 <select id="department_id"  class="select" name="department_id" >
                                                    <option value=''>--Select--</option>
                                                    @if(count(getDepartment())>0)
                                                        @foreach(getDepartment() as $department)
                                                         <option value='{{$department->id}}' <?php echo old('department_id')==$department->id?"selected":"";?>>{{$department->department_name}}</option>   
                                                          @endforeach
                                                    @endif  
                                                 </select>
                                                @if ($errors->has('department_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('department_id') }}</strong>
                                                    </span>
                                                @endif
                                          </div> 
                                          <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('mobile_whatsapp') ? ' has-error' : '' }}">
                                                        <label>Mobile (Whataspp number)<span class="text-danger">*</span></label>
                                                        <input type="text" name="mobile_whatsapp" value="{{ old('mobile_whatsapp')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('mobile_secondary') ? ' has-error' : '' }}">
                                                        <label>Mobile Secondary</label>
                                                        <input type="text" name="mobile_secondary" value="{{ old('mobile_secondary')  }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                                        <label>Address<span class="text-danger">*</span></label>
                                                        <input type="text" name="address" value="{{ old('address')  }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                                                        <label>Pincode</label>
                                                        <input type="text" name="pincode" value="{{ old('pincode')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                                        <label>City<span class="text-danger">*</span></label>
                                                        <input type="text" name="city" value="{{ old('city')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <input type="text" name="email" value="{{ old('email')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                     <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <select id="status"  class="form-control" name="status" >
                                                        <option value=''>--Select--</option>
                                                        <option value='0' {{ old('status')==0?"selected":""}}>Active</option>   
                                                        <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                                    </select>
                                                  </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                            <div class="col-md-6">
                                <fieldset>
                                            <legend class="text-semibold"><i class="icon-reading position-left"></i> Employee Information</legend>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('employee_name') ? ' has-error' : '' }}">
                                                        <label>Employee Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="employee_name" value="{{ old('employee_name')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('father_husband_name') ? ' has-error' : '' }}">
                                                        <label>Father/Husband's Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="father_husband_name" value="{{ old('father_husband_name')  }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('mother_wife_name') ? ' has-error' : '' }}">
                                                        <label>Mother/Wife's Name</label>
                                                        <input type="text" name="mother_wife_name" value="{{ old('mother_wife_name')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('gendre') ? ' has-error' : '' }}">
                                                    <label>Gender  <span class="text-danger">*</span></label>
                                                    <select id="gendre"  class="select" name="gendre" >
                                                        <option value=''>--Select--</option>
                                                        <option value='0' <?php echo old('gendre')==0?"selected":"";?>>Male</option>   
                                                        <option value='1' <?php echo old('gendre')==1?"selected":"";?>>Female</option>
                                                        <option value='2' <?php echo old('gendre')==2?"selected":"";?>>Other</option>
                                                    </select>
                                                     @if ($errors->has('gendre'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('gendre') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                                        <label>Employee DOB<span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" placeholder="dd-mm-yyy" name='dob' id='dob'  value="{{ old('dob')  }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('marital_status') ? ' has-error' : '' }}">
                                                    <label>Marital Status<span class="text-danger">*</span></label>
                                                    <select id="marital_status"  class="select" name="marital_status" >
                                                        <option value=''>--Select--</option>
                                                        <option value='0' <?php echo old('marital_status')==0?"selected":"";?>>Married</option>   
                                                        <option value='1' <?php echo old('marital_status')==1?"selected":"";?>>Un-Married</option>
                                                       
                                                    </select>
                                                     @if ($errors->has('marital_status'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('marital_status') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('aadhar_no') ? ' has-error' : '' }}">
                                                        <label>Aadhaar No.</label>
                                                        <input type="text" name="aadhar_no" value="{{ old('aadhar_no')  }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('pan_no') ? ' has-error' : '' }}">
                                                        <label>PAN</label>
                                                        <input type="text" name="pan_no" value="{{ old('pan_no')  }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('religions_id') ? ' has-error' : '' }}">
                                                <label>Religion <span class="text-danger">*</span></label>
                                                 <select id="religions_id"  class="select" name="religions_id" >
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
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('qalification') ? ' has-error' : '' }}">
                                                        <label>Qualification<span class="text-danger">*</span></label>
                                                        <input type="text" name="qalification" value="{{ old('qalification')  }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group{{ $errors->has('specialization') ? ' has-error' : '' }}">
                                                        <label>Specialization</label>
                                                        <textarea rows="2" cols="5" name="specialization" class="form-control">{{old('specialization')}}</textarea>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                            <div class="form-group{{ $errors->has('bloud_group') ? ' has-error' : '' }}">
                                                        <label>Blood Group</label>
                                                        <input type="text" name="bloud_group" value="{{ old('bloud_group')  }}" class="form-control">
                                                    </div>
                                            <div class="form-group">
                                                <label>Mark of Identification</label>
                                                <textarea rows="2" cols="5" name="mark_aditification" class="form-control" >{{old('mark_aditification')}}</textarea>
                                            </div>
                                            
                                        </fieldset>
                            </div>
                        </div>
                        <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit form <i class="icon-arrow-right14 position-right"></i></button>
                                </div>
                    </div>
                </div>
            </form>
        </div>
@endsection
@section('script') 
<script type="text/javascript">
    $(document).ready(function(){
     
    });
</script>
@endsection
