@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Menu->Edit Parents Details</h4>
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
                            
                             <a href='{{ url("student-view/{$studentID}")}}' class="btn btn-primary">Back</a>
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
                            <form class="stepy-clickable" method="POST" action='{{ url("parents-edit/{$id}/{$studentID}") }}' enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                            <label>Father's Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='father_name', id='father_name'  value="{{ $data->father_name }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('father_dob') ? ' has-error' : '' }}">
                                            <label>Father's Dob <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name='father_dob', id='father_dob'  value="{{ $data->father_dob }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('father_email') ? ' has-error' : '' }}">
                                            <label>Father's Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='father_email', id='father_email'  value="{{ $data->father_email }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('father_occupation') ? 'has-error' : '' }}">
                                            <label>Father Occupation </label>
                                            <input type="text" class="form-control" name='father_occupation' id='father_occupation'  value="{{  $data->father_occupation  }}">
                                         </div>
                                         <div class="form-group{{ $errors->has('father_qualification') ? 'has-error' : '' }}">
                                            <label>Father Qualification</label>
                                            <input type="text" class="form-control" name='father_qualification' id='father_qualification'  value="{{  $data->father_qualification  }}">
                                         </div>
                                        <div class="form-group{{ $errors->has('father_mobile_no') ? 'has-error' : '' }}">
                                            <label>Father Mobile No.<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" maxlength='10' name='father_mobile_no' id='father_mobile_no'  value="{{  $data->father_mobile_no }}">
                                        </div> 
                                        <div class="form-group{{ $errors->has('father_whatsapp_mobile') ? 'has-error' : '' }}">
                                            <label>Father Mobile No.<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" maxlength='10' name='father_whatsapp_mobile' id='father_whatsapp_mobile'  value="{{  $data->father_whatsapp_mobile }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('fathere_income') ? 'has-error' : '' }}">
                                            <label>Father Income</label>
                                            <input type="text" class="form-control"name='fathere_income' id='fathere_income'  value="{{ old('fathere_income')  }}">
                                        </div>
                                        <div class="form-group{{ $errors->has('father_whatsapp_mobile') ? 'has-error' : '' }}">
                                            <label>Father Whatsapp No</label>
                                            <input type="text" class="form-control" maxlength='10' name='father_whatsapp_mobile' id='father_whatsapp_mobile'  value="{{  $data->father_whatsapp_mobile }}">
                                        </div>
                                         <div class="form-group{{ $errors->has('fathere_income') ? 'has-error' : '' }}">
                                            <label>Annual Income </label>
                                            <input type="text" class="form-control" maxlength='7' name='fathere_income' id='fathere_income'  value="{{  $data->fathere_income  }}">
                                        </div>

                                          <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                            <label>Address<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='address' id='address'  value="{{  $data->address }}">
                                         </div>
        
                                         <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            <label>City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control typeahead " name='city' id='city'  value="{{  $data->city }}">
                                         </div>
                                         
                                        
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('mothers_name') ? ' has-error' : '' }}">
                                    <label>Mother's Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='mothers_name' id='mothers_name'  value="{{  $data->mothers_name }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_dob') ? ' has-error' : '' }}">
                                    <label>Mother's Dob<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name='mother_dob' id='mother_dob'  value="{{  $data->mother_dob }}">
                                 </div>

                                <div class="form-group{{ $errors->has('mother_occup') ? 'has-error' : '' }}">
                                    <label>Mother Occupation </label>
                                    <input type="text" class="form-control" name='mother_occup' id='mother_occup'  value="{{  $data->mother_occup  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_qalification') ? 'has-error' : '' }}">
                                    <label>Mother Qualification</label>
                                    <input type="text" class="form-control" name='mother_qalification' id='mother_qalification'  value="{{  $data->mother_qalification  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_mobile_no') ? ' has-error' : '' }}">
                                    <label>Mother's Mobile</label>
                                    <input type="text" class="form-control" name='mother_mobile_no' id='mother_mobile_no'  value="{{  $data->mother_mobile_no  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('mother_whatsapp_no') ? ' has-error' : '' }}">
                                    <label>Mother's Whatsapp No</label>
                                    <input type="text" class="form-control" name='mother_whatsapp_no' id='mother_whatsapp_no'  value="{{  $data->mother_whatsapp_no }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('guardian_name') ? 'has-error' : '' }}">
                                    <label>Guardian Name</label>
                                    <input type="text" class="form-control" name='guardian_name', id='guardian_name'  value="{{ old('guardian_name')  }}">
                                 </div>

                                 <div class="form-group{{ $errors->has('guardian_occupation') ? 'has-error' : '' }}">
                                    <label>Guardian Occupation</label>
                                    <input type="text" class="form-control" name='guardian_occupation' id='guardian_occupation'  value="{{  $data->guardian_occupation }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('guardian_qualification') ? 'has-error' : '' }}">
                                    <label>Guardian Qualification</label>
                                    <input type="text" class="form-control" name='guardian_qualification', id='guardian_qualification'  value="{{  $data->guardian_qualification  }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('guardian_mobile') ? 'has-error' : '' }}">
                                    <label>Guardian Mobile</label>
                                    <input type="text" class="form-control" name='guardian_mobile' id='guardian_mobile'  value="{{  $data->guardian_mobile }}">
                                 </div>
                                 <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            <label>City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control typeahead " name='city' id='city'  value="{{  $data->city }}">
                                         </div>
                                         <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                            <label>State<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control typeahead " name='state' id='state'  value="{{  $data->state }}">
                                         </div>
                            </div>
                             <div class="col-md-12"><hr></div>
                              <div class="col-md-6">
                                     <legend class="text-semibold"><i class="icon-reading position-left"></i> Relatives who reads this school (First)</legend>
                                    <div class="form-group{{ $errors->has('relatives_first_name') ? 'has-error' : '' }}">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name='relatives_first_name', id='relatives_first_name'   value="{{  $data->relatives_first_name  }}">
                                    </div>
                                    <div class="form-group{{ $errors->has('relative_first_class') ? ' has-error' : '' }}">
                                            <label>Class</label>
                                             <select id="relative_first_class"  class="select" name="relative_first_class" >
                                                <option value=''>--Select--</option>
                                                @if(count(getClasses())>0)
                                                    @foreach(getClasses() as $classe)
                                                     <option value='{{$classe->id}}' <?php echo $data->relative_first_class==$classe->id?"selected":"";?>>{{$classe->class_name}}</option>   
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
                                    <div class="form-group{{ $errors->has('relatives_first_name') ? 'has-error' : '' }}">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name='relative_second_name', id='relative_second_name'   value="{{ $data->relative_second_name }}">
                                    </div>
                                    <div class="form-group{{ $errors->has('relative_second_class') ? ' has-error' : '' }}">
                                    <label>Class</label>
                                     <select id="relative_second_class"  class="select" name="relative_second_class" >
                                        <option value=''>--Select--</option>
                                        @if(count(getClasses())>0)
                                            @foreach(getClasses() as $classe)
                                             <option value='{{$classe->id}}' <?php echo  $data->relative_second_class==$classe->id?"selected":"";?>>{{$classe->class_name}}</option>   
                                              @endforeach
                                        @endif  
                                     </select>

                                  </div>

                                </div>  
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="icon-add position-left"></i>Update Parends Details</button>
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
