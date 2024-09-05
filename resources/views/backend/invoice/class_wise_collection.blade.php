@extends('layouts.admin-theme')
@section('content')
        <!-- Page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> Fee Madule-><span class="text-semibold">Reports</span> ->Class Wise Fee Collection</h4>
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
                         
                      <!-- Accordion with right control button -->
                          <div class="panel-group panel-group-control panel-group-control-right content-group-lg" id="accordion-control-right">
                          <?php $k=1;?>  
                          @foreach($sessions as $sessionDetails)  
                            <div class="panel">
                              <div class="panel-heading {{$k==1?'bg-purple':'bg-danger'}} ">
                                <h6 class="panel-title">
                                  <a class="collapsed" data-toggle="collapse" data-parent="#accordion-control-right" href="#accordion-{{$sessionDetails->session_id}}">
                                      {{$sessionDetails->session_name}} (Total Students: {{App\Models\StudentClassAllotments::getTotalStudentBySessionId($sessionDetails->session_id)}}) 
                                    </a>
                                </h6>
                              </div>
                              <div id="accordion-{{$sessionDetails->session_id}}" class="panel-collapse collapse">
                                  <div class="panel-body table-responsive">
                                      <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'>
                                         <thead class="thead-dark">
                                            <tr role="row">
                                               <th>Id</th>
                                               <th>Class</th>
                                               <th>Section</th>
                                               <th>Strength</th>
                                               <th >Action</th>
                                            </tr>
                                         </thead>
                                         <?php  $classList=App\Models\StudentClassAllotments::getClassSectionBySessionId($sessionDetails->session_id); 
                                                $i=1; 
                                                
                                        ?>
                                          @foreach($classList as $classDetails)
                                            <tr role="row">
                                               <td>{{$i}}</td>
                                               <td>{{$classDetails->class_name}}</td>
                                               <td>{{$classDetails->section_name}}</td>
                                               <td><?php  echo App\Models\StudentClassAllotments::getTotalStudentBySessionIdClassMapingID($sessionDetails->session_id, $classDetails->classsetup_id, $classDetails->sectionId); ?></td>
                                               <td>
                                                <?php
                                                  $sessionId=base64_encode($sessionDetails->session_id);
                                                  $classID=base64_encode($classDetails->classsetup_id);
                                                  $sectionID=base64_encode($classDetails->sectionId);
                                                ?>
                                                <a href='{{ url("export-class-wise-collection-report/{$sessionDetails->session_id}/{$classDetails->classsetup_id}/{$classDetails->sectionId}")}}'><i class="icon-money"></i> Class Wise Fee Collection Report</a></td>
                                            </tr>
                                          <?php $i++;?>
                                          @endforeach
                                          <tfoot class="thead-dark">
                                          <tr role="row">
                                               <th>Id</th>
                                               <th>Class</th>
                                               <th>Section</th>
                                               <th>Strength</th>
                                               <th >Action</th>
                                            </tr>
                                        
                                         </tfoot>
                                      </table>
                                  </div>
                              </div>
                            </div>
                            <?php $k++;?>
                          @endforeach
                          
                          </div>
                          <!-- /accordion with right control button -->
                    </div>
         </div>
   
</div>
@endsection

