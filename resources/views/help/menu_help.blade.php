@extends('layouts.admin-theme')
@section('content')
<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery_ui/interactions.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery_ui/touch.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/pages/components_navs.js')}}"></script>
<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Help </span> - Default Menu</h4>
						</div>
					</div>
				</div>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">

					<!-- Accordion and collapsible -->
					<div class="row">
						<div class="col-md-12">
							<div class="panel-group panel-group-control content-group-lg" id="accordion-control">
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group1">Home Menu Link</a>
										</h6>
									</div>
									<div id="accordion-control-group1" class="panel-collapse collapse in">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/index</p>
										<span>Example: <img src='https://doctor.mdisdo.org/uploads/images/help/home-menu.png'></span>
										</div>
									</div>
								</div>

								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2">All Diseases Page ( Diseases & Treatment )</a>
										</h6>
									</div>
									<div id="accordion-control-group2" class="panel-collapse collapse">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/diseases</p>
										    <span>Example: <img src='https://doctor.mdisdo.org/uploads/images/help/desises.png'></span>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3">All Health Services Page</a>
										</h6>
									</div>
									<div id="accordion-control-group3" class="panel-collapse collapse">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/health-services</p>
										    <span>Example: <img src='https://doctor.mdisdo.org/uploads/images/help/health-service.png'></span>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4">All Post Page</a>
										</h6>
									</div>
									<div id="accordion-control-group4" class="panel-collapse collapse">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/blog</p>
										    <span>Example: As Above example</span>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group5">Patient Speak Page</a>
										</h6>
									</div>
									<div id="accordion-control-group5" class="panel-collapse collapse">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/testimonal</p>
										    <span>Example: As Above example</span>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group6">Contact Us Page</a>
										</h6>
									</div>
									<div id="accordion-control-group6" class="panel-collapse collapse">
										<div class="panel-body">
											<p>URL : https://yourdomain.com/contact-us</p>
										    <span>Example: As Above example</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<!-- /content area -->
@endsection