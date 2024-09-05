@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span>->Reports->Student Search</h4>
                        </div>
                      </div>
        
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('student-search')}}" >
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 
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
                                    <div class="col-md-4">
                                        <fieldset>
                                           
                                           <div class="form-group{{ $errors->has('student_name') ? ' has-error' : '' }}">
                                            <label>Student Name</label>
                                             <input type="text" class="form-control" name='student_name', id='student_name'  value="{{ old('student_name')  }}">
                                           </div>
                                     </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset>
                                           
                                           <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                            <label>Father Name</label>
                                             <input type="text" class="form-control" name='father_name', id='father_name'  value="{{ old('father_name')  }}">
                                           </div>
                                     </fieldset>
                                        
                                    </div>
                                      <div class="col-md-4">
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
                            <h6>Student List ({{count($data)}})</h6>
                             <div class="heading-elements">
                              <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                        </div>
                            <div class="panel-body table-responsive">
                                <table class="table  table-bordered  table-hover " id="domainTable">
                               <thead style="background-color: #eaeded ">
                                  <tr role="row">
                                     <th>S.No.</th>
                                     <th>Name</th>
                                     <th>Father Name</th>
                                     <th>Mobile</th>
                                     <th>Address</th>
                                     <th>Gender</th>
                                     <th >Registration Date</th>
                                     <th>Action</th>
                                  </tr>
                                </thead>
                                   <?php $i=1;?> 
                                   @if(count($data)>0)
                                   @foreach($data as $dataDetails)
                                   <?php $studentIds=base64_encode($dataDetails->id);?>
                                    <tr role="row">
                                         <td>{{$i}}</td>
                                         <td>{{$dataDetails->student_name}}</td>
                                         <td>{{$dataDetails->father_name}}</td>
                                         <td></td>
                                         <td>{{$dataDetails->address}}</td>
                                         <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
                                         <td >{{ date('d F Y', strtotime($dataDetails->created_at))}}</td>
                                         <td><a href='{{ url("student-records/{$studentIds}")}}'><i class="icon-magazine"></i> Student Records</a></td>
                                  </tr>
                                  <?php $i++;?>
                                    @endforeach 
                                 @else
                                    <tr>
                                        <th colspan="7" style="text-align: center;"> {{config('app.emptyrecords')}}</th>
                                </tr>
                                @endif
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
