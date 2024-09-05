@extends('frontend.layouts.app')
@section('content')
<!-- Inner Heading Start -->
@if($pageContent->banner!="")
    <div class="innerHeading-wrap" style="background:url({{ asset($pageContent->banner) }}">
@else
<div class="innerHeading-wrap" style="background:url({{ asset('front/images/inner_title_bg.jpg') }}">
@endif
    
  <div class="container">
    <h1>{{ $pageContent->page_title}}</h1>
  </div>
</div>
<div class="about-wrap " id="about">
  <div class="container">
    <div class="row">
      
      <div class="col-lg-12">
        <div class="about_box">
          
         	<?php echo $pageContent->page_content; ?>
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Inner Heading End --> 
@endsection 