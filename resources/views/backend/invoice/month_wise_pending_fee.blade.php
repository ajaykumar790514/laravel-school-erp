@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fee Madule</span>->Reports->Month Wise Fee Pending</h4>
                        </div>
                      </div>
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    @include('layouts.massage') 
                    @include('layouts.validation-error') 
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('month-wise-pending-fee')}}" >
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('curent_month') ? ' has-error' : '' }}">
                                            <label>Select Month<span class="text-danger">*</span></label>
                                             <select id="curent_month"  class="form-control select" name="curent_month" >
                                                <option value=''>--Select--</option>
                                                @foreach($month as $months)
                                                <option value='{{$months->id}}' {{ $curent_month==$months->id?"selected":""}}>{{$months->month_name}}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                     </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('sessionId') ? ' has-error' : '' }}">
                                            <label>Select Session<span class="text-danger">*</span></label>
                                             <select id="sessionId"  class="form-control select" name="sessionId" >
                                                <option value=''>--Select--</option>
                                                @if(count(getSession())>0)
                                                    @foreach(getSession() as $sessionDetails)
                                                     <option value='{{$sessionDetails->id}}' <?php echo $sessionId==$sessionDetails->id?"selected":"";?>>{{$sessionDetails->session_name}}</option>   
                                                      @endforeach
                                                @endif  
                                            </select>
                                           </div>
                                     </fieldset>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                            <label>Class<span class="text-danger">*</span></label>
                                             <select id="class_id"  class="form-control select" name="class_id" >
                                                <option value=''>--Select--</option>
                                                @if(count(getClasses())>0)
                                                    @foreach(getClasses() as $class)
                                                     <option value='{{$class->id}}' <?php echo $class_id==$class->id?"selected":"";?>>{{$class->class_name}}</option>   
                                                      @endforeach
                                                @endif  
                                            </select>
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
                    <div class="panel panel-flat">
                        @if(count($data)>0)
                            <div class="panel-heading">
                                <div class="row">
                                <div class="col-md-4"><h6>Student List for Class Allotments (Total:{{count($data)}})</h6></div>
                                <div class="col-md-8 float-left">
                                   <a href='{{ url("export_month-wise-pending-fee/{$curent_month}/{$sessionId}/{$class_id}")}}' class="btn btn-primary"></i>Download Report</a>
                                </div>
                            </div>
                                        
                                         <div class="heading-elements">
                                          <ul class="icons-list">
                                            <li><a data-action="collapse"></a></li>
                                            <li><a data-action="close"></a></li>
                                          </ul>
                                        </div>
                                    </div>
                            <div class="panel-body table-responsive">
                                <table class="table datatable-basic">
            							<thead class="thead-dark">
                                          <tr role="row">
                                             <th>Admission No</th>
                                             <th>Roll No. </th>
                                             <th>Name</th>
                                             <th>Father Name</th>
                                             <th>Mobile</th>
                                             <th>Gender</th>
                                             <th>Action</th>
                                          </tr>
                                        </thead>
            						
            							<tbody>
            							     @if(count($data)>0)
                                               @foreach($data as $dataDetails)
                                                   <?php $studentClassAttment=base64_encode($dataDetails->studentAllmentId);?>
                                                    <tr role="row">
                                                         <td>{{$dataDetails->admission_no}}</td>
                                                        <td>{{$dataDetails->roll_no}}</td>
                                                         <td>{{$dataDetails->student_name}}</td>
                                                         <td>{{$dataDetails->father_name}}</td>
                                                         <td>{{$dataDetails->father_mobile_no}}</td>
                                                         <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
                                                         <td> @can('fee-collection')
                                                         <a href='{{url("fee-collection/{$studentClassAttment}")}}' >Collect Fee</a>
                                                         @endcan
                                                         </td>
                                                  </tr>
                                                @endforeach 
                                            @endif
            							</tbody>
            						</table>
                            </div>
                         @else
                               <div class="panel-heading">
                                <h6>{{config('app.emptyrecords')}}</h6>
                                 
                            </div>
                        @endif
                    </div>
               
                </div>
@endsection
@section('script') 
<script type="text/javascript" src="{{ asset('admin/js/pages/datatables_basic.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <!-- /page container -->
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
