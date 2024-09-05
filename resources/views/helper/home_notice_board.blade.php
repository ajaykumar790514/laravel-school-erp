@if($dataArray)
<style>
    .marquee-vert {
			  height: 300px;
			  overflow: hidden;
			 
			}
</style>
<div class="col-lg-4">
        <div class="about_box alert alert-secondary" role="alert" style="overflow: hidden;">
          <div class="title">
            <h4>Notice Board <a href="{{url('notice-board')}}">(All)</a></h4>
          </div>
          <hr />
		  <p></p>
          <ul class="edu_list marquee-vert" data-autoscroll>
              @foreach($dataArray as $noticeDetails)
    			<li>
                  <div class="learing-wrp">
                    <div class="learn_info">
                        <a href='{{url("notice-board-details/{$noticeDetails->slug}")}}' style="text-decoration: none;">
                      <p><span class="badge badge-danger"><?php if($noticeDetails->priority==0){echo "Normal";} 
                                                                elseif($noticeDetails->priority==1){echo "High";} 
                                                                else{echo "Low";}?>
                                                                </span>
                      {{$noticeDetails->title}}</p>
                      </a>
                    </div>
                  </div>
                </li>
             @endforeach
          </ul>
        </div>
      </div>
@endif