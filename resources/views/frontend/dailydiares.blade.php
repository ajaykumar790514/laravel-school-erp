@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Daily Diary</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Faqs Start -->
    <div class="faqs-wrap "> 
      
      <!--Question-->
      <div class="faqs">
        <div class="panel-group" id="accordion">
            @foreach($DailyDiaryList as $dailyDiaryDetails)
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#collapse{{$dailyDiaryDetails->id}}">
                          {{$dailyDiaryDetails->class_name}}/{{$dailyDiaryDetails->section_name}} Date: {{date("d F Y", strtotime($dailyDiaryDetails->created_at))}}</a>
                          </h4>
                    </div>
                    <div id="collapse{{$dailyDiaryDetails->id}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6"><b>{{$dailyDiaryDetails->title}}</b><br>
                                        <p><?php print_r($dailyDiaryDetails->upload_content);?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            @if($dailyDiaryDetails->attachment!="")
                                             <a href="{{asset($dailyDiaryDetails->attachment)}}" title="Download"><img src="{{asset($dailyDiaryDetails->attachment)}}"></a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                    </div>
                </div>
            @endforeach
           <div>{{ $DailyDiaryList->links() }}</div>
        </div>
      </div>
    </div>
    <!-- Faqs End --> 
    
  </div>
</div>
@endsection