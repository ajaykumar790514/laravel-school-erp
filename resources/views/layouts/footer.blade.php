<footer id="footer" class="m-0 bg-color-quaternary">
	<div class="container">
		<div class="row py-5">
			<div class="col-sm-12 col-lg-3 pt-4 pt-lg-0 text-start ms-lg-auto footer-column footer-column-opening-hours">
				@php print_r(App\Models\Blocks::where('name', '=', 'working-hours')->value('content'))@endphp
			</div>
			@if (function_exists('footer_quick_links')) 
                {{ footer_quick_links() }}
            @endif
			@if (function_exists('footer_important_links')) 
                {{ footer_important_links() }}
            @endif
			<div class="col-sm-6 col-lg-3 footer-column footer-column-get-in-touch">
				<h4 class="mb-4 text-uppercase">Get in Touch</h4>
				<div class="info custom-info mb-4">
					<div class="custom-info-block custom-info-block-address">
						<span class="text-color-default font-weight-bold text-uppercase title-custom-info-block title-custom-info-block-address">Address</span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-address">{{ App\Models\Settings::getSettingValue('address')}}</span>
					</div>
					<div class="custom-info-block custom-info-block-phone">
						<span class="text-color-default font-weight-bold text-uppercase title-custom-info-block title-custom-info-block-phone">Phone</span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-phone"> <a href="tel:{{ App\Models\Settings::getSettingValue('mobile')}}" class="text-color-light">{{ App\Models\Settings::getSettingValue('mobile')}}</a></span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-phone"> <a href="tel:{{ App\Models\Settings::getSettingValue('mobile2')}}" class="text-color-light">{{ App\Models\Settings::getSettingValue('mobile2')}}</a></span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-phone"> <a href="tel:{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}" class="text-color-light">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</a></span>
					</div>
					<div class="custom-info-block custom-info-block-email">
						<span class="text-color-default font-weight-bold text-uppercase title-custom-info-block title-custom-info-block-email">Email</span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-email"><a class="text-color-light" href="mailto:{{ App\Models\Settings::getSettingValue('email1')}}">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</a></span>
						<span class="font-weight-normal text-color-light text-custom-info-block p-relative bottom-6 text-custom-info-block-email"><a class="text-color-light" href="mailto:{{ App\Models\Settings::getSettingValue('emai12')}}">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</a></span>
					</div>
					
				</div>
				<ul class="social-icons">
					<li class="social-icons-facebook">
						<a href="{{ App\Models\Settings::getSettingValue('facebook')}}" target="_blank" title="Facebook">
							<i class="fab fa-facebook-f text-4 font-weight-semibold" style='padding-top:10px'></i>
						</a>
					</li>
					<li class="social-icons-twitter">
						<a href="{{ App\Models\Settings::getSettingValue('twitter')}}" target="_blank" title="Twitter">
							<i class="fab fa-twitter text-4 font-weight-semibold" style='padding-top:10px'></i>
						</a>
					</li>
					<li class="social-icons-instagram">
						<a href="{{ App\Models\Settings::getSettingValue('instagram')}}" target="_blank" title="Instagram">
							<i class="fab fa-instagram text-4 font-weight-semibold" style='padding-top:10px'></i>
						</a>
					</li>
					<li class="social-icons-youtube">
						<a href="{{ App\Models\Settings::getSettingValue('youtube')}}" target="_blank" title="Youtube">
							<i class="fab fa-youtube text-4 font-weight-semibold" style='padding-top:10px'></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright pt-3 pb-3 container bg-color-quaternary">
					<div class="row">
						<div class="col-lg-12 text-center m-0 pb-4">
							<p class="text-color-default">&copy; Copyright 2014-{{date('Y')}} Dr. Aditya Health Care Center | All Rights Reserved.</p>
						</div>
					</div>
				</div>
</footer>