@if(count($newsEventsData)>0)
    <div class="blog-wrap flight-wrap ">
  <div class="container">
    <div class="title">
      <h1> News & Events </h1>
    </div>
    <ul class="row unorderList">
        @foreach($newsEventsData as $newsEventsDetails)    
            <li class="col-lg-4">
        <div class="blog_box">
          <div class="blogImg"><img src="{{asset($newsEventsDetails->attachments)}}" alt="{{$newsEventsDetails->note}}">
            <div class="time_box"><span>{{date('d F Y', strtotime($newsEventsDetails->date_from))}}</span></div>
          </div>
          <div class="path_box">
            <h3><a href='{{url("events/{$newsEventsDetails->slug}")}}'>{{$newsEventsDetails->note}}</a></h3>
            <p>{{$newsEventsDetails->session_name}}</p>
            <p>{{$newsEventsDetails->catName}}</p>
          </div>
        </div>
      </li>
        @endforeach
      
    </ul>
	<div align="center" class="readmore"><a href="{{url('news-events')}}">Read More &raquo;</a></div>
  </div>
</div>
@endif