@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Testimonials</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Testimonials Start -->
    <div class="testimonials-wrap">
      <ul class="row  unorderList">
         @foreach($testimonalAll as $testimonalDetails) 
            <li class="col-lg-6 ">
                <div class="testimonials_sec">
                    <div class="client_box">
                      <div class="clientImg"><img alt="" src="{{asset($testimonalDetails->images)}}"></div>
                      <ul class="unorderList starWrp">
                        <li><i class="fas fa-star"></i></li>
                        <li><i class="fas fa-star"></i></li>
                        <li><i class="fas fa-star"></i></li>
                        <li><i class="fas fa-star"></i></li>
                        <li><i class="fas fa-star"></i></li>
                      </ul>
                    </div>
                    <p>{{$testimonalDetails->descraption}}</p>
                    <h3>{{$testimonalDetails->name}}</h3>
                    <div class="quote_icon"><i class="fas fa-quote-left"></i></div>
          </div>
            </li>
        @endforeach
        
      </ul>
    </div>
    
    <!-- Testimonials End --> 
    
  </div>
</div>
@endsection 