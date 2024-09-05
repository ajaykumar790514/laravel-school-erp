@if(count($galleryData)>0)
    <div class="gallery-wrap ">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="gallery_box">
          <div class="gallery_left">
            <div class="title">
              <h1>Photo Gallery</h1>
            </div>
            <p>Our Memorable Moments</p>
            <div class="readmore"><a href="{{ url('photo-gallery')}}">View Gallery</a></div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="row">
            @foreach($galleryData as $galleryDetails)
                <div class="col-lg-4 col-md-6">
                    <div class="galleryImg"><img src="{{asset($galleryDetails->media)}}" alt="{{$galleryDetails->title}}">
                      <div class="portfolio-overley">
                        <div class="content"> <a href="{{asset($galleryDetails->media)}}" class="fancybox image-link" data-fancybox="images" title="Image Caption Here"><i class="fas fa-search-plus"></i></a> </div>
                      </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endif