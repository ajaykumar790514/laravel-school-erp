@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap" style="background:url({{ asset('front/images/inner_title_bg.jpg') }}">
  <div class="container">
    <h1>Video Gallery List</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Classes Start -->
    <div class="class-wrap">
      <ul class="row unorderList">
        @foreach($photoGallery as $photoGalleryDetails)  
            <li class="col-lg-6 col-md-6">
                <div class="class_box">
                    <div class="class_Img">
                        <?php print_r($photoGalleryDetails->media); ?>
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