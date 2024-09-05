@extends('layouts.admin-theme')
@section('content')
    <div class="page-header page-header-default">
    	<div class="page-header-content">
    		<div class="page-title">
    			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
    		</div>
    	</div>
    	<div class="breadcrumb-line">
    		<ul class="breadcrumb">
    			<li><a href="{{url('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
    			<li class="active">Dashboard</li>
    		</ul>
    	</div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
    	<!-- Dashboard content -->
    	<div class="row">
    		<div class="col-lg-8">
    			<!-- Quick stats boxes -->
    			<div class="row">
    				<div class="col-lg-4">
    					<div class="panel bg-teal-400">
    						<div class="panel-body">
    					    <h3 class="no-margin"> </h3>
    						Total Daily Diary ({{$dailyDiaryCount}})
    						</div>
    					</div>
    				</div>
    					<div class="col-lg-4">
    					<div class="panel bg-teal-400">
    						<div class="panel-body">
    					    <h3 class="no-margin"> </h3>
    					        Assignment/Home Work ({{$assignmentcount}})</a>
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-4">
    					<div class="panel bg-warning-400">
    						<div class="panel-body">
    					    <h3 class="no-margin"> </h3>
    						<a href="#" style="color:white">Notice Board ({{$noticeBoard}})</a>
    						</div>
    					</div>
    				</div>
                    <div class="col-lg-4">
    					<div class="panel bg-orange-400">
    						<div class="panel-body">
    							Today Events ({{$eventsCount}})
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-4">
    					<div class="panel bg-pink-400">
    						<div class="panel-body">
    						<h3 class="no-margin"> </h3>
    						Total Testimonals ({{$testimonals}}) 
    						</div>
    						
    					</div>
    				</div>
    				<div class="col-lg-4">
    					<div class="panel bg-green-400">
    						<div class="panel-body">
    						<h3 class="no-margin"> </h3>
    							Total Contact ({{$contacts}})
    						</div>
    						
    					</div>
    				</div>
    				
    			</div>
    			<!-- /quick stats boxes -->
    
    			<!-- Latest posts -->
    			
    			<div class="panel panel-flat">
    				<div class="panel-heading">
    				    <h6 class="panel-title">Daily Diary </h6>
    					<div class="heading-elements">
    						<ul class="icons-list">
    	                		<li><a data-action="collapse"></a></li>
    	                		<li><a data-action="close"></a></li>
    	                	</ul>
                    	</div>
                	</div>
    
    				 <div class="panel-body">
    					<div class="row table-responsive text-nowrap">
    					    <table class="table table-responsive">
                              <thead>
                               <tr role="row">
                                 <th>#Id</th>
                                 <th>Session</th>
                                 <th>Title</th>
                                 <th>Created At</th>
                                 <th>View</th>
                              </tr>
                              </thead>
                                <tbody>
                                    @if(count($dailyDiaryAll)>0)
                                       @foreach($dailyDiaryAll as $dailyDiaryDetails)
                                       <?php $dailyDiaryId=base64_encode($dailyDiaryDetails->id);?>
                                       <tr role="row">
                                             <td>{{$dailyDiaryDetails->id}}</td>
                                             <td>{{$dailyDiaryDetails->session_name}}</td>
                                             <td>{{$dailyDiaryDetails->title}}</td>
                                             <td>{{date('d F Y', strtotime($dailyDiaryDetails->created_at))}}</td>
                                             <td><a href='{{url("academics/dailydiaries-view/{$dailyDiaryId}")}}'>View</a></td>
                                      </tr>
                                        @endforeach 
                                    @endif
                                </tbody>
                            </table>
    					</div>
    				</div> 
    			</div>
    			<div class="panel panel-flat">
    				<div class="panel-heading">
    				    <h6 class="panel-title">Assignment/Home Work </h6>
    					<div class="heading-elements">
    						<ul class="icons-list">
    	                		<li><a data-action="collapse"></a></li>
    	                		<li><a data-action="close"></a></li>
    	                	</ul>
                    	</div>
                	</div>
    
    				 <div class="panel-body">
    					<div class="row table-responsive text-nowrap">
    					    	<table class="table table-responsive">
                              <thead>
                               <tr role="row">
                                 <th>Class</th>
                                 <th>Section</th>
                                 <th>Title</th>
                                 <th>Date</th>
                                 <th>View</th>
                              </tr>
                              </thead>
                                <tbody>
                                    @if(count($assignmentAll)>0)
                                       @foreach($assignmentAll as $assignmentDetails)
                                       <?php $assignmentId=base64_encode($assignmentDetails->id);?>
                                       <tr role="row">
                                             <td>{{$assignmentDetails->class_name}}</td>
                                             <td>{{$assignmentDetails->section_name}}</td>
                                             <td>{{$assignmentDetails->title}}</td>
                                             <td>{{date('d F', strtotime($assignmentDetails->created_at))}}</td>
                                             <td><a href='{{url("academics/assignment-holidays-view/{$assignmentId}")}}'>View</a></td>
                                      </tr>
                                        @endforeach 
                                    @endif
                                </tbody>
                            </table>
    					</div>
    				</div> 
    			</div>
    										
    			<!-- /latest posts -->
    
    		</div>
    
    		<div class="col-lg-4">
    		    <div class="panel panel-flat">
    		        <div class="panel-heading">
    				    <h6 class="panel-title">Contact List</h6>
    					<div class="heading-elements">
    						<ul class="icons-list">
    	                		<li><a data-action="collapse"></a></li>
    	                		<li><a data-action="close"></a></li>
    	                	</ul>
                    	</div>
                	</div>
    				 <div class="panel-body">
    					<table class="table table-responsive">
                              <thead>
                               <tr role="row">
                                 <th>Name</th>
                                <th>Mobile</th>
                                 <th>View</th>
                              </tr>
                              </thead>
                                <tbody>
                                    @if(count($contactAll)>0)
                                       @foreach($contactAll as $contactDetails)
                                       <?php $contactId=base64_encode($contactDetails->id);?>
                                       <tr role="row">
                                             <td>{{$contactDetails->name}}</td>
                                             <td>{{$contactDetails->mobile}}</td>
                                             <td><a href='{{url("contact-list")}}'>View</a></td>
                                      </tr>
                                        @endforeach 
                                    @endif
                                </tbody>
                            </table>
    				</div> 
    		    </div>
    	</div>
    </div>
    </div>
@endsection
@section('script')

<script type="text/javascript">
  


</script>

@endsection