<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Setting : {{ App\Models\Settings::getSettingValue('website_title')}}  </title>
    <?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
    <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
    <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
      <?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
    <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
    <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	
	<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/colors.css') }}" rel="stylesheet" type="text/css">
	<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jasny_bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/editable/editable.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/extensions/mockjax.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/editable/address.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/styling/switchery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/inputs/autosize.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/inputs/typeahead/typeahead.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/tags/tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/inputs/touchspin.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/inputs/formatter.min.js') }}"></script>
    
	<script type="text/javascript" src="{{ asset('admin/js/core/app.js') }}"></script>
	<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Main navbar -->
	@include('layouts.topbar')
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			@include('layouts.sidebar-admin')


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Home</span> -Change Password</h4>
						</div>

					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="index.html"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Change Settings</li>
						</ul>

						
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
						<!-- Vertical form options -->
						@if(session('responce'))
							<div class="row mp-20">
								<div class="col-md-12">
									<div class='alert alert-success'>{{session('responce')}}</div>
								</div>	
							</div>
						@endif
					<div class="panel panel-flat">
					     
						<div class="panel-heading">
							<h5 class="panel-title">Settings</h5>
							
						</div>
								
						<div class="table-responsive">
							<table class="table table-lg">
								
								
								<tr>
									<td>Address</td>
									<td>
										<form  method="post">
											  {{csrf_field()}}
											  <a id="type-address" data-type="textarea" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('address')}}" 
										data-title="Address">{{ App\Models\Settings::getSettingValue('address')}}
											  </a>
									</form>
								</td>
								</tr>
								<tr>
									<td>Mobile no.</td>
									<td>
										<form  method="post">
  											{{csrf_field()}}
										<a  required id="type-mobile" data-type="text" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('mobile')}}"  data-title="Mobile no.">{{ App\Models\Settings::getSettingValue('mobile')}}</a></td>
									</form>
									
								</tr>
								<tr>
									<td>Mobile No. 2</td>
									<td>
										<form  method="post">
  											{{csrf_field()}}
										<a  required id="type-mobile2" data-type="text" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('mobile2')}}"  data-title="Mobile no.">{{ App\Models\Settings::getSettingValue('mobile2')}}</a></td>
									</form>
									
								</tr>
								<tr>
									<td>Whatsapp Mobile No.</td>
									<td>
										<form  method="post">
  											{{csrf_field()}}
										<a  required id="type-mobile_whatsapp" data-type="text" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('mobile_whatsapp')}}"  data-title="Mobile no.">{{ App\Models\Settings::getSettingValue('mobile_whatsapp')}}</a></td>
									</form>
									
								</tr>
								<tr>
									<td>Phone</td>
									<td>
										<form  method="post">
  											{{csrf_field()}}
										<a  required id="phone" data-type="text" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('phone')}}"  data-title="Phpne no.">
										{{ App\Models\Settings::getSettingValue('phone')}}</a>
									</td>
									</form>
									
								</tr>

								<tr>
									<td>Email </td>
									<td><a required   id="type-email" data-type="email" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('email1')}}" 
										data-title="Email">{{ App\Models\Settings::getSettingValue('email1')}}</a>
									</td>
									
								</tr>
								
								<tr>
									<td>Email 2</td>
									<td><a required   id="type-emai12" data-type="email" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('emai12')}}" 
										data-title="Email">{{ App\Models\Settings::getSettingValue('emai12')}}</a>
									</td>
									
								</tr>

								<tr>
									<td>Website Title</td>
									<td><a required   id="website_title" data-type="text" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('website_title')}}" 
										data-title="Website Title">{{ App\Models\Settings::getSettingValue('website_title')}}</a>
									</td>
									</tr>
								<tr>
									<td>Meta Description</td>
									<td><a required   id="meta_description" data-type="textarea" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('meta_description')}}" 
										data-title="meta description">{{ App\Models\Settings::getSettingValue('meta_description')}}</a>
									</td>
									
								</tr>
								<tr>
									<td>Meta Keyword</td>
									<td><a required id="meta_keyword" data-type="textarea" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('meta_keyword')}}" 
										data-title="meta keyword">{{ App\Models\Settings::getSettingValue('meta_keyword')}}</a>
									
									</td>
									
								</tr>
								<tr>
									<td>Facebook</td>
									<td><a required   id="facebook" data-type="url" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('facebook')}}" 
										data-title="Facebook">{{ App\Models\Settings::getSettingValue('facebook')}}</a>
									</td>
								</tr>
								<tr>
									<td>LinkedIn</td>
									<td><a required   id="linkedIn" data-type="url" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('linkedIn')}}" 
										data-title="LinkedIn">{{ App\Models\Settings::getSettingValue('linkedIn')}}</a>
									</td>
								</tr>
								<tr>
									<td>Twitter</td>
									<td><a required   id="twitter" data-type="url" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('twitter')}}" 
										data-title="Twitter">{{ App\Models\Settings::getSettingValue('twitter')}}</a>
									</td>
								</tr>
								<tr>
									<td>Instagram</td>
									<td><a required   id="instagram" data-type="url" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('instagram')}}" 
										data-title="Instagram">{{ App\Models\Settings::getSettingValue('instagram')}}</a>
									</td>
								</tr>
								<tr>
									<td>Youtube</td>
									<td><a required   id="youtube" data-type="url" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('youtube')}}" 
										data-title="Youtube">{{ App\Models\Settings::getSettingValue('youtube')}}</a>
									</td>
								</tr>
								<tr>
									<td>Home Page Slider</td>
									<td>
									    <form class="form-horizontal" method="POST" action="{{ url('update_slider') }}" 
										enctype="multipart/form-data">
									    {{ csrf_field() }}
									    <div class='row'>
									            <div class='col-md-4'> 
    									            <div class="form-group{{ $errors->has('banner') ? ' has-error' : '' }}">
    									                @php $selectedSlider=App\Models\Settings::getSettingValue('home-page-slider'); @endphp
        											    <select id="settingvalue" tabindex="5" class="form-control" name="settingvalue" >
                                                            <option value=''>--Select--</option>
                                                            @foreach($slider as $sliderDetails)
                                                                <option value='{{$sliderDetails->key}}' {{ $selectedSlider==$sliderDetails->key?"selected":""}}>{{$sliderDetails->key}}</option>   
                                                            @endforeach
                                                        </select>
        										    </div>
        										</div>
									            <div class='col-md-4'>	<button type="submit" class="btn btn-default">Update</button> </div>
									    </div>
									    
										
									    </form>
									 </td>
								</tr>
								<tr>
									<td>Map</td>
									<td><a required   id="map" data-type="textarea" data-inputclass="form-control" 
										data-pk="{{ App\Models\Settings::getSettingID('map')}}" 
										data-title="Google Map">{{ App\Models\Settings::getSettingValue('map')}}</a>
									</td>
								</tr>
								<tr>
									<td>Logo</td>
									<td><form class="form-horizontal" method="POST" action="{{ url('/updatelogo') }}" 
										enctype="multipart/form-data">
									    {{ csrf_field() }}
									    <div class="form-group{{ $errors->has('banner') ? ' has-error' : '' }}">
									        <div class='row'>
									            <div class="col-md-4">
									                	<input type="file" 
                                                        class="filepond"
                                                         id='logo'
                                                        name="logo" 
                                                        multiple 
                                                        allowImagePreview='true'
                                                        data-allow-reorder="true"
                                                        data-max-file-size="3MB"
                                                        data-max-files="1">
										            	<button type="submit" class="btn btn-default">Upload</button>
									            </div>
									            <div class="col-md-4">
									                <?php $logo=App\Models\Settings::getSettingValue('logo'); ?>
								                    <img src="{{asset($logo)}}" alt="" class="img-rounded img-preview">
									            </div>
									        </div>
										
										</div>
										
									    </form>
									    </td>
								</tr>
								
								<tr>
									<td>Favicon</td>
									<td><form class="form-horizontal" method="POST" action="{{ url('/updatefavicon') }}" enctype="multipart/form-data">
									    {{ csrf_field() }}
									    <div class="form-group{{ $errors->has('banner') ? ' has-error' : '' }}">
											<div class='row'>
									            <div class="col-md-4">
									                	<input type="file" 
                                                        class="filepond"
                                                         id='favicon'
                                                        name="favicon" 
                                                        multiple 
                                                        allowImagePreview='true'
                                                        data-allow-reorder="true"
                                                        data-max-file-size="3MB"
                                                        data-max-files="1">
										            	<button type="submit" class="btn btn-default">Upload</button>
									            </div>
									            <div class="col-md-4">
									                <?php $favicon=App\Models\Settings::getSettingValue('favicon'); ?>
								                    <img src="{{asset($favicon)}}" alt="" class="img-rounded img-preview">
									            </div>
									        </div>
										</div>
										
									    </form>
									    
									    </td>
								</tr>
							</table>
						</div>
					</div>
					<!-- /vertical form options -->				
					<!-- Footer -->
					
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	<script type="text/javascript">
	$(function() {
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        
        FilePond.registerPlugin(FilePondPluginImagePreview);
             const inputElement = document.querySelector('input[id="logo"]');
                FilePond.create(inputElement, {
                server:{
                    url: '/logo',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                });
                
                const bannerElement = document.querySelector('input[id="favicon"]');
                FilePond.create(bannerElement, {
                server:{
                    url: '/feviconImage',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                })
        
        
        
        
        

		$('#type-address').editable({			
        url: "{{ url('/updatesettings')}}",
        title: 'Enter address',
        validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
    });

		// Mobile
	    $('#type-mobile').editable({
	    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
	        url: "{{ url('/updatesettings')}}",
	        title: 'Enter mobile'
	    });
	    
	    // Mobile 2
	    $('#type-mobile2').editable({
	    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
	        url: "{{ url('/updatesettings')}}",
	        title: 'Enter Mobile No. 02'
	    });
	    
	    // Whatsapp Mobile 
	    $('#type-mobile_whatsapp').editable({
	    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
	        url: "{{ url('/updatesettings')}}",
	        title: 'Enter Whatsapp Mobile No. '
	    });

	     $('#phone').editable({
	    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
	        url: "{{ url('/updatesettings')}}",
	        title: 'Enter site phone'
	    });

        // Email
        $('#type-email').editable({
        	validate: function(value) {
                	if($.trim(value) == '') return 'This field is required';
           		 },
            url: "{{ url('/updatesettings')}}",
            title: 'Enter site email'
        });
        
        // Email 2
        $('#type-emai12').editable({
        	validate: function(value) {
                	if($.trim(value) == '') return 'This field is required';
           		 },
            url: "{{ url('/updatesettings')}}",
            title: 'Enter site emai12'
        });

     $('#website_title').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter website title'
    });

     $('#meta_description').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter meta description'
    });
    
    $('#map').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter map iframe'
    });

     $('#meta_keyword').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter meta keyword'
    });
    
     $('#facebook').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter Facebook url'
    });
    
     $('#twitter').editable({
    	validate: function(value) {
            	if($.trim(value) == '') return 'This field is required';
       		 },
        url: "{{ url('/updatesettings')}}",
        title: 'Enter Twitter url'
    });
 
         $('#linkedIn').editable({
        	validate: function(value) {
                	if($.trim(value) == '') return 'This field is required';
           		 },
            url: "{{ url('/updatesettings')}}",
            title: 'Enter linkedIn url'
        });
        
         $('#instagram').editable({
        	validate: function(value) {
                	if($.trim(value) == '') return 'This field is required';
           		 },
            url: "{{ url('/updatesettings')}}",
            title: 'Enter Instagram url'
        });
        
         $('#youtube').editable({
        	validate: function(value) {
                	if($.trim(value) == '') return 'This field is required';
           		 },
            url: "{{ url('/updatesettings')}}",
            title: 'Enter Youtube url'
        });
        
        
        

	  });

	



	</script>

</body>
</html>
