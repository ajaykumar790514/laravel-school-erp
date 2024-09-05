@extends('frontend.layouts.app')
@section('content')

   <!-- Revolution slider start -->
   {{getSlider(getSliderId('home-page-slider'))}}
<!-- Revolution slider end --> 

<!-- School Start -->
<div class="our-course-categories-two ">
  <div class="container">
    <div class="categories_wrap">
      <ul class="row unorderList">
        <li class="col-lg-3 col-md-6"> 
          <!-- single-course-categories -->
          <div class="categories-course">
            <div class="item-inner">
              <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{asset('front/images/school.png')}}" alt=""> </span> </div>
              <div class="cours-title">
                <h4>About School</h4>
                <p></p>
                <a class="btn btn-light" href="https://afschoolkanpurcantt.com/pages/about-us">Read More &raquo;</a>
              </div>
            </div>
          </div>
          <!--// single-course-categories --> 
        </li>
        <li class="col-lg-3 col-md-6"> 
          <!-- single-course-categories -->
          <div class="categories-course">
            <div class="item-inner">
              <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{asset('front/images/book.png')}}" alt=""> </span> </div>
              <div class="cours-title">
                <h4>Quality Education</h4>
                <p></p>
                <a class="btn btn-light" href="https://afschoolkanpurcantt.com/pages/quality-education">Read More &raquo;</a>
              </div>
            </div>
          </div>
          <!--// single-course-categories --> 
        </li>
        <li class="col-lg-3 col-md-6"> 
          <!-- single-course-categories -->
          <div class="categories-course" >
            <div class="item-inner">
              <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{asset('front/images/support.png')}}" alt=""> </span> </div>
              <div class="cours-title">
                <h4>Facilities</h4>
                <p></p>
                <a class="btn btn-light" href="https://afschoolkanpurcantt.com/pages/infrastructural-details">Read More &raquo;</a>
              </div>
            </div>
          </div>
          <!--// single-course-categories --> 
        </li>
        <li class="col-lg-3 col-md-6"> 
          <!-- single-course-categories -->
          <div class="categories-course">
            <div class="item-inner">
              <div class="cours-icon"> <span class="coure-icon-inner"> <img src="{{asset('front/images/song.png')}}" alt=""> </span> </div>
              <div class="cours-title">
                <h4>Air Force School Song</h4>
                <p></p>
                <a class="btn btn-light" href="https://afschoolkanpurcantt.com/pages/air-force-school-song">Read More &raquo;</a>
              </div>
            </div>
          </div>
          <!--// single-course-categories --> 
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- School End --> 

<!-- About Start -->
<div class="about-wrap  " id="about">
  <div class="container">
    <div class="row">
		<div class="col-lg-12">
			<div class="alert alert-success" role="alert">
				<img src="{{asset('front/images/announcement.png')}}" style="float:left;  padding-right: 20px;">
				<?php $margue=getMarquee();?>
				<div class='marquee' style="overflow:hidden">{{$margue->description}}</div>
				
			</div>
			<p>&nbsp;</p>
		</div>
	</div>
	<div class="row">
      <div class="col-lg-8">
        <div class="about_box">
			<div class="title">
              <h3>Welcome to Air Force School</h3>
            </div>
			<hr />
			<img src="{{asset('front/images/air-force-school-kanpur.jpg')}}" style="max-width:348px; height:auto; float:left;  padding: 0px 20px 10px 0px;" alt="Air Force School">
			<p>Air Force School, Kanpur Cantt was established in 1954 with the primary objective to provide educational facilities to the children of Air Force Personnel and civilians. It started with lofty ideas of making students better and responsible citizens of the nation. The school is situated inside the Air Force Station thus ensuring the safety of the children . We strive to make education a natural and friendly activity apart from providing opportunity for the all-round development of every individual.</p>
			<p>The school is looked after by the School Management Committee (SMC). The school runs from Pre-primary (LKG & UKG), to grade X. The medium of instruction is English, and CBSE syllabus is followed.</p>
			<div class="readmore"><a href="{{ url('/pages/about-us')}}">Read More &raquo;</a></div>
		</div>
      </div>
      {{homeNoticeboard()}}
      
    </div>
  </div>
</div>
<!-- About End --> 

<!-- Blog Start -->
    {{getNewsEvents()}}
<!-- Blog End --> 

<!-- Testimonials Start -->
    {{getTestimonals()}}
<!-- Testimonials End --> 

<!-- Gallery Start -->
     {{homeGallery()}}
<!-- Gallery End --> 
@endsection   
@section('script') 
<script type="text/javascript" src="{{asset('admin/js/jquery.marquee.js')}}"> </script>
 <script type="text/javascript">
        $(document).ready(function(){

            $('.marquee').marquee({
            	speed: 100,
            	gap: 100,
            	delayBeforeStart: 0,
            	direction: 'left',
            	duplicated: true,
            	pauseOnHover: true
            });
            $('.marquee-vert').marquee({
            	direction: 'up',
            	speed: 30,
            	gap: 50,
            	duplicated: true,
            	pauseOnHover: true
            });
           
            
            
        });
    </script>
@endsection
