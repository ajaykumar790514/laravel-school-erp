<section class="footer-top-info">
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-xl-4 p-4 bg-color-secondary d-flex align-items-center justify-content-between">
								<div class="footer-top-info-detail">
									<h4 class="text-color-light mb-1 d-block font-weight-semibold text-capitalize appear-animation" data-appear-animation="fadeIn" 
									data-appear-animation-delay="100">Emergency Cases</h4>
									<p class="d-block m-0 footer-top-info-desc text-5 appear-animation" data-appear-animation="fadeIn" 
									data-appear-animation-delay="200"><span style="color:#3467ef;">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</span></p>
								</div>
								
							</div>
							<div class="col-xs-12 col-xl-4 p-4 bg-color-tertiary d-flex align-items-center justify-content-between">
								<div class="footer-top-info-detail">
									<h4 class="text-color-light mb-1 d-block font-weight-semibold text-capitalize appear-animation" data-appear-animation="fadeIn" 
									data-appear-animation-delay="400">Doctors Timetable</h4>
									<p class="d-block m-0 footer-top-info-desc appear-animation" data-appear-animation="fadeIn" 
									data-appear-animation-delay="500"><span style="color:#3467ef;">@php print_r($doctortiming)@endphp</span></p>
								</div>
								
							</div>
							<div class="col-xs-12 col-xl-4 p-4 bg-color-secondary d-flex align-items-center justify-content-between">
								<div class="footer-top-info-detail">
									<h4 class="text-color-light mb-1 d-block font-weight-semibold text-capitalize appear-animation" 
									data-appear-animation="fadeIn" data-appear-animation-delay="700">
									    Find Us On Map
									</h4>
									
									<p class="d-block m-0 footer-top-info-desc appear-animation" data-appear-animation="fadeIn" 
									    data-appear-animation-delay="800">
									    <span style="color:#3467ef;">Click on view more to see map
									 </p>
								</div>
								<a href="#" type="button" class="btn btn-outline btn-footer-top-info btn-light rounded-0 d-block text-color-light border-color-primary text-uppercase text-center p-0 custom-btn-footer-top-info bg-transparent-hover appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="900">view more +</a>
							</div>
						</div>
					</div>
	</section>