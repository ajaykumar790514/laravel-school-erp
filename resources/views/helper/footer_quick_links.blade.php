
@if($quickLinks!='')
<div class="col-12 col-sm-12 col-md-4 col-lg-2 footer-links">
        <h4 class="h4 body-font">Quick Shop</h4>
        <ul>
			     @foreach($quickLinks as $key=>$item)
				    @php  $menuitem = App\Models\Menuitems::where('id',$item->id)->first(); @endphp
				    @if(!empty($menuitem))
				        <li>
				            @if($menuitem->type=='custom')
        						<a class="" href="{{$menuitem->slug}}">{{$menuitem->title}}</a>
						    @endif
						    @if($menuitem->type=='pages')
                            	<a class="" href="/pages/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                        	@endif
                        	@if($menuitem->type=='category')
                            	<a class="" href="/category/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                        	@endif
                        	@if($menuitem->type=='product')
                				<a class="" href="/product/{{$menuitem->slug}}">{{$menuitem->title}}</a>
                		    @endif
				        </li>
				    @endif
				@endforeach
													
		</ul>
</div>
@endif