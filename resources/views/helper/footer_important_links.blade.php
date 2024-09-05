@if($importantLinks!='')
<div class="col-12 col-sm-12 col-md-4 col-lg-3 footer-links">
     <h4 class="h4 body-font">Important Links</h4>
	<ul class="ps-4">
    	 @foreach($importantLinks as $key=>$item)
    	    @php  $menuitem = App\Models\Menuitems::where('id',$item->id)->first(); @endphp
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
    	@endforeach
    </ul>
</div>
@endif
