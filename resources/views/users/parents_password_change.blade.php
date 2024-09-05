@extends('layouts.admin-theme')
@section('content')
			<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i>Change Password ({{$user->name}}/{{$user->email}})</h4>
						</div>
					</div>
					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="{{url('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">change Password </li>
						</ul>
					</div>
				</div>
			<div class="content">
					<div class="row">
					    @include('layouts.massage')
						@include('layouts.validation-error')
						<div class="col-md-12">
							<!-- Basic layout-->
								<div class="panel panel-flat">
									<div class="panel-heading">
									    @can('parents-login-list')
                                        <a href="{{ url('parents/parents-login-list')}}" class="btn btn-primary"><i class="icon-user-plus position-left"></i>Parents Login List</a>
                                        @endcan
										<div class="heading-elements">
											<ul class="icons-list">
						                		<li><a data-action="collapse"></a></li>
						                	    <li><a data-action="close"></a></li>
						                	</ul>
					                	</div>
									</div>

									<div class="panel-body">
										<form class="form-horizontal" method="POST" action='{{ url("parents/parents-password-change/{$id}") }}' enctype="multipart/form-data">
                       						 {{ csrf_field() }}
    										<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    											<label> Password <span class="text-danger">*</span></label>
    											<input type="password" class="form-control" name='password', id='password' 
    											 value="{{ old('password') }}">
    										</div>
    										<div class="form-group{{ $errors->has('cpassword') ? ' has-error' : '' }}">
    											<label> Confirm Password <span class="text-danger">*</span></label>
    											<input type="password" class="form-control" name='cpassword', id='cpassword' 
    											 value="{{ old('password') }}">
    										</div>
    										<div class="text-right">
    											<button type="submit" class="btn btn-primary">Save <i class="icon-arrow-right14 position-right"></i></button>
    										</div>
										  </form>
									</div>
								</div>
						</div>
					</div>
				</div>
@endsection					