<div class="navbar navbar-inverse">
		<div class="navbar-header">
				<a class="navbar-brand" href="{{ url('/')}}">
			   <img src="{{ URL::to('public/'.getSiteLogo())}}" style="width: auto; height: 44px; margin-top: -12px;" alt="{{ getsiteTitle()}}">
			</a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Default Session : {{App\Models\SessionSetups::getSessionName(getSessionDefault())}}
					</a>
					
				</li>

			</ul>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-bubbles4"></i>
						<span class="visible-xs-inline-block position-right">Messages</span>
						<span class="badge bg-warning-400"><?php //echo count($notifications);?></span>
					</a>
					
					<div class="dropdown-menu dropdown-content width-350">
						<div class="dropdown-content-heading">
							Messages
							
						</div>

						{{-- <ul class="media-list dropdown-content-body">
							@if(count($notifications)>0)
								@foreach($notifications as $notification)

							<li class="media">
								<div class="media-body">
									<?php $ContactId=base64_encode($notification['id']);?>
									<a href='{{url("/admin/updatereadstatus/{$ContactId}")}}' class="media-heading">
										<span class="text-semibold">{{$notification['name']}}</span>
										<span class="media-annotation pull-right">{{date('D F Y', strtotime($notification['created_at']))}}</span>
									</a>

									<span class="text-muted">{{$notification['subject']}}</span>
								</div>
							</li>
								@endforeach
							@else
							<span class="text-muted">No any inquiry found </span>
							@endif
							
						</ul> --}}

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All messages"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>

				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('admin/images/placeholder.jpg')}}" alt="">
						<span> {{ Auth::user()->name }}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
					   <li><a href="{{ url('/changepassword')}}"><i class="icon-user-plus"></i> Change Password</a>
					   </li>
					
						<li class="divider"></li>
						@if(Auth::user()->user_type==1)
						<li><a href="{{ url('settings')}}"><i class="icon-cog5"></i>Settings</a></li>
						@endif
						<li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>

						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>