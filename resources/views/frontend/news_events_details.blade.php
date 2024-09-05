@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Events Details</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container">
    <div class="blog_inner bloggridWrp">
      <div class="row">
        <div class="col-lg-8 ">
          <div class="class_left">
              @if($data->attachments!="")
            <div class="class_Img"><img src="{{asset($data->attachments)}}" alt="">
            @else
            <div class="class_Img"><img src="{{asset('front/images/large_img.jpg')}}" alt="">
            @endif
              <div class="time_box"><span>{{date('d F Y', strtotime($data->date_from))}}</span></div>
            </div>
            <h3>{{$data->note}}</h3>
            <?php print_r($data->descriptions);?>
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
          @if(count($eventsCatAll)>0)
            <div class="single-widgets widget_category ">
            <h4>Categories</h4>
            <ul class="categories">
                @foreach($eventsCatAll as $eventsCatDetails)
                  <li><a href="#">{{$eventsCatDetails->name}} ({{getEventCatByID($eventsCatDetails->id)}})</a></li>
                @endforeach
            </ul>
          </div>
          @endif
          @if(count($dataAll)>0)
            <div class="single-widgets widget_category ">
                <h4>Recents News & Events</h4>
                <ul class="property_sec ">
                    @foreach($dataAll as $dataDetails)
                        <li>
                            <div class="rec_proprty">
                                <div class="propertyImg">
                                    @if($dataDetails->attachments=="")
                                        <img src="{{asset('front/images/gallery-1.jpg')}}">
                                    @else
                                        <img src="{{asset($dataDetails->attachments)}}">
                                    @endif
                                    </div>
                                <div class="property_info">
                                    <h4><a href='{{url("events/{$dataDetails->slug}")}}'>{{$dataDetails->note}}</a></h4>
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
</div>
@endsection