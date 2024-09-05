@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
                  <div class="page-header-content">
                    <div class="page-title">
                      <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Reports->Student Records</h4>
                    </div>
                  </div>
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-flat">
                         @if(count($data)>0)
                            <div class="panel-heading">
                                <h6>Records Lis ({{count($data)}})</h6>
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
                                     <th>Id</th>
                                     <th>Session</th>
                                     <th>Class</th>
                                     <th>Section</th>
                                     <th>Roll Number</th>
                                     <th>Student Name</th>
                                     <th>Father Name</th>
                                     <th>Status</th>
                                     <th >Performance</th>
                                     
                                  </tr>
                                </thead>
                                   <?php $i=1;?> 
                                   @if(count($data)>0)
                                   @foreach($data as $dataDetails)
                                   <?php $studentIds=base64_encode($dataDetails->id);?>
                                    <tr role="row">
                                     <td>{{$i}}</td>
                                     <td>{{$dataDetails->session_name}}</td>
                                     <td>{{$dataDetails->class_name}}</td>
                                     <td>{{$dataDetails->section_name}}</td>
                                     <td>{{$dataDetails->roll_no}}</td>
                                     <td>{{$dataDetails->student_name}}</td>
                                     <td>{{$dataDetails->father_name}}</td>
                                     <td><?php
                                        if ($dataDetails->action_type==0) {
                                              echo 'Direct Admission';
                                          } else if($dataDetails->action_type==1){
                                              echo  'Promoted';
                                          } 

                                     ?></td>
                                     <td ><?php
                                        if ($dataDetails->performeance_status==2) {
                                              echo 'Released';
                                          } else if($dataDetails->performeance_status==0){
                                              echo  'Passed';
                                          } else if($dataDetails->performeance_status==1){
                                              echo  'Passed';
                                          } 

                                     ?></td>
                                     
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
