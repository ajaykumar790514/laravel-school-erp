@extends('layouts.admin-theme')
@section('content')
<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery_ui/interactions.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery_ui/touch.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/pages/components_navs.js')}}"></script>

<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Help </span> - Default Block Code</h4>
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
											<a data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group1">Intro Left Page Code </a>
										</h6>
									</div>
									<div id="accordion-control-group1" class="panel-collapse collapse in">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;img alt="alt=Dr. Aditya Health Care Center" src="https://doctor.mdisdo.org/uploads/images/dr-aditya-jaiswal.png" style="height:auto" &gt;
                                                </code>
                                            </pre>
										
										</div>
									</div>
								</div>

								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group2">Intro Right Page Code</a>
										</h6>
									</div>
									<div id="accordion-control-group2" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre><code>&lt;img alt="Dr. Aditya Health Care Center" src="https://doctor.mdisdo.org/uploads/images/logo-main.png" style="max-width: 100%; height: auto;" &gt;
                                                </code>
                                            </pre>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group3">After Slider Block First</a>
										</h6>
									</div>
									<div id="accordion-control-group3" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;div class="card-body d-flex align-items-center justify-content-between flex-column z-index-1">
                                                &lt;img alt="Healthcare Centaer" src="https://doctor.mdisdo.org/uploads/images/slider/icon-healthcare-center.png" />
                                                &lt;h4 class="card-title mb-1 font-weight-bold">HEALTH CARE CENTER</h4>
                                                &lt;p class="card-text text-center text-warning font-weight-bold">CONSULTANCY FOR ALL TYPE OF HUMAN DISEASES.</p>
                                                &lt;a class="font-weight-bold text-uppercase text-decoration-none" href="#">read more </a>
                                                &lt;/div>
                                              </code>
                                            </pre>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group4">After Slider Block Second</a>
										</h6>
									</div>
									<div id="accordion-control-group4" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;div class="card-body d-flex align-items-center justify-content-between flex-column z-index-1">
                                                        &lt;img alt="Immediate Center" src="https://doctor.mdisdo.org/uploads/images/slider/icon-diagnostic-center.png" />
                                                            &lt;h4 class="card-title mb-1 font-weight-bold">SEEMA HOMEO HALL</h4>
                                                            &lt;p class="card-text text-center text-warning font-weight-bold">FOR SALE OR DISTRIBUTED BY WHOLESALE HOMEOPATHIC MEDICINES.</p>
                                                            &lt;a class="font-weight-bold text-uppercase text-decoration-none" href="#">read more</a>
                                                            &lt;/div>
                                              </code>
                                            </pre>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group5">After Slider Block Third</a>
										</h6>
									</div>
									<div id="accordion-control-group5" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;div class="card-body d-flex align-items-center justify-content-between flex-column z-index-1">
                                                &lt;img alt="Diagnostic Center" src="/public/admin/ckeditor/kcfinder/upload/images/icon-immediate-center.png" style="width: 106px; height: 91px;" />
                                                                            &lt;h4 class="card-title mb-1 font-weight-bold">Dr. TONY GYM</h4>
                                                                            &lt;p class="card-text text-center text-warning font-weight-bold">FOR ALL TYPE OF WORKOUT.</p>
                                                                            &lt;a class="font-weight-bold text-uppercase text-decoration-none" href="https://doctor.mdisdo.org/pages/dr.-tony-gym">read more &raquo;</a>
                                                                            &lt;/div></code>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group6">Home About</a>
										</h6>
									</div>
									<div id="accordion-control-group6" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;p class="text-uppercase mb-0 appear-animation text-warning font-weight-bold" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">Welcome</p>
                                        &lt;h3 class="text-color-quaternary font-weight-bold text-capitalize mb-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">Dr. Aditya Health Care Center</h3>
                                        &lt;p class="font-weight-semibold appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">Dr. Aditya Health Care Center was established in 15 January 2000, it has grown tremendously in various fields of human health care treating thousands of patients with various disorders.</p>
                                        &lt;p class="mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">We have modern clinics in Kanpur and spreading all over India. Our clinic equipped with latest software and efficient central monitoring suited best to the needs of community at large. Here we are not only 
                                        dealing with Homoeopathy, there is an Complete Wellness centre for your family health. All the centers supervised under the perfect guidance by <b>Dr. Aditya Jaiswal</b>, Here are the team of specialist doctors who have been personally trained by him. We treat patients with the medicine and also take care of them with our expert team of wellness department.</p>
                                        &lt;div class="row counters mb-4 flex-nowrap flex-sm-wrap">
                                        &lt;div class="col-xs-4 col-sm-4 col-lg-4 mb-0 d-flex">
                                        &lt;div class="counter counter-primary appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="500">
                                        &lt;strong class="number-counter text-10" data-append="+" data-to="22">0</strong> 
                                       &lt;label class="number-counter-text text-4 text-color-primary font-weight-semibold negative-ls-1">Business Year</label>
                                        &lt;/div>
                                        &lt;/div>
                                        &lt;div class="col-xs-4 col-sm-4 col-lg-4 mb-0 d-flex">
                                        &lt;div class="counter counter-primary appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="500">
                                        &lt;strong class="number-counter text-10" data-append="+" data-to="25000">0</strong> 
                                        &lt;label class="number-counter-text text-4 text-color-primary font-weight-semibold negative-ls-1">Happy Patient</label>
                                        &lt;/div>
                                       &lt;/div>
                                        &lt;div class="col-xs-4 col-sm-4 col-lg-4 mb-0 d-flex justify-content-center">
                                        &lt;div class="counter counter-primary appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="500">
                                        &lt;strong class="number-counter text-10" data-append="+" data-to="100">0</strong> 
                                        &lt;label class="number-counter-text text-4 text-color-primary font-weight-semibold negative-ls-1">Health Products</label>
                                        &lt;/div>
                                        &lt;/div>
                                        &lt;/div></code>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group7">Doctors Time Table</a>
										</h6>
									</div>
									<div id="accordion-control-group7" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>Morning - 9:00 am to 12:00 pm<br />
                                                Evening - 5:00 pm to 8:00 pm</code>
										</div>
									</div>
								</div>
								<div class="panel panel-white">
									<div class="panel-heading">
										<h6 class="panel-title">
											<a class="collapsed" data-toggle="collapse" data-parent="#accordion-control" href="#accordion-control-group8">Working Hours</a>
										</h6>
									</div>
									<div id="accordion-control-group8" class="panel-collapse collapse">
										<div class="panel-body">
											<p class="text-semibold">Default Code</p>
                                            <pre class="language-markup content-group"><code>&lt;h4 class="mb-4 text-uppercase">Working Days/Hours</h4>
                                                                    &lt;div class="info custom-info pt-0"><span>Morning -</span> <span> 9:00 am to 12:00 pm</span>
                                                                    &lt;/div>
                                                                    &lt;div class="info custom-info"><span>Evening -</span> <span> 5:00 pm to 8:00 pm</span>
                                                                    &lt;/div>
                                                                    &lt;div class="info custom-info pb-0 border-bottom-0"><span>Sunday</span> <span>Closed</span>
                                                                    &lt;/div>
                                                                    &lt;div class="info custom-info pb-0 border-bottom-0">
                                                                    &lt;a href="index.html">
                                                                    &lt;img alt="IS0 9001:2008 certified" src="/public/admin/ckeditor/kcfinder/upload/images/timing%20(1).png" style="max-width: 100%; width: 402px; height: 149px;" /> </a>
                                                                    &lt;/div></code>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<!-- /content area -->
@endsection