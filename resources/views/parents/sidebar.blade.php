<!-- Main sidebar -->
<div class="sidebar sidebar-main">
                <div class="sidebar-content">
                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">
                                <!-- Main -->
                            @auth()
                                <li class="<?php if(Request::segment(2)== url('dashboard')){ echo 'active';}?>" >
                                    <a href="{{ url('parents/dashboard')}}"><i class="icon-home4"></i> <span>Dashboard</span></a>
                                </li>
                                <li class="">
                                    <a href="#"><i class=" icon-people"></i> <span>PARENT MODULE</span></a>
                                    <ul>
                                       
                                       <li class="<?php if(Request::segment(2)=='daily-diary-list' || Request::segment(2)=='daily-diary-view' 
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/daily-diary-list')}}">Daily Diary</a>
                                         </li>
                                        <li class="<?php if(Request::segment(2)=='assignment-for-parents'
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/assignment-for-parents')}}">Assignment/Homework</a>
                                         </li>
                                        
                                        <li class="<?php if(Request::segment(2)=='notice-for-parents'
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/notice-for-parents')}}">Circular/Notices</a></li>
                                        <li class="<?php if(Request::segment(2)=='events-for-parents'
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/events-for-parents')}}">School/Event Calendar</a></li>
                                        <li><a href="">Student Profile</a></li>
                                        <li><a href="">Student Attendance</a></li>
                                        <li><a href="">Fee Details</a></li>
                                        <li><a href="">Test/Exam Marks</a></li>
                                        
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="#"><i class=" icon-file-check"></i> <span>ATTENDANCE</span></a>
                                    <ul>
                                       
                                       <li class="<?php if(Request::segment(2)=='daily-diary' || Request::segment(2)=='daily-diary-view' 
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/daily-diary')}}">Present List</a>
                                         </li>
                                        <li class="<?php if(Request::segment(2)=='assignment-for-parents'
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/assignment-for-parents')}}">Absent List</a>
                                         </li>
                                        
                                        <li class="<?php if(Request::segment(2)=='notice-for-parents'
                                           ){ echo 'active';}?>"><a href="{{ url('/parents/notice-for-parents')}}">Attendeance Chart</a></li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="#"><i class=" icon-price-tag"></i> <span>Fee Module</span></a>
                                    <ul>
                                       <li class="<?php if(Request::segment(2)=='invoicelist'){ echo 'active';}?>"><a href="{{ url('/parents/invoicelist')}}">Invoice List</a>
                                         </li>
                                    </ul>
                                </li>
                                <li class="<?php if(Request::segment(2)=='parent-profile'){ echo 'active';}?>" >
                                    <a href="{{ url('parents/parent-profile')}}"><i class="icon-magazine"></i> <span>Profile</span></a>
                                </li>
                                <li class="<?php if(Request::segment(2)== 'studentlist' || Request::segment(2)== 'student-view'){ echo 'active';}?>" >
                                    <a href="{{ url('parents/studentlist')}}"><i class="icon-user-plus"></i> <span>Children</span></a>
                                </li>
                                <li class="<?php if(Request::segment(2)== url('change-password')){ echo 'active';}?>" >
                                    <a href="{{ url('parents/change-password')}}"><i class="icon-home4"></i> <span>Change Password</span></a>
                                </li>
                              
                        @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
