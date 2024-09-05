<div class="header-wrap">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-12 navbar-light">
        <div class="logo"> <a href="{{url('/')}}">
            <img alt="{{ getsiteTitle()}}" title='{{ getsiteTitle()}}' class="logo-default" src="{{ asset(getSiteLogo()) }}" style="height:80px"></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
        aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="navigation-wrap" id="filters">
          <nav class="navbar navbar-expand-lg navbar-light"> 
          <a class="navbar-brand" href="#">Menu</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <button class="close-toggler" type="button" data-toggle="offcanvas"> <span><i class="fas fa-times-circle" aria-hidden="true"></i></span> </button>
              <ul class="navbar-nav mr-auto">
                 @if(count(headermenu())>0)
                    @foreach(headermenu() as $key=>$item)
                        <?php  $menuitem = mainMenuItem($item->id); ?>
                        @if($menuitem)
                            <li class="nav-item"> 
                                @if($menuitem->type=='custom')
                    				<a class="nav-link <?php if(url()->current()==$menuitem->slug){ echo 'active';}?>" href="{{$menuitem->slug}}">{{$menuitem->name==""?$menuitem->title:$menuitem->name}}</a>
                    		    @endif
                    		    @if($menuitem->type=='pages')
                    				<a class="nav-link <?php if(Request::segment(2)==$menuitem->slug){ echo 'active';}?>" href="/pages/{{$menuitem->slug}}">{{$menuitem->name==""?$menuitem->title:$menuitem->name}}</a>
                    		    @endif
                    		    @if($menuitem->type=='events')
                    				<a class="nav-link " href="/events/{{$menuitem->slug}}">{{$menuitem->name==""?$menuitem->title:$menuitem->name}}</a>
                    		    @endif
                    		    @if($menuitem->type=='notice')
                    				<a class="nav-link " href="/notice/{{$menuitem->slug}}">{{$menuitem->name==""?$menuitem->title:$menuitem->name}}</a>
                    		    @endif 
                    		    @if(isset($item->children))
                    		        <i class="fas fa-caret-down"></i>
                    		        <ul class="submenu">
                    		            @foreach($item->children as $key=>$child)
                    		                @php  $menuitem1 = App\Models\Menuitems::where('id',$child->id)->first(); @endphp
                                        		 @if($menuitem1)
                                                    <li>
                                                        @if($menuitem1->type=='custom')
                                            				<a class="" href="{{$menuitem1->slug}}">{{$menuitem1->name==""?$menuitem1->title:$menuitem1->name}}</a>
                                            		    @endif
                                            		    @if($menuitem1->type=='pages')
                                            				<a class="" href="/pages/{{$menuitem1->slug}}">{{$menuitem1->name==""?$menuitem1->title:$menuitem1->name}}</a>
                                            		    @endif
                                            		    @if($menuitem1->type=='events')
                                            				<a class="" href="/events/{{$menuitem1->slug}}">{{$menuitem1->name==""?$menuitem1->title:$menuitem1->name}}</a>
                                            		    @endif
                                            		    @if($menuitem1->type=='notice')
                                            				<a class="" href="/notice/{{$menuitem1->slug}}">{{$menuitem1->name==""?$menuitem1->title:$menuitem1->name}}</a>
                                            		    @endif
                                                    </li>
                                                @endif
                                        @endforeach
                                     </ul>
                    		    @endif
                                
                            </li>
                        @endif
                    @endforeach
                @endif
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>