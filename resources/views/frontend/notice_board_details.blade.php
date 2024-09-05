@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Notice Details</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container">
    <div class="blog_inner bloggridWrp">
      <div class="row">
        <div class="col-lg-8 ">
          <div class="class_left">
              @if($noticeDetails->attachment!="")
            <div class="class_Img"><img src="{{asset($noticeDetails->attachment)}}" alt="">
            @else
            <div class="class_Img"><img src="{{asset('front/images/large_img.jpg')}}" alt="">
            @endif
              <div class="time_box"><span>{{date('d F Y', strtotime($noticeDetails->created_at))}}</span></div>
            </div>
            <h3>{{$noticeDetails->title}}</h3>
            <?php print_r($noticeDetails->upload_content);?>
          </div>
        </div>
        <div class="col-lg-4">
          <!--<div class="single-widgets widget_search ">
            <h4>Search</h4>
            <form action="#" class="sidebar-search-form">
              <input type="search" name="search" placeholder="Search..">
              <button type="submit"><i class="fas fa-search"></i></button>
            </form>
          </div>-->
          <!--<div class="single-widgets widget_category ">
            <h4>Categories</h4>
            <ul class="categories">
              <li><a href="#">Educations (6)</a></li>
              <li><a href="#">Childs (12)</a></li>
              <li><a href="#">Design (4)</a></li>
              <li><a href="#">Lifestyle (2)</a></li>
              <li><a href="#">Daily Meals (8)</a></li>
              <li><a href="#">Teachers (9)</a></li>
              <li><a href="#">Uncategorized (2)</a></li>
            </ul>
          </div>-->
          @if(count($noticeAll)>0)
            <div class="single-widgets widget_category ">
                <h4>Recents Notice</h4>
                <ul class="property_sec ">
                    @foreach($noticeAll as $noticeDetails)
                        <li>
                            <div class="rec_proprty">
                                <div class="propertyImg">
                                    @if($noticeDetails->attachment=="")
                                        <img src="{{asset('front/images/gallery-1.jpg')}}">
                                    @else
                                        <img src="{{asset($noticeDetails->attachment)}}">
                                    @endif
                                    </div>
                                <div class="property_info">
                                    <h4><a href='{{url("notice-board-details/{$noticeDetails->slug}")}}'>{{$noticeDetails->title}}</a></h4>
                                 </div>
                            </div>
                        </li>
                    @endforeach
            </ul>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 