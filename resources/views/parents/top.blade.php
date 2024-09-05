<div class="navbar navbar-inverse" >
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ url('/')}}">
			   <img src="{{ URL::to('public/'.getSiteLogo())}}" style="background: white; width: 55px; height: 46px; margin-top: -13px;" alt="{{ getsiteTitle()}}">
			</a>
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('admin/images/placeholder.jpg')}}" alt="">
						<span> {{ Auth::user()->name }}</span>
						<i class="caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
					   <li>
					       <a href="{{ url('/changepassword')}}"><i class="icon-user-plus"></i> Change Password</a>
					   </li>
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