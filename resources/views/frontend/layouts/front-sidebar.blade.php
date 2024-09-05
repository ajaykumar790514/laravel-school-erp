 <aside class="sidebar">
    <div class="sidebar-widget category-widget">
        <div class="sidebar-title">
        	<h3>Events</h3>
        </div>
            <ul>
                @foreach(getEventsCat() as $eventsCat)
                <li><a href='{{url("events/{$eventsCat->slug}")}}'>{{$eventsCat->name}}</a></li>
                @endforeach
            </ul>
    </div>
                        @if(count(getSidebarBlogs())>0)
                        <!--Services Post Widget-->
                        <div class="sidebar-widget popular-posts">
                        	<div class="sidebar-title">
                            	<h3>Latest Blog</h3>
                            </div>
                            @foreach(getSidebarBlogs() as $blog)
                            <article class="post">
                                @if($blog->media_type==0)
                            	<figure class="post-thumb img-circle"><a href='{{url("blog/{$blog->slug}")}}'><img src="{{asset($blog->media)}}" alt="{{$blog->title}}"></a></figure>
                            	@endif
                                <div class="text"><a href='{{url("blog/{$blog->slug}")}}'>{{$blog->title}}</a></div>
                                <div class="post-info">Posted by Admin</div>
                            </article>
                            @endforeach
                        </div>
                        @endif
                        <!--Services Gallery Widget-->
                        <div class="sidebar-widget gallery-posts">
                        	<div class="sidebar-title">
                            	<h3>Gallery</h3>
                            </div>
                            <div class="images-outer clearfix">
                                <!--Image Box-->
                                @if(count(getGallery())>0)
                                    @foreach(getGallery() as $getGallery)
                                        <figure class="image-box"><a href="{{ asset($getGallery->media)}}" class="lightbox-image" title="{{$getGallery->title}}" data-fancybox-group="footer-gallery">
                                            <img src="{{asset($getGallery->media)}}" alt="{{$getGallery->title}}"></a>
                                        </figure>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        
                    </aside>