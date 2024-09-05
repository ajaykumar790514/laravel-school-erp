@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap" style="background:url({{ asset('front/images/inner_title_bg.jpg') }}">
  <div class="container">
    <h1>Photo Gallery List</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Classes Start -->
    <div class="class-wrap">
      <ul class="row unorderList">
        @foreach($photoGallery as $photoGalleryDetails)  
            <li class="col-lg-4 col-md-6">
                <div class="class_box">
                    <div class="class_Img"><a href="{{ asset($photoGalleryDetails->media)}}"><img src="{{ asset($photoGalleryDetails->media)}}" alt="{{$photoGalleryDetails->title}}"></a>
                      <div class="time_box"><span>{{ date('d F Y', strtotime($photoGalleryDetails->created_at))}}</span></div>
                    </div>
                    <div class="path_box" style='min-height:auto'>
                      <h5>{{$photoGalleryDetails->title}}</h5>
                      <p>{{$photoGalleryDetails->category}}</p>
                    </div>
                </div>
            </li>
        @endforeach
        
      </ul>
    </div>
    <!-- Classes End --> 
    
  </div>
</div>
@endsection 