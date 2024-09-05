@extends('layouts.admin-theme')
@section('content')
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master->Roll Number Allotments</h4>
            </div>
          </div>
        
    </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
            @include('layouts.massage')
            <!-- 2 columns form -->
            <form class="" method="POST" action="{{ url('student-roll-number-allotment')}}" >
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
                        @include('layouts.validation-error') 
                        <div class="row">
                            <div class="col-md-4">
                                <fieldset>
                                    <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                            <label>Session <span class="text-danger">*</span></label>
                                            <select id="session_id"  class="form-control select" name="session_id" >
                                                @if(count($sessions)>0)
                                                    @foreach($sessions as $sessionDetails)
                                                     <option value='{{$sessionDetails->session_id}}' <?php echo $session_id==$sessionDetails->session_id?"selected":"";?> >{{$sessionDetails->session_name}}</option>   
                                                      @endforeach
                                                @endif    
                                                
                                            </select>
                                           </div>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset>
                                    <div class="form-group{{ $errors->has('class_maping_id') ? ' has-error' : '' }}">
                                        <label>Class/Section <span class="text-danger">*</span></label>
                                            <select id="class_maping_id"  class="form-control select" name="class_maping_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($classesmaping)>0)
                                                    @foreach($classesmaping as $classesmapings)
                                                     <option value='{{$classesmapings->class_maping_id}}' <?php echo $class_id==$classesmapings->class_maping_id?"selected":"";?>>{{$classesmapings->section_name}}</option>   
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
            <!--<form class="" method="POST" action='{{ url("rollnumber")}}'>-->
            <form class="" method="POST" action="javascript:void(0)" id="form-add">
                
                    {{ csrf_field() }}
                    <div class="panel panel-flat">
                    @if(count($data)>0)
                        <div class="panel-heading">
                            <h6>Student List for Roll Number Allotments ({{count($data)}})</h6>
                             <div class="heading-elements">
                              <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                                <table class="table  table-bordered  table-hover " id="domainTable">
                                    <thead class="thead-dark">
                                      <tr role="row">
                                         <th>Roll Number</th>
                                         <th>Class/Section</th>
                                         <th>Name</th>
                                         <th>Father Name</th>
                                         <th>Mobile</th>
                                         <th>Address</th>
                                         <th>Gender</th>
                                      </tr>
                                    </thead>
                                        @if(count($data)>0)
                                            @foreach($data as $dataDetails)
                                                <tr role="row">
                                                 <td>
                                                    @if($dataDetails->performeance_status==2)
                                                    Released
                                                  @elseif($dataDetails->performeance_status==1)
                                                     Fail
                                                  @else
                                                  <input type="text" name="rollnumbertxt[]" id='rollnumbertxt' value="{{$dataDetails->roll_no}}" class="form-control">
                                                    <input type="hidden" name="id[]" value="{{$dataDetails->studentClassId}}" class="form-control">
                                                    <input type="hidden" name="sessionid[]" value="{{$dataDetails->session_id}}" class="form-control">
                                                    <input type="hidden" name="classid[]" value="{{$dataDetails->class_maping_id}}" class="form-control">
        
                                                    <input type="hidden" name="student_id[]" value="{{$dataDetails->student_id}}" class="form-control">
                                                  @endif
                                                    
                                                </td>
                                                <td>{{$dataDetails->class_name}}-->{{$dataDetails->section_name}}</td>
                                                 <td>{{$dataDetails->student_name}}</td>
                                                 <td>{{$dataDetails->father_name}}</td>
                                                 <td>{{$dataDetails->mobile_whatsapp==""?$dataDetails->parentsmobile:$dataDetails->mobile_whatsapp}}</td>
                                                 <td>{{$dataDetails->address}}</td>
                                                 <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
                                          </tr>
                                            @endforeach 
                                        @else
                                    <tr>
                                        <th colspan="7" style="text-align: center;"> {{config('app.emptyrecords')}}</th>
                                    </tr>
                                    @endif
                                </table>
                        </div>
                        <div class="panel-body table-responsive">
                            <ul id="save_msgList"></ul>
                            <div id="success_message"></div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <fieldset>
                                            <div class="form-group" style="margin-top: 26px;">
                                                <button type="submit"  class="btn btn-success add_button"><i class=" icon-users4 position-left"></i>Click here to Allotments Roll Number<span id="allotmentBtn"></span> </button>
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
     $(document).on('click', '.add_button', function (e) {
            e.preventDefault();
            this.disabled=true;
            var data = $('#form-add').serialize();
            $.ajax({
                type: "POST",
                url: "/rollnumber",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#save_msgList').html("").show();
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_button').text('Click here to Allotments Roll Number');
                        $('.add_button').removeAttr('disabled');
                    } else if(response.status == 500){
                        $('#success_message').html("").show();
                        $('#success_message').addClass('alert alert-danger');
                        $('#success_message').text(response.message);
                        $('.add_button').text('Click here to Allotments Roll Number');
                        $('.add_button').removeAttr('disabled');
                    } else {
                        alert("You have successfully allotted roll number");
                         window.location.href="/roll-number-allotment-list";
                    }
                }
            });

    });      
</script>
@endsection
