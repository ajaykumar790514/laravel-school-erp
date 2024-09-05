@if(count($blogsData)>0)    
    <section class="our-blog pt-5 pt-lg-0 pb-lg-5 mb-5 p-relative bg-color-light">
		<div class="container">
						<div class="row">
							<div class="col">
								<p class="text-uppercase mb-0 d-block text-center text-uppercase appear-animation" data-appear-animation="fadeInUpShorter"
								data-appear-animation-delay="300">Our Post</p>
								<h3 class="text-color-quaternary mb-2 d-block text-center font-weight-bold text-capitalize appear-animation" 
								data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">Recent Post & Articles</h3>
								<p class="mb-4 d-block text-center appear-animation" data-appear-animation="fadeInUpShorter" 
								data-appear-animation-delay="500">&nbsp;</p>           
							</div>
						</div>
						<div class="row justify-content-center justify-lg-content-between">
						    @foreach($blogsData as $blogs)
							<div class="col-sm-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
								<article>
									<div class="card border-0 border-radius-0 box-shadow-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
										<div class="card-body p-4 z-index-1">
											<a href='{{url("blog/{$blogs->slug}")}}'>
												<img class="card-img-top border-radius-0" src="{{asset($blogs->media)}}" alt="Card Image">
											</a>
											<p class="text-uppercase text-1 mb-3 pt-1 text-color-default"><time pubdate datetime="2021-01-10">{{date('d F Y', strtotime($blogs->created_at))}}</time> <span class="opacity-3 d-inline-block px-2">|</span> 3 Comments <span class="opacity-3 d-inline-block px-2">|</span> John Doe</p>
											<div class="card-body p-0">
												<h4 class="card-title mb-3 text-5 font-weight-bold"><a class="text-color-secondary" href='{{url("blog/{$blogs->slug}")}}'>{{$blogs->title}}</a></h4>
												<p class="card-text mb-3">{{$blogs->short_description}}</p>
												<a href='{{url("blog/{$blogs->slug}")}}' class="font-weight-bold text-uppercase text-decoration-none d-block mt-3">Read More &raquo;</a>
											</div>
										</div>
									</div>
								</article>
							</div>
							@endforeach
						</div>
					</div>
	</section>
@endif