@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Attendance</span> ->Menu->Classes List For Attendance</h4>
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
                    
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">
            <table class="table table-striped media-library table-lg" >
               <thead class="thead-dark">
                  <tr role="row">
                     <th>Id</th>
                     <th>Session</th>
                     <th>Class</th>
                     <th>Section</th>
                     <th>Teacher</th>
                     <th>Student Strength</th>
                     <th >Action</th>
                  </tr>
               </thead>
               <tbody>
              @if(count($data)>0)
                <?php $i=1;?>
                    @foreach($data as $classesDetails)
                    <?php //$id=base64_encode($session->id);?>
               <tr >
                 <td>{{$i}}</td>
                 <td>{{$classesDetails->session_name}}</td>
                 <td>{{$classesDetails->class_name}}</td>
                 <td>{{$classesDetails->section_name}}</td>
                 <td>{{$classesDetails->employee_name}}</td>
                 <td><?php $studentcount=App\Models\StudentClassAllotments::getallattendeanceStudent($classesDetails->session_id, $classesDetails->class_id); ?>
                    @if($studentcount==0)
                        <lable class='text-danger'>No Any Student Enroll in this section</label>
                        @can('student-roll-number-allotment')
                            <a class="btn bg-success" href='{{ url("student-roll-number-allotment")}}'>Roll Number Allotment</a>
                        @endcan
                    @else
                      {{$studentcount}}
                   @endif

                 </td>
                 <td>
                   <?php
                      $sessionId=base64_encode($classesDetails->session_id);
                      $classsetupId=base64_encode($classesDetails->class_id);
                      $sectionsetupId=base64_encode($classesDetails->section_id);
                  ?>
                  @can('student-list-for-attendance')
                 
                  @if($studentcount!=0)
                     @if($classesDetails->status==0)
                      <p><a class="btn bg-success" href='{{ url("/attendance/student-list-for-attendance/{$sessionId}/{$classsetupId}/{$sectionsetupId}")}}'>Take Attendance</a></p>
                     @else
                     <span class="label label-default">Inactive</span>
                     @endif
                  @endif
                  @endcan
                  @if($studentcount!=0)
                  @can('student-attendance')
                    <a class="btn bg-pink" href='{{ url("/attendance/student-attendance/{$sessionId}/{$classsetupId}/{$sectionsetupId}")}}'>Attendance Register</a>
                  @endcan
                  @endif
                  

                </td>
               </tr>
               <?php $i++;?>
                @endforeach
                 </tbody>

              @else
               <tr>
                 <td colspan="7" align="center">{{config('app.emptyrecords')}}</td>
               </tr>
               @endif
                <tfoot class="thead-dark">
                <tr role="row">
                     <th>Id</th>
                     <th>Session</th>
                     <th>Class</th>
                     <th>Section</th>
                     <th>Teacher</th>
                     <th>Student Strength</th>
                     <th >Action</th>
                     
                  </tr>
        </tfoot>
            </table>
          </div>
         </div>
  
</div>
@endsection



