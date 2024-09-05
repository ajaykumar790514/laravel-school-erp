@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Parens Module</span> -Menu-Create Parents Login</h4>
        </div>
        </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- Vertical form options -->
        <div class="row">
            @include('layouts.massage') 
            <div class="col-md-6">
                <!-- Basic layout-->
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
                        <form class="" method="POST" action='{{ url("/parents/parent-login-create")}}' >
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('parents_id') ? ' has-error' : '' }}">
                                <label>Select Parents <span class="text-danger">*</span></label>
                                <select id="parents_id" class="form-control select" name="parents_id" >
                                        <option value=''>--Select--</option>
                                        @if(count($parents)>0)
                                            @foreach($parents as $parents)
                                             <option {{ old("parents_id")==$parents->id?'selected':'' }} value='{{$parents->id}}' >{{$parents->father_name}}</option>   
                                             @endforeach
                                        @endif
                                </select>
                                @if ($errors->has('parents_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('parents_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                                             
                               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name='email' id='email'>
                                </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='password', id='password'  value="{{ old('password') }}">
                                           
                                        </div>

                                        <div class="form-group{{ $errors->has('confirm-password') ? ' has-error' : '' }}">
                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='confirm-password', id='confirm-password'  value="{{ old('confirm-password') }}">
                                           
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Create Parent Login </button>
                                        </div>
                                </form>
                    </div>
                </div>
                <!-- /basic layout -->
            </div>
            <div class="col-md-6">
                <!-- Basic layout-->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h3>Student Details</h3>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                    <li><a data-action="close"></a></li>
                                </ul>
                            </div>
                    </div>
                    <div class="panel-body">
                        <table class="table myTable" id="myTable">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Class</th>
                                </tr>
                             </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /basic layout -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- /page container -->
    <script type="text/javascript">
     $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $('#parents_id').on('change',function(e){     
            var parentId = $('#parents_id option:selected').attr('value');
            $.ajax({
                type: "POST",
                url : "{{url('parents/getParentsDetails')}}",
                data:{'parentId':parentId},
                 dataType:'json',//return data will be json
                success : function(response){
                    var data = response.data;
                    var students = response.student;
                    if(data.father_email=== null){
                        if(data.father_mobile_no=== null){
                            document.getElementById("email").value =data.father_name+"@gmail.com";
                        } else{
                            document.getElementById("email").value =data.father_mobile_no+"@gmail.com";
                        }
                    } else{
                        document.getElementById("email").value =data.father_email;
                    }
                    $("#myTable").empty();
                    var newRow="";
                    for (var i = 0; i < students.length; i++) {
                        newRow += '<tr>';
                            newRow +="<td>"+students[i].student_name+"</td>";
                            newRow += "<td>"+students[i].class_name+"</td>";
                            newRow +="</tr>";
                    };
                    $("#myTable").append(newRow);
                }
            });
        });
    </script>
@endsection
