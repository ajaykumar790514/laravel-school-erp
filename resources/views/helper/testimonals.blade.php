@if($testtimonalArray)
  <div class="testimonials-wrap ">
  <div class="container">
    <div class="title">
      <p>Testimoinials</p>
      <h1> What Parents Say </h1>
    </div>
    <ul class="owl-carousel testimonials_list unorderList">
        @foreach($testtimonalArray as $testimonalsDetails)
            <li class="item">
                <div class="testimonials_sec">
                  <div class="client_box">
                    <div class="clientImg"><img alt="" src="{{asset($testimonalsDetails->images)}}"></div>
                    <ul class="unorderList starWrp">
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                      <li><i class="fas fa-star"></i></li>
                    </ul>
                  </div>
                  <p>{{$testimonalsDetails->descraption}}</p>
                  <h3>{{$testimonalsDetails->name}}</h3>
                  <div class="quote_icon"><i class="fas fa-quote-left"></i></div>
                </div>
          </li>
        @endforeach
      
    </ul>
  </div>
</div>
@endif