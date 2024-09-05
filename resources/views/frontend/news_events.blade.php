@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>NEWS EVENTS</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container">
    <div class="blog_inner ">
      <ul class="row unorderList">
        @foreach($data as $eventsDetails)
            <li class="col-lg-4 col-md-6">
                <div class="blog_box">
                    <div class="blogImg">
                        @if($eventsDetails->attachments!="")
                        <img src="{{asset($eventsDetails->attachments)}}" alt="">
                        @else
                         <img src="{{asset('front/images/blog1.jpg')}}" alt="">
                        @endif
                      <div class="time_box"><span>{{date('d F Y', strtotime($eventsDetails->date_from))}}</span></div>
                    </div>
                    <div class="path_box">
                      <h3><a href='{{url("events/{$eventsDetails->slug}")}}'>{{$eventsDetails->note}}</a></h3>
                      <p>{{$eventsDetails->catName}}</p>
                    </div>
                </div>
            </li>
        @endforeach
      </ul>
      <div>{{ $data->links() }}</div>
      <!--<div class="blog-pagination text-center">{{ $data->links() }} </div>-->
    </div>
  </div>
</div>
@endsection 