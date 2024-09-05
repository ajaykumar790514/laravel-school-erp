@extends('layouts.admin-theme')
@section('content')

    <!-- Page header -->
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fees Module </span> ->Menu->Fee Collection</h4>
            </div>
          </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- 2 columns form -->
        <form class="" method="POST" action="{{ url('student-list-for-fee-collection')}}" >
            {{ csrf_field() }}
            <div class="panel panel-flat">
                @include('layouts.massage') 
                 @include('layouts.validation-error') 
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
                                <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                    <label>Session <span class="text-danger">*</span></label>
                                    <select id="session_id"  class="form-control select" name="session_id" >
                                        @if(count(getSession())>0)
                                            @foreach(getSession() as $section)
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
                                <label>Class <span class="text-danger">*</span></label>
                                <select id="class_maping_id"  class="form-control select" name="class_maping_id" >
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
                               <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                <label>Section </label>
                                <select id="section_id"  class="form-control select" name="section_id" >
                                    <option value=''>--Select--</option>
                                </select>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-2">
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
        <!--<form class="" method="POST" action='{{ url("/allotment/{$session_id}")}}'>-->
        <form class="" method="POST" action="javascript:void(0)" id="form-add">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                @if(count($data)>0)
                <div class="panel-heading">
                            <h6>Student List for Class Allotments (Total:{{count($data)}})</h6>
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
                                       <?php $studentClassAttment=base64_encode($dataDetails->studentClassId);?>
                                        <tr role="row">
                                             <td>{{$dataDetails->admission_no}}</td>
                                            <td>{{$dataDetails->roll_no}}</td>
                                             <td>{{$dataDetails->student_name}}</td>
                                             <td>{{$dataDetails->father_name}}</td>
                                             <td>{{$dataDetails->parentsmobile}}</td>
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
        </form>
    </div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('admin/js/pages/datatables_basic.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <!-- /page container -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $('#class_maping_id').change(function() {
        $("#section_id").empty(); 
        $("#section_id").append('<option value="">--Select--</option>');
        var classId= $('#class_maping_id').val();
        var sectionID= '<?php echo $section_id; ?>';
        if(classId!=''){
                   $.ajax({
                        type: "POST",
                        url: "/getSectionByClassId",
                        data: {classId:classId},
                        //dataType: "json",
                        success: function (response) {
                            //console.log(response);
                             var obj = jQuery.parseJSON(response);
                             $("#section_id").empty(); 
                            var tblRow='<option value="">--Select--</option>';
                            $.each( obj, function( i, obj ) { 
                                if(sectionID==obj.id){
                                    tblRow += '<option selected value="'+obj.id+'">'+obj.section_name+'</option> ';
                                } else{
                                    tblRow += '<option value="'+obj.id+'">'+obj.section_name+'</option> ';
                                }
                            });
                            $("#section_id").append(tblRow);
                        }
                    });
               }
        }).change();  
       
    </script>
@endsection
