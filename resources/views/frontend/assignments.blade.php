@extends('frontend.layouts.app')
@section('content')
<div class="innerHeading-wrap">
  <div class="container">
    <h1>Assignment/Home Work</h1>
  </div>
</div>
<div class="innerContent-wrap">
  <div class="container"> 
    
    <!-- Faqs Start -->
    <div class="faqs-wrap "> 
      
      <!--Question-->
      <div class="faqs">
        <div class="panel-group" id="accordion">
            @foreach($assignmentList as $assignmentDetails)
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" class="collapsed" href="#collapse{{$assignmentDetails->id}}">
                          {{$assignmentDetails->class_name}}/{{$assignmentDetails->section_name}} Date: {{date("d F Y", strtotime($assignmentDetails->created_at))}}</a>
                          </h4>
                    </div>
                    <div id="collapse{{$assignmentDetails->id}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6"><b>{{$assignmentDetails->title}}</b><br>
                                        <p><?php print_r($assignmentDetails->upload_content);?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            @if($assignmentDetails->attachment!="")
                                             <a href="{{asset($assignmentDetails->attachment)}}" title="Download"><img src="{{asset($assignmentDetails->attachment)}}"></a>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                    </div>
                </div>
            @endforeach
           <div>{{ $assignmentList->links() }}</div>
        </div>
      </div>
    </div>
    <!-- Faqs End --> 
    
  </div>
</div>
@endsection