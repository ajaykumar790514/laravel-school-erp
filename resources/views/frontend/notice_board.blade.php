@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Notice Board</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container">
    <div class="blog_inner ">
      <ul class="row unorderList">
        @foreach($data as $noticeDetails)
            <li class="col-lg-4 col-md-6">
                <div class="blog_box">
                    <div class="blogImg">
                        @if($noticeDetails->attachment!="")
                        <img src="{{asset($noticeDetails->attachment)}}" alt="">
                        @else
                         <img src="{{asset('front/images/blog1.jpg')}}" alt="">
                        @endif
                      <div class="time_box"><span>{{date('d F Y', strtotime($noticeDetails->created_at))}}</span></div>
                    </div>
                    <div class="path_box">
                      <h5><a href='{{url("events/{$noticeDetails->slug}")}}'>{{$noticeDetails->title}}</a></h5>
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