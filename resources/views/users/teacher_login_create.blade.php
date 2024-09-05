@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee/Teacher-></span>Menu->Create Teacher/Staff Login</h4>
            </div>
            </div>
        </div>

        <!-- Content area -->
        <div class="content">
            <!-- Vertical form options -->
            <div class="row">
                @include('layouts.massage') 
                 @include('layouts.validation-error') 
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
                                       
                                        <form class="" method="POST" action="{{ url('teacher-login-create')}}" >
                                             {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('teacherId') ? ' has-error' : '' }}">
                                            <label>Select Teacher <span class="text-danger">*</span></label>
                                            <select id="teacherId" class="form-control select" name="teacherId" >
                                            <option value=''>--Select--</option>
                                            @if(count($teachers)>0)
                                                @foreach($teachers as $teacher)
                                                 <option {{ old("teacherId")==$teacher->id?'selected':'' }} value='{{$teacher->id}}' >{{$teacher->employee_name}}->{{$teacher->email}}</option>   
                                                 @endforeach
                                            @endif
                                        </select>
                                            @if ($errors->has('teacherId'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('teacherId') }}</strong>
                                                </span>
                                            @endif
                                           
                                        </div>


                                       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name='email', id='emailID' placeholder="teachername@domain.com"  value="{{ old('email') }}">
                                           
                                        </div>

                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label>Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='password', id='password'  value="{{ old('password') }}">
                                           
                                        </div>

                                        <div class="form-group{{ $errors->has('confirm-password') ? ' has-error' : '' }}">
                                            <label>Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name='confirm-password', id='confirm-password'  value="{{ old('confirm-password') }}">
                                           
                                        </div>
                                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                                            <label>Roles <span class="text-danger">*</span></label>

                                            <select id="roles" class="form-control" name="roles" >
                                            <option value=''>--Select--</option>
                                            @if(count($roles)>0)
                                                @foreach($roles as $role)
                                                 <option {{ old("roles")==$role->id?'selected':'' }} value='{{$role->id}}'>{{$role->name}}</option>   
                                                  @endforeach
                                            @endif
                                        </select>
                                           
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Create Teacher Login </button>
                                        </div>

                                          </form>
                                    </div>
                    </div>
                    <!-- /basic layout -->
                </div>
            </div>
        </div>
@endsection