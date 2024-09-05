@extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Class Promotion</h4>
                        </div>
                      </div>
        
                </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('student-class-promotion')}}" >
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('student-promotion-list')
                                   <a href="{{ url('student-promotion-list')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Student Class Promotion List</a>
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
                                    <div class="col-md-3">
                                        <fieldset>
                                           
                                           <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                            <label>Session <span class="text-danger">*</span></label>
                                            <select id="session_id"  class="form-control" name="session_id" >
                                               
                                                @if(count($sessions)>0)
                                                    @foreach($sessions as $section)
                                                     <option value='{{$section->id}}' <?php echo $session_id==$section->id?"selected":"";?> >{{$section->session_name}}</option>   
                                                      @endforeach
                                                @endif    
                                                
                                            </select>
                                           </div>
                                     </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('class_maping_id') ? ' has-error' : '' }}">
                                            <label>Class/Section <span class="text-danger">*</span></label>
                                                 <select id="class_maping_id"  class="form-control select" name="class_maping_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($classesmaping)>0)
                                                    @foreach($classesmaping as $classesmapings)
                                                     <option value='{{$classesmapings->class_maping_id}}' <?php echo $class_id==$classesmapings->class_maping_id?"selected":"";?>>{{$classesmapings->section_name}}</option>   
                                                      @endforeach
                                                @endif  
                                            </select>
                                            @if ($errors->has('class_maping_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('class_maping_id') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                           
                                     </fieldset>
                                        
                                    </div>
                                    
                                      <div class="col-md-3">
                                        <fieldset>
                                            <div class="form-group" style="margin-top: 26px;">
                                             
                                                 <button type="submit" class="btn btn-default"><i class="icon-zoomin3 position-left"></i> Search Student </button>
                                             
                                     </div>
                                        </fieldset>
                                    </div>

                                </div>

                               
                            </div>
                        </div>
                    </form>
                <form class="" method="POST" action='{{ url("/promoted")}}'>
                    {{ csrf_field() }}
                    <div class="panel panel-flat">
                         @if(count($data)>0)
                        <div class="panel-heading">
                            <h6>Student List for Class Promotion</h6>
                             <div class="heading-elements">
                              <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                        </div>
                            <div class="panel-body table-responsive">
                                <table class="table  table-bordered  table-hover " id="domainTable">
                               <thead class="thead-dark">
                                  <tr role="row">
                                     <th><input id="selectAllDomainList"   type="checkbox" onclick="countCheckbox()" name="sellectAll"></th>
                                     <th>Name</th>
                                     <th>Father Name</th>
                                     <th>Mobile</th>
                                     <th>Address</th>
                                     <th>Gender</th>
                                     <th >Created at</th>
                                  </tr>
                                </thead>
                                   @if(count($data)>0)
                                   @foreach($data as $dataDetails)
                                    <tr role="row">
                                         <td>
                                          <?php if($dataDetails->performeance_status==2){?>
                                            Released
                                         <?php }elseif($dataDetails->performeance_status==1){?>
                                             Fail
                                          <?php }elseif($dataDetails->performeance_status==0){?>
                                            Passed
                                          <?php }elseif($dataDetails->performeance_status==3){?>
                                          <input id="sellectAll" type="checkbox" value="{{$dataDetails->classAllotmentID}}" onclick="countCheckbox()" name="studentid[]">
                                          <?php }?>
                                          
                                        </td>
                                         <td>{{$dataDetails->student_name}}</td>
                                         <td>{{$dataDetails->father_name}}</td>
                                         <td>{{$dataDetails->mobile_whatsapp==""?$dataDetails->parentsmobile:$dataDetails->mobile_whatsapp}}</td>
                                         <td>{{$dataDetails->address}}</td>
                                         <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
                                         <td >{{ date('d F Y', strtotime($dataDetails->created_at))}}</td>
                                  </tr>
                                    @endforeach 
                                 @else
                                    <tr>
                                        <th colspan="7" style="text-align: center;"> {{config('app.emptyrecords')}}</th>
                                </tr>
                                @endif
                                </table>
                            </div>
                          <div class="panel-body table-responsive">
                                <div class="col-md-12">
                               
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <fieldset>
                                                       <div class="form-group{{ $errors->has('Alloted_session_id') ? ' has-error' : '' }}">
                                                        <label>Session<span class="text-danger">*</span></label>
                                                        <select id="Alloted_session_id"  class="form-control" name="Alloted_session_id" >
                                                            <option value=''>--Select--</option>
                                                            @if(count($sessions)>0)
                                                                @foreach($sessions as $section)
                                                                 <option value='{{$section->id}}' <?php echo old('Alloted_session_id')==$section->id?"selected":"";?> >{{$section->session_name}}</option>   
                                                                  @endforeach
                                                            @endif   
                                                           
                                                        </select>
                                                      </div>
                                                 </fieldset>
                                                </div>
                                                <div class="col-md-4">
                                                    <fieldset>
                                                       <div class="form-group{{ $errors->has('section_setup_id') ? ' has-error' : '' }}">
                                                        <label>Class/Section<span class="text-danger">*</span></label>
                                                        <select id="section_setup_id"  class="form-control select" name="section_setup_id" >
                                                            <option value=''>--Select--</option>
                                                            @if(count($sections)>0)
                                                                @foreach($sections as $section)
                                                                 <option value='{{$section->id}}' <?php echo old('section_setup_id')==$section->id?"selected":"";?>>{{$section->section_name}}</option>   
                                                                  @endforeach
                                                            @endif  
                                                           
                                                        </select>
                                                        @if ($errors->has('section_setup_id'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('section_setup_id') }}</strong>
                                                            </span>
                                                        @endif
                                                      </div>
                                                 </fieldset>
                                                </div>
                                                
                                                  <div class="col-md-4">
                                                    <fieldset>
                                                        <div class="form-group" style="margin-top: 26px;">
                                                            <button type="submit"  class="btn btn-success"><i class=" icon-users4 position-left"></i>Click here to Promotion<span id="allotmentBtn"></span> </button>
                                                        </div>
                                                    </fieldset>
                                                </div>

                                            </div>
                              
                                </div>
                          </div> 
                     @else
                           <div class="panel-heading">
                            <h6>{{config('app.emptyrecords')}}</h6>
                             
                        </div>
                    @endif
                    </div>
                </form>
                
              
                </div>
@endsection
@section('script')
    <script type="text/javascript">
         function countCheckbox(){
            $("#allotmentBtn").empty();
            var numberAll = $('input[type="checkbox"]:checked').length
          $("#allotmentBtn").append(" (Total Selected Students "+numberAll+")");
        }
        $('#selectAllDomainList').click (function () {
             var checkedStatus = this.checked;
            $('#domainTable tbody tr').find('td:first :checkbox').each(function () {
                $(this).prop('checked', checkedStatus);
             });
            $("#allotmentBtn").empty();
            var numberAll = $('input[type="checkbox"]:checked').length
             var totalStudents=parseInt(numberAll)-1;
                $("#allotmentBtn").append(" (Total Selected Students "+totalStudents+")");
            
            
        });

       
    </script>
@endsection
