@extends('layouts.admin-theme')
@section('content')
	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span>->Menu->Roll Number Allotment List</h4>
			</div>
		</div>
	</div>
	<!-- /page header -->
	<!-- Content area -->
	<div class="content">
		<!-- Vertical form options -->
		<div class="panel panel-white">
			@include('layouts.massage')
			<div class="panel-heading">
			  @can('student-roll-number-allotment')
		        <a href="{{ url('student-roll-number-allotment')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Roll Number Allotments</a>
		      @endcan
			    <div class="heading-elements">
				<ul class="icons-list">
            		<li><a data-action="collapse"></a></li>
            		<li><a data-action="close"></a></li>
            	</ul>
        	</div>
			</div>
			<table class="table table-striped media-library table-lg">
	                        <thead class="thead-dark">
	                            <tr>
	                            	<th>S.No</th>
	                                <th>Session  </th>
	                                <th>Class</th>
	                                <th>Section</th>
	                                <th>Strength </th>
	                                <th class="text-center">Actions</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        @if(count($sessions)>0)
	                        	<?php $i=1;?>
                                @foreach($sessions->all() as $session)
                                <?php //$id=base64_encode($session->id);?>
	                            <tr>
	                            	<td>{{$i}}</td>
			                        <td>{{ $session->session_name}}</td>
			                        <td>{{ $session->class_name}}</td>
			                        <td>{{ $session->section_name}}</td>
			                        <td>{{ countAllotedRollNumber($session->id, $session->class_maping_id)}}/{{ countNotAllotedRollNumber($session->id, $session->class_maping_id)}}</td>
			                        <td class="text-center">
			                            <ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu9"></i></a>
												<ul class="dropdown-menu dropdown-menu-right">
													<?php 
													$seID=base64_encode($session->id);
													$clasMapingId=base64_encode($session->class_maping_id);
													?>
													@can('students-rollnumber-alloted-list')
													<li><a href='{{url("students-rollnumber-alloted-list/{$seID}/{$clasMapingId}")}}'><i class=" icon-magazine"></i> View Student List </a></li>
													@endcan
													@can('student-roll-number-allotment') 
													<li><a href="{{ url('student-roll-number-allotment')}}"><i class="icon-pencil7"></i> Edit </a></li>
													 @endcan
												</ul>
											</li>
										</ul>
			                        </td>
	                            </tr>
	                            <?php $i++;?>
	                            @endforeach

                            @endif
	                        </tbody>
	                    </table>
        </div>
        {{$sessions->links()}}
	</div>
	<!-- /content area -->
@endsection