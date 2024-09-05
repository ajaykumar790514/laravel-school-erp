@extends('frontend.layouts.app')
@section('content')
<section class="page-header page-header-modern bg-color-light-scale-1 page-header-md m-0">
					<div class="container">
						<div class="row">
							<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
								<h1 class="text-dark font-weight-bold text-9 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="100">{{$blogs->title}}</h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-block text-md-end appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300">
									<li><a href="{{url('index')}}">Home</a></li>
									<li class="active">{{$blogs->title}}</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
                @if(!empty($blogs))
				    <div class="container py-5">
					<div class="row">
						<div class="col-lg-9">
                            
							    <article>
								<div class="card border-0 border-radius-0 mb-5 box-shadow-1">
									<div class="card-body p-4 z-index-1">
									    @if($blogs->media_type==0)
										<a href='{{url("blog/{$blogs->slug}")}}'>
											<img class="card-img-top border-radius-0" src="{{asset($blogs->media)}}" alt="Card Image">
										</a>
										@endif
										@if($blogs->media_type==1)
										@php print_r($blogs->media);@endphp
										@endif
										
										@if($blogs->media_type==1)
										@php print_r($blogs->media); @endphp
										@endif
										<p class="text-uppercase text-1 mb-3 pt-1 text-color-default"><time pubdate datetime="2021-01-10">{{date('d F Y', strtotime($blogs->created_at))}}</time> <span class="opacity-3 d-inline-block px-2">|</span> admin</p>
										<div class="card-body p-0">
											<h4 class="card-title mb-3 text-5 font-weight-bold"><a class="text-color-secondary" href='{{url("blog/{$blogs->slug}")}}'>{{$blogs->title}}</a></h4>
											<p class="card-text mb-3">{{$blogs->short_description}}</p>
											<p class="card-text mb-3">{{$blogs->description}}</p>
										</div>
									</div>
								</div>
							</article>
                           
						</div>
						<div class="col-lg-3 pt-4 pt-lg-0">
							<aside class="sidebar">
								<div class="tabs tabs-dark mb-4 pb-2">
									<ul class="nav nav-tabs">
										<li class="nav-item"><a class="nav-link show active text-1 font-weight-bold text-uppercase" href="#popularPosts" data-bs-toggle="tab">Rescent Posts</a></li>
										
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="popularPosts">
										    @if(count($blogAll)>0)
											<ul class="simple-post-list">
											    @foreach($blogAll as $blogAllDetails)
												<li>
													<div class="post-image">
														<div class="img-thumbnail img-thumbnail-no-borders d-block">
														    @if($blogAllDetails->media_type==0)
															<a href='{{url("blog/{$blogAllDetails->slug}")}}'>
																<img src="{{asset($blogAllDetails->media)}}" width="50" height="50" alt="">
															</a>
															@endif
														</div>
													</div>
													<div class="post-info">
														<a href='{{url("blog/{$blogAllDetails->slug}")}}'>{{$blogAllDetails->title}}</a>
														<div class="post-meta">
															 {{date('d F Y', strtotime($blogAllDetails->created_at))}}
														</div>
													</div>
												</li>
												@endforeach
											</ul>
											@endif
										</div>
										
									</div>
								</div>
							</aside>
						</div>
					</div>
				</div>
				@endif
@endsection 