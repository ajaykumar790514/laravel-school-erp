@extends('frontend.layouts.app')
@section('content')
<!-- Inner Heading Start -->
<div class="innerHeading-wrap" style="background:url({{ asset('front/images/inner_title_bg.jpg') }}">
  <div class="container">
    <h1>Photo Gallery</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Teachers Start -->
    <div class="innerteacher-wrap">
      <div class="row">
        @foreach($photoGallery as $photoGalleryDetails)
            <div class="col-lg-3 col-md-6 ">
                <a href='{{url("photo-gallery-list/{$photoGalleryDetails->slug}")}}' style="color:black">
                    <div class="single-teachers">
                    <div class="teacherImg"> 
                    @if($photoGalleryDetails->image=="null" || $photoGalleryDetails->image=="")
                        <img src="{{asset('front/images/teachers01.jpg')}}" alt="Image">
                    @else
                        <img src="{{asset($photoGalleryDetails->image)}}" alt="Image">
                    @endif
                    </div>
                    <div class="teachers-content">
                      <h3>{{$photoGalleryDetails->title}}</h3>
                      <div class="designation"><?php print_r($photoGalleryDetails->title);?></div>
                    </div>
                </div>
                </a>
            </div>
        @endforeach
      </div>
    </div>
    <!-- Teachers End --> 
    
  </div>
</div>
<!-- Inner Heading End --> 
@endsection 