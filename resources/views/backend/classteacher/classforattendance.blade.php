<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{Request::segment(2)}} : {{ App\Settings::getSettingValue('website_title')}} </title>

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="{{ URL::to('resources/assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
  
  <link href="{{ URL::to('resources/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
  <link  href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="{{ URL::to('resources/assets/css/core.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::to('resources/assets/css/components.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::to('resources/assets/css/colors.css') }}" rel="stylesheet" type="text/css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script type="text/javascript" src="{{ URL::to('resources/assets/js/plugins/loaders/pace.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::to('resources/assets/js/core/libraries/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::to('resources/assets/js/core/libraries/bootstrap.min.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="{{ URL::to('resources/assets/js/plugins/loaders/blockui.min.js') }}"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->
    <script type="text/javascript" src="{{ URL::to('resources/assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('resources/assets/js/core/app.js') }}"></script>
     <link rel="shortcut icon" href="{{ URL::to('resources/assets/images/favicon.ico') }}" />
  
  <!-- /theme JS files -->
<style type="text/css">
</style>
</head>
<body>
  <!-- Main navbar -->
  @include('layouts.topbar')
  <!-- /main navbar -->
  <!-- Page container -->
  <div class="page-container">
    <!-- Page content -->
    <div class="page-content">
      @include('layouts.sidebar-admin')
      <!-- Main content -->
      <div class="content-wrapper">
        <!-- Page header -->
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
                 <td><?php $studentcount=App\StudentClassAllotments::getallattendeanceStudent($classesDetails->session_id, $classesDetails->class_id);
                    if($studentcount==0){
                        echo "<lable class='text-danger'>No Any Student Enroll in this section</label> ";
                    } else {
                      echo $studentcount;
                    }

                 ?>
                 </td>
                 <td>
                   <?php
                      $sessionId=base64_encode($classesDetails->session_id);
                      $classsetupId=base64_encode($classesDetails->class_id);
                  ?>
                  @can('student-list-for-attendance')
                 
                  @if($studentcount!=0)
                     @if($classesDetails->status==0)
                     <a class="btn bg-success" href='{{ url("/attendance/student-list-for-attendance/{$sessionId}/{$classsetupId}")}}'>Take Attendance</a>
                     @else
                     <span class="label label-default">Inactive</span>
                     @endif
                  @endif
                  @endcan
                  @if($studentcount!=0)
                  @can('student-attendance-register')
                    <a class="btn bg-pink" href='{{ url("/attendance/student-attendance-register/{$sessionId}/{$classsetupId}")}}'>Attendance Register</a>
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

</body>
</html>



