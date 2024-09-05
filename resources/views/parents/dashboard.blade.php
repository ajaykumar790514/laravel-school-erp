@extends('parents.app')
@section('content')
<div class="page-header page-header-default">
    	<div class="page-header-content">
    		<div class="page-title">
    			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Dashboard</h4>
    		</div>
    
    	</div>
    	<div class="breadcrumb-line">
    		<ul class="breadcrumb">
    			<li><a href="{{url('parents/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
    			<li class="active">Dashboard</li>
    		</ul>
    	</div>
</div>
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
    						Total Students ({{$totalStudents}})
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-3">
    					<div class="panel bg-pink-400">
    						<div class="panel-body">
    							Total Invoice ({{$totalInvoice}})
    						</div>
    					</div>
    				</div>
    				<div class="col-lg-3">
    					<div class="panel bg-pink-400">
    						<div class="panel-body">
    							Notice Board ({{$noticeBoard}})
    						</div>
    					</div>
    				</div>
    			</div>
    			<!-- /quick stats boxes -->
    
    			<!-- Latest posts -->
    			<div class="panel panel-flat">
    				<div class="panel-heading">
    				    <h6 class="panel-title">Fee Transaction </h6>
    					<div class="heading-elements">
    						<ul class="icons-list">
    	                		<li><a data-action="collapse"></a></li>
    	                		<li><a data-action="close"></a></li>
    	                	</ul>
                    	</div>
                	</div>
    
    				 <div class="panel-body">
    					<div class="row table-responsive text-nowrap">
    					    @widget('FeeTransactionsForParents')
    					</div>
    				</div> 
    			</div>
    										
    			<!-- /latest posts -->
    
    		</div>
    
    		<div class="col-lg-4">
    		    <div class="panel panel-flat">
					<div class="panel-heading">
						<h6 class="panel-title">Daily Diary</h6>
						<div class="heading-elements">
							<a href=''><span class="badge bg-danger-400 heading-text">{{count($dailyDiary)}}</span></a>
						</div>
					</div>
					<div class="panel-body">
									<div class="content-group-xs" id="bullets"></div>
									<ul class="media-list">
									    @if(count($dailyDiary)>0)
									        @foreach($dailyDiary as $dailyDiaryDetails)
									         <?php $id=base64_encode($dailyDiaryDetails->id);?>
										        <li class="media">
											<div class="media-left">
												<a href='{{url("parents/daily-diary-view/{$id}")}}' class="btn border-pink text-pink btn-flat btn-rounded btn-icon btn-xs">{{$dailyDiaryDetails->class_name}} ({{$dailyDiaryDetails->section_name}})</a>
											</div>
											
											<div class="media-body">
												{{$dailyDiaryDetails->title}}
												<div class="media-annotation">{{date('d F Y', strtotime($dailyDiaryDetails->created_at))}}</div>
											</div>

											<div class="media-right media-middle">
												<ul class="icons-list">
													<li>
								                    	<a href='{{url("parents/daily-diary-view/{$id}")}}'><i class="icon-arrow-right13"></i></a>
							                    	</li>
						                    	</ul>
											</div>
										</li>
										    @endforeach
										@endif
									</ul>
								</div>
				</div>
    	</div>
    </div>
    </div>
@endsection