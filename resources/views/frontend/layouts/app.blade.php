<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keyword" content="{{getSettingValueByName('meta_keyword')}}">
    <meta name="description" content="{{getSettingValueByName('meta_description')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset(getSettingValueByName('favicon'))}}" />
    <link rel="icon" href="{{ asset(getSettingValueByName('favicon'))}}" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css') }}">
    <link href="{{asset('front/css/all.css') }}" rel="stylesheet">
    <link href="{{asset('front/css/owl.carousel.css') }}" rel="stylesheet">
    
    <!-- <link rel="stylesheet" href="{{asset('front/css/switcher.css') }}"> -->
    <link rel="stylesheet" href="{{asset('front/rs-plugin/css/settings.css') }}">
    <!-- Jquery Fancybox CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('front/css/jquery.fancybox.min.css') }}" media="screen" />
    <link href="{{asset('front/css/animate.css') }}" rel="stylesheet">
    <link href="{{asset('front/css/style.css') }}" rel="stylesheet"  id="colors">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>{{$title}} : {{ getsiteTitle()}} </title>
</head>
<body>

<!--Header Start-->
@include('frontend.layouts.front-header')
<!--Header End--> 

 @yield('content')

@include('frontend.layouts.footer')


<script src="{{ asset('front/js/jquery.min.js') }}"></script> 
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script> 
<script src="{{ asset('front/js/popper.min.js') }}"></script> 
<script src="{{ asset('front/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script> 
<script src="{{ asset('front/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script> 
<!-- Jquery Fancybox --> 
<script src="{{ asset('front/js/jquery.fancybox.min.js') }}"></script> 
<!-- Animate js --> 
<script src="{{ asset('front/js/animate.js') }}"></script> 
<script>
  new WOW().init();
</script> 
<!-- WOW file --> 
<script src="{{ asset('front/js/wow.js') }}"></script> 
<!-- general script file --> 
<script src="{{ asset('front/js/owl.carousel.js') }}"></script> 
<script src="{{ asset('front/js/script.js') }}"></script>
@yield('script')
</body>
</html>