<html lang="{{ app()->getLocale() }}" data-style-switcher-options="{'changeLogo': false, 'borderRadius': 0, 'colorPrimary': '#3467ef', 'colorSecondary': '#0e152f', 'colorTertiary': '#060c23', 'colorQuaternary': '#222529'}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}} : {{ App\Models\Settings::getSettingValue('website_title')}}</title>
    <meta name="keywords" content="{{ App\Models\Settings::getSettingValue('meta_keyword')}}" />
	<meta name="description" content="{{ App\Models\Settings::getSettingValue('meta_description')}}" />
    <meta name="author" content="webera.in">
    <meta name="robots" content="" />  
    
    <!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <!-- FAVICONS ICON -->
    <?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
    <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
    <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
    
    <!-- Web Fonts  -->
		<link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/fontawesome-free/css/all.min.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/animate/animate.compat.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
		<link rel="stylesheet" href="{{ asset('front/vendor/magnific-popup/magnific-popup.min.css')}}">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{ asset('front/css/theme.css')}}">
		<link rel="stylesheet" href="{{ asset('front/css/theme-elements.css')}}">
		<link rel="stylesheet" href="{{ asset('front/css/theme-blog.css')}}">
		<link rel="stylesheet" href="{{ asset('front/css/theme-shop.css')}}">

		<!-- Demo CSS -->
		<link rel="stylesheet" href="{{ asset('front/css/demos/demo-medical-2.css')}}">

		<!-- Skin CSS -->
		<link id="skinCSS" rel="stylesheet" href="{{ asset('front/css/skins/skin-medical-2.css')}}">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{ asset('front/css/custom.css')}}">

		<!-- Head Libs -->
		<script src="{{ asset('front/vendor/modernizr/modernizr.min.js')}}"></script>

		<!-- Global site tag (gtag.js) - Google Analytics -->
</head>
<body>
		<div class="body">
    		  @include('layouts.header')
    		  <div role="main" class="main">
    		      @yield('content')
    		  </div>     
		    @include('layouts.footer')
		</div>
        <!-- Vendor -->
		</script><script src="{{ asset('front/vendor/jquery/jquery.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.cookie/jquery.cookie.min.js')}}"></script>
		<script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.validation/jquery.validate.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
		<script src="{{ asset('front/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
		<script src="{{ asset('front/vendor/lazysizes/lazysizes.min.js')}}"></script>
		<script src="{{ asset('front/vendor/isotope/jquery.isotope.min.js')}}"></script>
		<script src="{{ asset('front/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
		<script src="{{ asset('front/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
		<script src="{{ asset('front/vendor/vide/jquery.vide.min.js')}}"></script>
		<script src="{{ asset('front/vendor/vivus/vivus.min.js')}}"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="{{ asset('front/js/theme.js')}}"></script>

		<!-- Current Page Vendor and Views -->
		<script src="{{ asset('front/js/views/view.contact.js')}}"></script>

		<!-- Theme Initialization Files -->
		<script src="{{ asset('front/js/theme.init.js')}}"></script>
@yield('script')
</body>
</html>