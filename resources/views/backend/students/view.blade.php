 @extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Student View</h4>
            </div>
         </div>
        
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
          <!-- Horizontal form options -->
          <div class="row">
            @include('layouts.massage') 
            <div class="col-md-6">
              <!-- Static mode -->
              <form class="form-horizontal" action="#">
                <div class="panel panel-flat">
                  <div class="panel-heading">
                      <div class="row">
                          <div class="col-md-6"><h5 class="panel-title">Student Information </h5></div>
                          <div class="col-md-6">
                                @can('student-edit')
                                    <a href='{{ url("student-edit/{$id}")}}' class="btn btn-primary"></i>Edit Student Details</a>
                                @endcan
                          </div>
                      </div>
                    <div class="heading-elements">
                        
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                 <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                  </div>

                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Admission No:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->admission_no}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Reg. Date :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ date('d F Y', strtotime($data->reg_date))}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Session:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->sessionsetup->session_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Class :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->classsetup->class_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Admission Date :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ Carbon\Carbon::parse($data->created_at)->format('d F Y H:m:s')}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Student Name :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->student_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Student Email :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->email==""?"NA":$data->email}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">whatsapp Mobile :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->mobile_whatsapp}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Secondary Mobile :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->secondary_mobile==""?"NA":$data->secondary_mobile }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">DOB :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ Carbon\Carbon::parse($data->dob)->format('d F Y')}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Gender :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->gender==0?"Male":"Female"}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Aadhaar No. :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->aadhar_No==""?"NA":$data->aadhar_No}}</div>
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-lg-3 control-label">Religion :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{@$data->religions->short_name}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Category :</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ @$data->castcategory->category_initial}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label"> Last Attended Class :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->last_attended_class==""?"NA":$data->last_attended_class}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Last Attended School  :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->last_attended_school==""?"NA":$data->last_attended_school}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Blood Group  :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->blood_group==""?"NA":$data->blood_group}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mark of Identification  :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->mark_identification==""?"NA":$data->mark_identification}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Address:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->address }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">City:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->city }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <!-- /static mode -->
            </div>
            <div class="col-md-6">

              <!-- Static mode -->
              <form class="form-horizontal" action="#">
                <div class="panel panel-flat">
                  <div class="panel-heading">
                       <div class="row">
                          <div class="col-md-6"><h5 class="panel-title">Parent’s Information</h5></div>
                          <div class="col-md-6">
                                @can('parents-edit')
                                    <?php $parentsID=base64_encode($data->parent_id);?>
                                    <a href='{{ url("parents-edit/{$parentsID}/{$id}")}}' class="btn btn-primary"></i>Edit Parents Details</a>
                                @endcan
                          </div>
                      </div>
                    
                    <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                 <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                  </div>
                  
                  <?php $id=base64_encode(@$parentsLoginDetail->id);?>
                  <div class="panel-body">
                      <h6 class="panel-title">Parent Login</h6>
                      <ul id="" class="icons-list">
                        <li ><span class='text-semibold'>User Name : </span>{{@$parentsLoginDetail->email}}</li>
                        <li ><span class='text-semibold'>Status </span>:{{@$parentsLoginDetail->status==0?"Active":"Inactive"}} </li>
                        <?php if($id!=''){?>
                        <li ><a class="btn btn-primary btn-xs" href='{{url("/admission/parentloginedit/{$id}")}}'>Update/Change Password</a></li>
                      <?php } ?>
                        </ul>
                        <hr>
                  </div>
                 
                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Name:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Occupation:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_occupation==""?"NA":$data->parents->father_occupation}}</div>
                      </div>
                    </div>

                   <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Qualification:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_qualification==""?"NA":$data->parents->father_qualification }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Mobile No:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_mobile_no }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Whatsapp No:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_whatsapp_mobile }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Income:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->fathere_income }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Father's Email:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->father_email }}</div>
                      </div>
                    </div>

                   <div class="form-group">
                      <label class="col-lg-3 control-label">Mother's Name:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->mothers_name==""?"NA":$data->parents->mothers_name }}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-3 control-label">Mother's Occupation:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->mother_occup==""?"NA":$data->parents->mother_occup }}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mother's Qualification:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->mother_qalification==""?"NA":$data->parents->mother_qalification }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mother's Mobile:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->mother_mobile_no }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mother's Whatsapp:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->mother_whatsapp_no }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-3 control-label">Guardian Name:</label>
                      <div class="col-lg-9">
                        <div class="form-control-static text-semibold">{{ $data->parents->guardian_name==""?"NA":$data->parents->guardian_name }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Guardian Occupation:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->guardian_occupation==""?"NA":$data->parents->guardian_occupation }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Guardian Qualification:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->parents->guardian_qualification==""?"NA":$data->parents->guardian_qualification }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-5 control-label">Guardian Mobile:</label>
                      <div class="col-lg-7">
                        <div class="form-control-static text-semibold">{{ $data->parents->guardian_mobile}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-6 control-label">Relatives who reads in this school (First)  :</label>
                      <div class="col-lg-6">
                        <div class="form-control-static text-semibold">{{ $data->parents->relatives_first_name==""?"NA":$data->parents->relatives_first_name }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-6 control-label">Relatives who reads in this school class  :</label>
                      <div class="col-lg-6">
                        <div class="form-control-static text-semibold">{{ $data->parents->relative_first_class==""?"NA":App\Models\ClassSetups::getClassName($data->parents->relative_first_class) }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-6 control-label">Relatives who reads in this school (Second)  :</label>
                      <div class="col-lg-6">
                        <div class="form-control-static text-semibold">{{ $data->parents->relative_second_name==""?"NA":$data->parents->relative_second_name }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-6 control-label">Relatives who reads in this school class  :</label>
                      <div class="col-lg-6">
                        <div class="form-control-static text-semibold">

                          {{ $data->parents->relative_second_class==""?"NA":App\Models\ClassSetups::getClassName($data->parents->relative_second_class) }}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <!-- /static mode -->
            </div>
          </div>
          <!-- /vertical form options -->



          <!-- 2 columns form -->
          
            <div class="panel panel-flat">
              <div class="panel-heading">
                <h5 class="panel-title">Student Documents (
                @can('student-upload-documents')
                   <?php $id=base64_encode($data->id);?>
                    <a href='{{url("/student-upload-documents/{$id}")}}' class=''>
                        <i style="color: #f25320" class='icon-upload4 danger'></i> Upload Documents</a>
                        
                @endcan
                )
                </h5>
                <div class="heading-elements">
                  <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="close"></a></li>
                  </ul>
                </div>
              </div>

              <div class="panel-body">
                <div class="row">
                  @foreach($documentsData as $documents)   
                  <div class="col-lg-3 col-sm-6">
                    <div class="thumbnail">
                      <div class="thumb">
                        <img src="/public/{{ $documents->documents}}" alt="">
                        <div class="caption-overflow">
                          <span>
                            <a href="/public/{{ $documents->documents}}" data-popup="lightbox" class="btn border-white text-white btn-flat btn-icon btn-rounded"><i class="icon-plus3"></i></a>
                            
                          </span>
                        </div>
                      </div>
                      <div class="caption">
                      <h6 class="no-margin-top text-semibold">{{$documents->name}} <ul class="icons-list dropdown-menu-right">
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <i class="icon-menu9"></i>
                            </a>
    
                            <ul class="dropdown-menu dropdown-menu-right">
                              @can('student-delete-documents')
                              <?php $id=base64_encode($documents->id);?>
                              <li>
                                 <a href='{{url("/student-delete-documents/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i class=' icon-cancel-circle2'></i> Delete</a>
                                </li>
                               @endcan
                            </ul>
                          </li>
                        </ul></h6>
                     
                    </div>
    
                    </div>
                  </div>
                  @endforeach
                </div>

              </div>
            </div>
         
        </div>
@endsection    


