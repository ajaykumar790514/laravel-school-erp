@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Class Allotments</h4>
            </div>
          </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- 2 columns form -->
        <form class="" method="POST" action="{{ url('student-class-allotment')}}" >
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                    <table class="table  table-bordered  table-hover table-condensed  table-striped " id="domainTable">
                        <thead class="thead-dark">
                          <tr role="row">
                             <th><input id="selectAllDomainList"   type="checkbox" onclick="countCheckbox()" name="sellectAll"></th>
                             <th>Sr. No.</th>
                             <th>Name</th>
                             <th>Father Name</th>
                             <th>Mobile</th>
                             <th>Address</th>
                             <th>Gender</th>
                             <th>Action</th>
                          </tr>
                        </thead>
                            @if(count($data)>0)
                            <?php $k=1;?>
                               @foreach($data as $dataDetails)
                               <?php $studentId=base64_encode($dataDetails->id);?>
                                <tr role="row">
                                     <td>
                                        <?php $allotmentStudent = App\Models\StudentClassAllotments::getClassSection($dataDetails->id, $session_id); ?>
                                           @if(@$allotmentStudent->student_id!=$dataDetails->id)                            
                                            <input id="sellectAll" type="checkbox" value="{{$dataDetails->id}}" onclick="countCheckbox()" name="studentid[]">
                                           @else
                                            <span class="label label-success">Alloted in {{$allotmentStudent['class_name']}}->{{$allotmentStudent['section_name']}}</span>
                                           @endif
                                    </td>
                                    <td>{{$k}}</td>
                                     <td>{{$dataDetails->student_name}}</td>
                                     <td>{{$dataDetails->parents->father_name}}</td>
                                     <td>{{$dataDetails->parents->father_mobile_no}}</td>
                                     <td>{{$dataDetails->parents->address}}</td>
                                     <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
                                     <td> @can('student-view')
                                     <a href='{{url("student-view/{$studentId}")}}' target="_blank">View</a>
                                     @endcan
                                     </td>
                              </tr>
                              <?php $k++;?>
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
                        <ul id="save_msgList"></ul>
                        <div id="success_message"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset>
                                    <div class="form-group{{ $errors->has('section_setup_id') ? ' has-error' : '' }}">
                                        <label>Section <span class="text-danger">*</span></label>
                                        <select id="section_setup_id"  class="form-control" name="section_setup_id" >
                                        <option value=''>--Select--</option>
                                        @if(count($sections)>0)
                                            @foreach($sections as $section)
                                             <option value='{{$section->id}}' <?php echo old('section_setup_id')==$section->id?"selected":"";?>>{{$section->section_name}}</option>   
                                              @endforeach
                                        @endif  
                                       
                                    </select>
                                  </div>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset>
                                    <div class="form-group" style="margin-top: 26px;">
                                        <button type="submit"  class="btn btn-success add_button"><i class=" icon-users4 position-left"></i>Click here to Allotments<span id="allotmentBtn"></span> </button>
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
        $(document).on('click', '.add_button', function (e) {
            e.preventDefault();
            this.disabled=true;
            var session_id =$( "#session_id option:selected").val();
            var data = $('#form-add').serialize();
            $.ajax({
                type: "POST",
                url: "/allotment/"+session_id,
                data: data,
                dataType: "json",
                success: function (response) {
                                if (response.status == 400) {
                                    $('#save_msgList').html("").show();
                                    $('#save_msgList').addClass('alert alert-danger');
                                    $.each(response.errors, function (key, err_value) {
                                        $('#save_msgList').append('<li>' + err_value + '</li>');
                                    });
                                    $('.add_button').text('Save');
                                    $('.add_button').removeAttr('disabled');
                                } else if(response.status == 500){
                                    $('#success_message').html("").show();
                                    $('#success_message').addClass('alert alert-danger');
                                    $('#success_message').text(response.message);
                                    $('.add_button').text('Save');
                                    $('.add_button').disabled=false;
                                } else {
                                    alert("You have successfully allotted Class");
                                     window.location.href="/allotment-list";
                                }
                            }
            });

        }); 
       
    </script>
@endsection
