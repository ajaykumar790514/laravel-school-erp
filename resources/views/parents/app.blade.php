<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}} : {{ App\Models\Settings::getSettingValue('website_title')}} </title>

    <!-- Global stylesheets -->
	<?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
    <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
    <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('admin/css/colors.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery.min.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('admin/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{  asset('admin/js/plugins/forms/styling/switch.min.js') }}"></script>
    <script type="text/javascript" src="{{  asset('admin/js/plugins/notifications/sweet_alert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/core/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/pages/form_layouts.js') }}"></script>
	
    <!-- /theme JS files -->
</head>
<body>
    <!-- Main navbar -->
	@include('parents.top')
	<!-- /main navbar -->   
    <!-- Page container -->
	<div class="page-container">
            <!-- Page content -->
            <div class="page-content">
                @include('parents.sidebar')
                <!-- Main content -->
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->
    </div>
    @yield('script')
</body>
</html>
