@extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee</span> ->Employee View</h4>
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
                    <h5 class="panel-title">Official Information </h5>
                    <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                 <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                  </div>

                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Joining Dt.:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ date('d F Y',strtotime($data->joining_dt))}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Employee Type :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->employee_type==0?'Teacher':"Staff & Other"}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Employee Category:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->employee_category==0?'Permanent':'Guest/Visiting'}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Designation  :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->designation_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Department  :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->department_name}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mobile(Whatsapp) :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->mobile_whatsapp}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mobile Secondary :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->mobile_secondary}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Address :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->address}}, {{$data->city}}, {{$data->pincode}}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Qualification:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->qalification==""?"NA":$data->qalification }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Specialization:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->specialization }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Blood Group:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->bloud_group }}</div>
                      </div>
                    </div>
                    

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Email :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->email }}</div>
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
                    <h5 class="panel-title">Employee Information</h5>
                    <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                 <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                  </div>

                  <div class="panel-body">
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Employee Name:</label>
                      <div class="col-lg-4">
                        <div class="form-control-static text-semibold">{{ $data->employee_name}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Father/Husband's Name:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->father_husband_name}}</div>
                      </div>
                    </div>

                   <div class="form-group">
                      <label class="col-lg-4 control-label">Mother/Wife's Name:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->mother_wife_name }}</div>
                      </div>
                    </div>

                   <div class="form-group">
                      <label class="col-lg-4 control-label">Gender:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">
                          @if($data->gendre==0)
                           Male
                           @elseif($data->gendre==1)
                           Female
                           @else
                           Other
                           @endif
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Employee DOB:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ date('d F Y', strtotime($data->dob))}}</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Marital Status:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->marital_status=="0"?"Married":'Un-Married' }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Adhara No:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->aadhar_no==""?"NA":$data->aadhar_no }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">PAN:</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->pan_no==""?"NA":$data->pan_no }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Religion :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->short_name==""?"NA":$data->short_name }}</div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-lg-4 control-label">Mark of Identification :</label>
                      <div class="col-lg-8">
                        <div class="form-control-static text-semibold">{{ $data->mark_aditification }}</div>
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
                <h5 class="panel-title">Employee Documents</h5>
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
                          @can('employees-delete-documents')
                          <?php $id=base64_encode($documents->id);?>
                          <li>
                             <a href='{{url("employees-delete-documents/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i class=' icon-cancel-circle2'></i> Delete</a>
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



