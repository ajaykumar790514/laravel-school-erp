@extends('layouts.admin-theme')
@section('content')
    <div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee</span> -Update Teacher/Staff Login Details</h4>
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
                                        @can('teacher-login-list')
                                        <a href="{{ url('teacher-login-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i> Teacher/Staff Login List</a>
                                         @endcan
                                        <div class="heading-elements">
                                            <ul class="icons-list">
                                                <li><a data-action="collapse"></a></li>
                                                <li><a data-action="close"></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        @include('layouts.validation-error') 
                                        <?php $id=base64_encode($data->id);?>
                                        <form class="" method="POST" action='{{ url("teacher-login-edit/{$id}")}}' >
                                             {{ csrf_field() }}
                                        <!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='email', id='emailID' placeholder="teachername@domain.com"  value="{{ $data->email}}">
                                           
                                        </div>-->

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='password', id='password'  value="{{ old('password') }}">
                                           
                                        </div>

                                        <div class="form-group{{ $errors->has('confirm-password') ? ' has-error' : '' }}">
                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='confirm-password', id='confirm-password'  value="{{ old('confirm-password') }}">
                                           
                                        </div>
                                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->status==0?"selected":""}}>Active</option>   
                                                <option value='1' {{ $data->status==1?"selected":""}}>Inactive</option>
                                            </select>
                                            
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Update Teacher/Staff Login </button>
                                        </div>

                                          </form>
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
        $('#teacherId').on('change',function(e){     
            var teach_id = $('#teacherId option:selected').attr('value');
            $.ajax({
                type: "get",
                url : "{{url('loademail')}}",
                data:{'teach_id':teach_id},
                 dataType:'json',//return data will be json
                success : function(data){
                    //alert('testing');
                   document.getElementById("emailID").innerHTML =data.email;
                   //$("#emailID").html("<p>Hello World!</p>");
                }
            });
        });
    </script>
@endsection
