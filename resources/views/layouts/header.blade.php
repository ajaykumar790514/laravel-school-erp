<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true,
'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
	<div class="header-body border-top-0">
					<div class="header-top header-top-default header-top-borders border-bottom-0">
						<div class="container h-100">
							<div class="header-row h-100">
								<div class="header-column justify-content-between">
									<div class="header-row">
										<nav class="header-nav-top w-100">
											<ul class="nav nav-pills justify-content-between w-100 h-100">
												<li class="nav-item py-2 d-none d-xl-inline-flex">
													<span class="header-top-opening-hours px-0 font-weight-normal d-flex align-items-center"><i class="fa fa-map-marker-alt text-4 text-color-primary"></i>{{ App\Models\Settings::getSettingValue('address')}}</span>
												</li>
												<li class="nav-item py-2 d-flex justify-content-between">
													<span class="header-top-phone py-2 d-flex align-items-center text-color-primary font-weight-semibold text-uppercase"><i class="fab fa-whatsapp-square me-2 text-success text-4"></i> 
													<a target="_blank" href="https://api.whatsapp.com/send?phone={{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</a></span>
												</li>
												<li class="nav-item nav-item-header-top-socials d-none d-xl-inline-flex">
													<span class="header-top-email px-0 font-weight-normal d-flex align-items-center"><i class="far fa-envelope text-4 text-color-primary"></i>  <a class="text-color-default" href="#">{{ App\Models\Settings::getSettingValue('email1')}}</a></span>
												</li>
												<li class="nav-item nav-item-header-top-socials d-none d-xl-inline-flex">
													<span class="header-top-socials p-0 h-100">
														<ul class="d-flex align-items-center h-100 p-0">
															<li class="list-unstyled">
																<a href="{{ App\Models\Settings::getSettingValue('facebook')}}"><i class="fab fa-facebook-f text-color-primary"></i></a>
															</li>
															<li class="list-unstyled">
																<a href="{{ App\Models\Settings::getSettingValue('twitter')}}"><i class="fab fa-twitter text-color-tertiary"></i></a>
															</li>
															<li class="list-unstyled">
																<a href="{{ App\Models\Settings::getSettingValue('instagram')}}"><i class="fab fa-instagram gradient-text-color"></i></a>
															</li>
															<li class="list-unstyled">
																<a href="{{ App\Models\Settings::getSettingValue('youtube')}}"><i class="fab fa-youtube text-color-danger"></i></a>
															</li>
														</ul>
													</span>
													
												</li>
											</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="header-container container bg-color-light">
						<div class="header-row">
							<div class="header-column header-column-logo">
								<div class="header-row">
									<div class="header-logo">
										<a href="{{url('index')}}">
										     <?php $logo=App\Models\Settings::getSettingValue('logo');?>
											<img alt="Dr. Aditya Health Care Center" width="186" height="60" src="{{ asset($logo)}}">
										</a>
									</div>
								</div>
							</div>
							@if (function_exists('mainMenu')) 
                                {{ mainMenu() }}
                            @endif
							
						</div>
					</div>
				</div>
</header>
  