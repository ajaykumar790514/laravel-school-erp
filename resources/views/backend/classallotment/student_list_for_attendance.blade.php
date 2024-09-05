@extends('layouts.admin-theme')
@section('content')
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> 
              <span class="text-semibold">Attendance</span> ->Menu->Student List For Attendance ({{$sessionName}}-->{{$className}}->{{$sectionName}})</h4>
            </div>
         </div>
    </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
           @include('layouts.massage') 
           @include('layouts.validation-error')
           <!-- Vertical form options -->
              <div class="panel panel-flat">
                 
                  <div class="panel-heading">
                      @can('classes-attendance')
		                   <a href="{{ url('attendance/classes-attendance')}}" class="btn btn-primary"><i class="icon-arrow-left52 position-left"></i>Classes List For Attendance</a>
		              @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <form class="" method="POST" action='{{ url("/attendance/take-attendance/{$sessionIds}/{$classsetupIds}/{$sectionID}")}}'>
                    {{ csrf_field() }}
                    <div class="panel-body table-responsive">
                        <table class="table datatable-basic" >
                        <thead class="thead-dark">
                  <tr role="row">
                     <th>Id</th>
                     <th>Roll No.</th>
                     <th>Name</th>
                     <th>Father Name</th>
                     <th >Action</th>
                  </tr>
               </thead>
                        <tbody>
                            @if(count($data)>0)
                                <?php $i=1;?>
                                @foreach($data as $studentDetails)
                                    <tr>
                                         <td>{{$i}}</td>
                                         <td>{{$studentDetails->roll_no}}</td>
                                         <td>{{$studentDetails->student_name}}</td>
                                         <td>{{$studentDetails->father_name}}</td>
                                        <td><div class="form-group">
                                <label class="radio-inline radio-right">
                                  <input type="radio" name="attendanceReport[{{$studentDetails->student_id}}]" value="0" checked="checked" class="control-primary">
                                  Present
                                </label>
            
                                <label class="radio-inline radio-right text-danger">
                                  <input type="radio" name="attendanceReport[{{$studentDetails->student_id}}]" value="1" >
                                  Absent
                                </label>
                              </div>
                            </td>
                                    </tr>
                                    <?php $i++;?>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                        <div class="panel-body">
                        <div class="col-md-12">
                        <div class="row">
                        <div class="col-md-4">
                            <fieldset>
                               <div class="form-group{{ $errors->has('attendeance_date') ? ' has-error' : '' }}">
                                <label>Attendance<span class="text-danger">*</span></label>
                               <input type="date" class="form-control" name='attendeance_date', id='attendeance_date'  value="{{ date('Y-m-d')  }}">
                               @if ($errors->has('attendeance_date'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('attendeance_date') }}</strong>
                                                </span>
                                            @endif
                               <span class="help-block">Joining. Date formate:dd-mm-yyy</span>
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
                    </div>
                    </form>
                    </div>
  
</div>
@endsection
@section('script')  
<script type="text/javascript" src="{{ asset('admin/js/pages/datatables_basic.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
@endsection