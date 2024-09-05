<header class="main-header header-style-two">
        <!-- Header Top -->
        <div class="header-top">
            <div class="auto-container clearfix">
                <!--Top Left-->
                <div class="top-left pull-left">
                    <ul class="links-nav clearfix">
                        <li><span class="icon fa fa-envelope-o"></span><a href="#">{{ getEmail()}}</a></li>
                        <li><span class="icon fa fa-phone"></span><a href="#">Call Us Now : {{getMobile()}}, {{getPhone()}}</a></li>
                    </ul>
                </div>
                <!--Top Right-->
                <div class="top-right pull-right">
                    <ul class="links-nav clearfix">
                        <li><a target="_blank" href="#" class="">
                            <!--<img style="width: 97px; margin-top: -5px;" src="{{ URL::to('resources/front/images/resource/drpsschoolapp.png')}}">-->
                            </a>
                        </li>
                        <li><a href="{{ url('/notice-board')}}"><span style="color:#FFCA00;"> Notice Board</span></a></li>
                        <li><a href="{{ route('login') }}"><span style="color:#FFCA00;">{{ __('Login') }}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Header Top End -->
        
        <!--Header-Upper-->
        <div class="header-upper">
            <div class="auto-container">
                <div class="clearfix">
                    <!--Logo Outer-->
                    <div class="logo-outer">
                        <div class="logo"><a href="{{url('/')}}">
                            <img src="{{ asset(getSiteLogo()) }}" alt="{{ getsiteTitle()}}" title="{{ getsiteTitle()}}" style='width:190px' ></a></div>
                    </div>
                    <div class="nav-outer clearfix">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <div class="navbar-header">
                                <!-- Toggle Button -->      
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                            </div>
                            
                            <div class="navbar-collapse collapse clearfix">
                                @if(count($mainMenuData)>0)
                                    <ul class="navigation clearfix">
                                        @foreach($mainMenuData as $key=>$item)
                                            <?php  $menuitem = mainMenuItem($item->id); ?>
                                            @if($menuitem)
                                                <li class="<?php if(isset($item->children)){ echo 'dropdown'; } ?>">
                                                    @if($menuitem->type=='custom')
                                        				<a class="" href="{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                        		    @endif
                                        		    @if($menuitem->type=='pages')
                                        				<a class="" href="/pages/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                        		    @endif
                                        		    @if($menuitem->type=='events')
                                        				<a class="" href="/events/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                        		    @endif
                                        		    @if($menuitem->type=='notice')
                                        				<a class="" href="/notice/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                        		    @endif
                                        		    @if(isset($item->children))
                                        		        <ul>
                                        		            @foreach($item->children as $key=>$child)
                                        		                @php  $menuitem1 = App\Models\Menuitems::where('id',$child->id)->first(); @endphp
                                        		                @if($menuitem1)
                                                                    <li>
                                                                        @if($menuitem1->type=='custom')
                                                            				<a class="" href="{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                            		    @endif
                                                            		    @if($menuitem1->type=='pages')
                                                            				<a class="" href="/pages/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                            		    @endif
                                                            		    @if($menuitem1->type=='events')
                                                            				<a class="" href="/events/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                            		    @endif
                                                            		    @if($menuitem1->type=='notice')
                                                            				<a class="" href="/notice/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                            		    @endif
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                        		    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End Header Upper-->
        
        <!--Sticky Header-->
        <div class="sticky-header">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo pull-left">
                    <a href="{{url('/')}}" class="img-responsive"><img src="{{ asset(getSiteLogo()) }}" height='60' alt="{{getsiteTitle()}}" title="{{getsiteTitle()}}"></a>
                </div>
                <!--Right Col-->
                <div class="right-col pull-right">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->      
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix">
                            @if(count($mainMenuData)>0)
                                <ul class="navigation clearfix">
                                    @foreach($mainMenuData as $key=>$item)
                                        <?php  $menuitem = mainMenuItem($item->id); ?>
                                        @if($menuitem)
                                            <li class="<?php if(isset($item->children)){ echo 'dropdown'; } ?>">
                                                @if($menuitem->type=='custom')
                                    				<a class="" href="{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                    		    @endif
                                    		    @if($menuitem->type=='pages')
                                    				<a class="" href="/pages/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                    		    @endif
                                    		    @if($menuitem->type=='events')
                                    				<a class="" href="/events/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                    		    @endif
                                    		    @if($menuitem->type=='notice')
                                    				<a class="" href="/notice/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                                    		    @endif
                                    		    @if(isset($item->children))
                                    		        <ul>
                                                        @foreach($item->children as $key=>$child)
                                    		                @php  $menuitem1 = App\Models\Menuitems::where('id',$child->id)->first(); @endphp
                                    		                @if($menuitem1)
                                                                <li>
                                                                    @if($menuitem1->type=='custom')
                                                        				<a class="" href="{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                        		    @endif
                                                        		    @if($menuitem1->type=='pages')
                                                        				<a class="" href="/pages/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                        		    @endif
                                                        		    @if($menuitem1->type=='events')
                                                        				<a class="" href="/events/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                        		    @endif
                                                        		    @if($menuitem1->type=='notice')
                                                        				<a class="" href="/notice/{{$menuitem1->slug}}">{{$menuitem1->title}}</a>
                                                        		    @endif
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                    		    @endif
                                            </li>
                                        @endif
                                    @endforeach
                            </ul>
                            @endif
                        </div>
                    </nav><!-- Main Menu End-->
                </div>
                
            </div>
        </div>
        <!--End Sticky Header-->
</header>