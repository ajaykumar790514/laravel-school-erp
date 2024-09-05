@extends('parents.app')
@section('content')
<div class="page-header page-header-default">
    	<div class="page-header-content">
    		<div class="page-title">
    			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> - Daaily Diary View </h4>
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
	<!-- Detailed task -->
	<div class="row">
		<div class="col-lg-12">
			<!-- Task overview -->
			<div class="panel panel-flat">
				<div class="panel-heading mt-5">
					<h5 class="panel-title">{{$dailydiary->title}}</h5>
					<div class="heading-elements">
						{{date('d F Y H:i:s', strtotime($dailydiary->created_at))}}
                	</div>
				</div>

				<div class="panel-body">
					<p class="content-group"><?php print_r($dailydiary->upload_content);?></p>
                    @if(!empty($dailydiary->attachment))
                        <h6 class="text-semibold">Attachment</h6>
    					<div class="row">
    						<div class="col-md-3 col-sm-6">
    							<div class="thumbnail">
    								<div class="thumb">
    									<img src="{{ asset($dailydiary->attachment) }}" alt="{{$dailydiary->title}}">
    									<div class="caption-overflow">
    										<span>
    											<a href="{{ asset($dailydiary->attachment) }}" class="btn bg-success-300 btn-xs btn-icon"><i class="icon-zoomin3"></i></a>
    										</span>
    									</div>
    								</div>
    							</div>
    						</div>
    
    					</div>
    				@endif
				</div>
			</div>
			<!-- /task overview -->
		</div>
	</div>
</div>
@endsection