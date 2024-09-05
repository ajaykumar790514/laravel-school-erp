@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Employee List For Attendance </h4>
            </div>
         </div>
        
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
           @include('layouts.massage') 
           <!-- Vertical form options -->
              <div class="panel panel-flat">
               
                  <div class="panel-heading">
                    @can('employee-attendance-register')
                   <a href="{{ url('/attendance/employee-attendance-register')}}" class="btn btn-primary"><i class="icon-user-check position-left"></i>Employee Attendance Register</a>
                    @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">

              <form class="" method="POST" action='{{ url("/attendance/employee_take_attendance")}}'>
                       {{ csrf_field() }}

            <table class="table table-xs" >
               <thead class="thead-dark">
                  <tr role="row">
                     <th>Id</th>
                     <th>Employee Type</th>
                     <th>Name</th>
                     <th>Father's Name</th>
                     <th>Mobile</th>
                     <th>Designation</th>
                     <th >Action</th>
                  </tr>
               </thead>
               <tbody>
              @if(count($data)>0)
                <?php $i=1;?>
                    @foreach($data as $employeeDetails)
                    <?php //$id=base64_encode($session->id);?>
               <tr >
                 <td>{{$i}}</td>
                 <td><?php echo $employeeDetails->employee_type==0?"Teacher":"Staff";  ?></td>
                 <td>{{$employeeDetails->employee_name}}</td>
                 <td>{{$employeeDetails->father_husband_name}}</td>
                 <td>{{$employeeDetails->mobile_whatsapp}}</td>
                 <td>{{$employeeDetails->designation_name}}</td>
                 <td><div class="form-group">
                    <label class="radio-inline radio-right">
                      <input type="radio" name="attendanceReport[{{$employeeDetails->id}}]" value="0" checked="checked" class="control-primary">
                      Present
                    </label>

                    <label class="radio-inline radio-right text-danger">
                      <input type="radio" name="attendanceReport[{{$employeeDetails->id}}]" value="1" >
                      Absent
                    </label>
                    <label class="radio-inline radio-right text-danger">
                      <input type="radio" name="attendanceReport[{{$employeeDetails->id}}]" value="2" >
                      Half Time
                    </label>
                    <label class="radio-inline radio-right text-danger">
                      <input type="radio" name="attendanceReport[{{$employeeDetails->id}}]" value="3" >
                      Late
                    </label>
                  </div>
                </td>
               </tr>
               <?php $i++;?>
                @endforeach
                 </tbody>

              @endif
                
        </tfoot>
            </table>
            <div class="panel-body table-responsive">
                  <div class="col-md-12">
                 
                    <div class="row">
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('attendance_dt') ? ' has-error' : '' }}">
                                <label>Attendance<span class="text-danger">*</span></label>
                               <input type="date" class="form-control" name='attendance_dt' id='attendance_dt'  value="{{ date('Y-m-d')  }}">
                               @if ($errors->has('attendance_dt'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('attendance_dt') }}</strong>
                                                </span>
                                            @endif
                               <span class="help-block">Joining. Date formate:dd-mm-yyy</span>
                              </div>
                         </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                <label>Session<span class="text-danger">*</span></label>
                               <select id="session_id"  class="form-control" name="session_id" >
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
                         </fieldset>
                        </div>
                          <div class="col-md-4">
                            <fieldset>
                                <div class="form-group" style="margin-top: 26px;">
                                    <button type="submit"  class="btn btn-success"><i class=" icon-users4 position-left"></i>Submit Attendance Report<span id="allotmentBtn"></span> </button>
                                </div>
                            </fieldset>
                        </div>

                    </div>
                
                  </div>
          </div>
            </form>
          </div>
         </div>
  
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
      $('#attendance_dt').mask('00-00-0000');
      
    });
</script>
@endsection



