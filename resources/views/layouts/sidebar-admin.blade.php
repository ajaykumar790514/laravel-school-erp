<!-- Main sidebar -->
<div class="sidebar sidebar-main">
                <div class="sidebar-content">
                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">
                                <!-- Main -->
                            @auth()
                                <li class="<?php if(Request::url()== url('dashboard')){ echo 'active';}?>" >
                                    <a href="{{ url('dashboard')}}"><i class="icon-home4"></i> <span>Dashboard</span></a>
                                </li>
                                @canany(['session-list', 'classsetup-list', 'student-list', 'student-class-allotment', 'student-roll-number-allotment']) 
                                <li class="<?php if(Request::url()==url('session-list') 
                                    || Request::url()==url('session-create') 
                                    || Request::segment(2)=='session-edit' 
                                    || Request::url()==url('classsetup-list')
                                    || Request::url()==url('sectionsetup-list')
                                    || Request::url()==url('subjectssetup-list') 
                                    || Request::url()==url('classsectionmaping-list')
                                    || Request::url()==url('admission/classes-register')
                                    ){ echo 'active';}?>">
                                    <a href="#"><i class="icon-magazine"></i> <span>ADMISSION</span></a>
                                    <ul>
                                        <li class="<?php if(Request::url()==url('session-list') 
                                        || Request::segment(1)=='session-create' 
                                        || Request::segment(1)=='session-edit' 
                                        || Request::segment(1)=='classsetup-list'
                                        || Request::segment(1)=='sectionsetup-list'
                                        || Request::segment(1)=='subjectssetup-list'
                                        || Request::segment(1)=='classsectionmaping-list'
                                        ){ echo 'active';}?>">
                                            <a href="#">MASTER</a>
                                            <ul>
                                                @can('session-list') 
                                                <li class="<?php if(Request::segment(1)=='session-list' || Request::segment(1)=='session-create' || Request::segment(1)=='session-edit'){ echo 'active';}?>"><a href="{{ url('session-list')}}">Session Setup </a></li>
                                                @endcan
                                                @can('classsetup-list') 
                                                <li class="<?php if(Request::segment(1)=='classsetup-list' || Request::segment(1)=='classsetup-create' || Request::segment(1)=='classsetup-edit'){ echo 'active';}?>"><a href="{{ url('classsetup-list')}}">Class Setup</a></li>
                                                @endcan
                                                @can('sectionsetup-list') 
                                                <li class="<?php if(Request::segment(1)=='sectionsetup-list' || Request::segment(1)=='sectionsetup-create' || Request::segment(1)=='sectionsetup-edit'){ echo 'active';}?>"><a href="{{ url('sectionsetup-list')}}">Section Setup</a></li>
                                                 @endcan
                                                 @can('subjectssetup-list') 
                                                <li class="<?php if(Request::segment(1)=='subjectssetup-list' || Request::segment(1)=='subjectssetup-create' || Request::segment(1)=='subjectssetup-edit'){ echo 'active';}?>"><a href="{{ url('subjectssetup-list')}}">Subject Setup</a></li>
                                                 @endcan
                                                  @can('classsectionmaping-list') 
                                                <li class="<?php if(Request::segment(1)=='classsectionmaping-list' || Request::segment(1)=='classsectionmaping-create' || Request::segment(1)=='classsectionmaping-edit'){ echo 'active';}?>"><a href="{{ url('classsectionmaping-list')}}" >Class & Section Mapping</a></li>
                                                  @endcan
                                            </ul>
                                        </li>
                                        
                                    </ul>
                                </li>
                                @endcanany
                                @canany(['class-teacher-list', 'subject-class-maping-list', 'subject-class-maping-list', 'dailydiaries-list', 'notice-list', 'assignment-holidays-list', 'events-list'])
                                <li class="<?php if(Request::segment(2)=='class-teacher-list' 
                                    || Request::segment(2)=='class-teacher-create'
                                    || Request::segment(2)=='class-teacher-edit'
                                    || Request::segment(2)=='teacher-subject-maping-list'
                                    || Request::segment(2)=='assignment-holidays-list'
                                    
                                    ){ echo 'active';}?>">
                                    <a href="#"><i class=" icon-graduation2"></i> <span>ACADEMICS</span></a>
                                    <ul>
                                        
                                        @canany(['dailydiaries-list', 'notice-list', 'assignment-holidays-list', 'events-list'])
                                        <li class="<?php if(Request::segment(2)=='dailydiaries-list'
                                                            || Request::segment(2)=='notice-list'
                                                            || Request::segment(2)=='assignment-holidays-list'
                                                ){ echo 'active';}?>">

                                            <a href="#">MENU</a>
                                            <ul>
                                                @can('dailydiaries-list')
                                                <li class="<?php if(Request::segment(2)=='dailydiaries-list'
                                                                || Request::segment(2)=='dailydiaries-create'
                                                                || Request::segment(2)=='dailydiaries-edit'
                                                                || Request::segment(2)=='dailydiaries-view'
                                                ){ echo 'active';}?>"><a href="{{ url('/academics/dailydiaries-list')}}">Daily Diary</a></li>
                                                @endcan
                                                @can('assignment-holidays-list')
                                                <li class="<?php if(Request::segment(2)=='assignment-holidays-list'
                                                                || Request::segment(2)=='assignment-holidays-create'
                                                                || Request::segment(2)=='assignment-holidays-edit'
                                                                || Request::segment(2)=='assignment-holidays-view'
                                                ){ echo 'active';}?>"><a href="{{ url('/academics/assignment-holidays-list')}}">Assignment/Holidays Homework</a></li>
                                                @endcan
                                                @can('notice-list')
                                                <li class="<?php if(Request::segment(2)=='notice-list'
                                                                || Request::segment(2)=='notice-create'
                                                                || Request::segment(2)=='notice-edit'
                                                                || Request::segment(2)=='notice-view'
                                                ){ echo 'active';}?>"><a href="{{ url('/academics/notice-list')}}">Circular/Notice</a></li>
                                                @endcan
                                                @can('events-list')
                                                <li class="<?php if(Request::segment(2)=='events-list'
                                                                || Request::segment(2)=='events-create'
                                                                || Request::segment(2)=='events-edit'
                                                                || Request::segment(2)=='events-view'
                                                ){ echo 'active';}?>"><a href="{{ url('/academics/events-list')}}">School / Events Calendar</a></li>
                                                @endcan
                                            </ul>
                                        </li>
                                        @endcan
                                    </ul>
                                </li>
                                @endcanany
                                
                                @canany(['media-category-list', 'media-gallery-create', 'media-gallery-list', 'video-gallery-create', 'video-gallery-list'])
                                <li class="<?php if(Request::segment(1)== 'media-category-list' 
                                || Request::segment(1)== 'media-category-edit'){ echo 'active';}?>">
                                    <a href="#"><i class="icon-images2"></i> <span>Media Gallery</span></a>
                                    <ul>
                                        @canany(['media-category-list'])
                                        <li class="<?php if(Request::segment(1)=='media-category-create'
                                        || Request::segment(1)== 'media-category-list'
                                        || Request::segment(1)== 'media-category-edit'){ echo 'active';}?>"><a href="{{ url('media-category-list')}}">Media Category</a></li>
                                        @endcan
                                        @canany(['media-gallery-list'])
                                        <li class="<?php if(Request::segment(1)=='media-gallery-list'
                                       || Request::segment(1)=='media-gallery-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('media-gallery-list')}}">Image Gallery</a></li>
                                         @endcan
                                         @canany(['video-gallery-list'])
                                        <li class="<?php if(Request::segment(1)=='video-gallery-list'
                                       || Request::segment(1)=='video-gallery-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('video-gallery-list')}}">Video Gallery</a></li>
                                         @endcan
                                    </ul>
                                </li>
                                @endcanany
                                @canany(['blog-list'])
                                <li class="<?php if(Request::url()== url('blog-list') || Request::url()== url('blog-list') ){ echo 'active';}?>">
                                    <a href="#"><i class=" icon-books"></i> <span>Blog</span></a>
                                    <ul>
                                        @canany(['blog-list'])
                                        <li class="<?php if(Request::segment(1)=='blog-create'){ echo 'active';}?>"><a href="{{ url('/blog-create')}}">Blog Create</a></li>
                                        @endcan
                                        @canany(['blog-list'])
                                        <li class="<?php if(Request::segment(1)=='blog-list'
                                       || Request::segment(1)=='blog-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('/blog-list')}}">Blog List</a></li>
                                         @endcan
                                    </ul>
                                </li>
                                @endcanany
                                
                                
                                @canany(['testimonals'])
                                <li class="<?php if(Request::url()== url('testimonals') || Request::url()== url('testimonals') ){ echo 'active';}?>">
                                    <a href="#"><i class="icon-quill4"></i> <span>Testimonals</span></a>
                                    <ul>
                                       
                                        @canany(['testimonals'])
                                        <li class="<?php if(Request::segment(1)=='testimonals'
                                       || Request::segment(1)=='testimonals-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('/testimonals')}}">Testimonals List</a></li>
                                         @endcan
                                    </ul>
                                </li>
                                @endcanany
                                
                                @canany(['announcements'])
                                <li class="<?php if(Request::url()== url('announcements') || Request::url()== url('announcements') ){ echo 'active';}?>">
                                    <a href="#"><i class="icon-megaphone"></i> <span>Announcements</span></a>
                                    <ul>
                                       
                                        @canany(['announcements'])
                                        <li class="<?php if(Request::segment(1)=='announcements'
                                       || Request::segment(1)=='announcements-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('/announcements')}}">Announcements List</a></li>
                                         @endcan
                                    </ul>
                                </li>
                                @endcanany
                                
                                @canany(['menu-list', 'cms-list', 'manage-menus', 'simple-sliders', 'blocks'])
                                <li>
                                    <a href="#"><i class=" icon-sphere"></i> <span>Website Moduels</span></a>
                                    <ul>
                                        @can(['manage-menus'])
                                        <li class="<?php if(Request::segment(1)== 'manage-menus'){ echo 'active';}?>">
                                            <a href="{{ url('manage-menus')}}">Menu</a>
                                        </li>
                                        @endcan
                                        @can(['menu-list'])
                                        <li class="<?php if(Request::segment(1)== 'menu-list'){ echo 'active';}?>">
                                            <a href="{{ url('menu-list')}}">Menu Master</a>
                                        </li>
                                        @endcan
                                        <li class="<?php if(Request::segment(1)== 'cms-list' 
                                                        || Request::segment(1)=='cms-create'
                                                        || Request::segment(1)=='cms-edit'
                                                        || Request::segment(1)=='cms-view'){ echo 'active';}?>">
                                            <a href="{{ url('cms-list')}}">CMS Pages</a>
                                        </li>
                                        <li class="<?php if(Request::segment(1)== 'simple-sliders' 
                                                        || Request::segment(1)=='simple-sliders-create'
                                                        || Request::segment(1)=='simple-sliders-edit'){ echo 'active';}?>">
                                            <a href="{{ url('simple-sliders')}}">Slider</a>
                                        </li>
                                        <li class="<?php if(Request::segment(1)== 'blocks'  
                                                || Request::segment(1)=='blocks-create'
                                                 || Request::segment(1)=='blocks-edit'){ echo 'active';}?>">
                                            <a href="{{ url('blocks')}}">Blocks</a>
                                        </li>
                                    </ul>
                                </li>
                                @endcanany
                                
                               @canany(['role-list', 'users-list'])
                                <li class="<?php if(Request::segment(1)=='role-list'  || Request::segment(1)=='user-list'
                                    ){ echo 'active';}?>">
                                    <a href="#"><i class="icon-user-tie"></i> <span>USER MANAGMENT</span></a>
                                    <ul>
                                        @canany(['user-list', 'user-edit', 'user-create'])
                                        <li class="<?php if(Request::segment(1)=='user-list'
                                        || Request::segment(1)=='user-create'
                                        || Request::segment(1)=='user-edit'
                                        ){ echo 'active';}?>"><a href="{{ url('user-list')}}">User</a></li>
                                         @endcan
                                        @can('role-list') 
                                        <li <?php if(Request::segment(1)=='role-list'
                                        || Request::segment(1)=='role-edit' 
                                        || Request::segment(1)=='role-create' 
                                        ){ echo 'active';}?>>
                                            <a href="{{ url('role-list')}}">Role</a>
                                        </li>
                                        @endcan
                                        
                                       @can('users-list') 
                                        <li <?php if(Request::segment(1)=='users' || Request::segment(2)=='create'){ echo 'active';}?>><a href="{{ route('users.index') }}">User</a></li>
                                       @endcan
                                    </ul>
                                </li>
                               @endcanany
                               @can('contact-list') 
                                <li class="<?php if(Request::url()== url('/contact-list')){ echo 'active';}?>">
                                    <a href="{{ url('/contact-list')}}"><i class=" icon-envelope"></i> <span>Contact Details</span></a>
                                </li>
                               @endcan 
                               @can(['settings', 'smtp-settings']) 
                               <li class="<?php if(Request::url()== url('settings')
                                    || Request::url()== url('smtp-settings')){ echo 'active';}?>">
            							<a href="#" class="has-ul"><i class="icon-gear" style="color:pink"></i> <span>Setting</span></a>
            							<ul>
            								<li class="<?php if(Request::segment(1)=='settings'){ echo 'active';}?>"><a href="{{url('settings')}}">Setting </a></li>
            								<li class="<?php if(Request::segment(1)=='smtp-settings'){ echo 'active';}?>"><a href="{{url('smtp-settings')}}">SMTP Settings</a></li>
            							</ul>
        						</li>
                                @endcan
                        @endauth
                                <!-- /main -->
                            <li class="<?php if(Request::url()== url('/menu-help')
                            || Request::url()== url('blocks-help')
                            || Request::url()== url('pages-help')){ echo 'active';}?>">
    							<a href="#" class="has-ul"><i class="icon-lifebuoy" style="color:pink"></i> <span>Help</span></a>
    							<ul>
    								<li><a href="#">Menu </a></li>
    								<li><a href="#">Block Code</a></li>
    							</ul>
							</li>

                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->