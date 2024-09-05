@extends('layouts.admin-theme')
@section('content')
				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span>->Menu->Promoted Student List</h4>
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
							@can('student-class-promotion')
		                   <a href="{{ url('student-class-promotion')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Student Class Promotion</a>
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
			                        <td>{{App\Models\StudentClassAllotments::getCountPromotionStudent($session->id, $session->classsetup_id, $session->sectionsetup_id)}}</td>
			                        <td class="text-center">
			                            <ul class="icons-list">
											<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown">
													<i class="icon-menu9"></i>
												</a>

												<ul class="dropdown-menu dropdown-menu-right">
													<?php 
													$seID=base64_encode($session->id);
													$classID=base64_encode($session->classsetup_id);
													$sectionId=base64_encode($session->sectionsetup_id);
													?>
													@can('promoted-update')
													<li><a href='{{url("promoted-update/{$seID}/{$classID}")}}'><i class=" icon-magazine"></i> Promoted Class Section Update</a></li>
													@endcan
													@can('promoted-students')
													<li><a href='{{url("promoted-students/{$seID}/{$classID}/{$sectionId}")}}'><i class=" icon-magazine"></i> View Student List </a></li>
													@endcan
													@can('student-class-promotion') 
													<li><a href="{{ url('student-class-promotion')}}"><i class="icon-pencil7"></i> Edit </a></li>
													 @endcan
													<li class="divider"></li>
													<!-- @can('student-promotion-delete') 
													
													<li><a onclick="return confirm('Are you sure?');" href='{{url("/admission/student-promotion-delete/{$seID}/{$classID}")}}'><i class="icon-bin"></i> Move to trash</a></li>
													@endcan -->
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
                     {{$sessions->links('pagination::bootstrap-5')}}
				</div>
				<!-- /content area -->
@endsection