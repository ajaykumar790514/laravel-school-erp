<li>
    @php  $menuitem = App\Models\Menuitems::where('id',$child->id)->first(); @endphp
    @if($menuitem->type=='custom')
    	<a class="dropdown-item font-weight-normal" href="{{$menuitem->slug}}">
    		{{$menuitem->title}}
    	</a>
	@endif
	@if($menuitem->type=='pages')
    	<a class="dropdown-item font-weight-normal" href="/pages/{{$menuitem->slug}}">
    		{{$menuitem->title}}
    	</a>
	@endif
	@if($menuitem->type=='diseases')
    	<a class="" href="/diseases/{{$menuitem->slug}}">{{$menuitem->title}}</a>
	@endif
	@if($menuitem->type=='health-services')
    	<a class="" href="/health-services/{{$menuitem->slug}}">{{$menuitem->title}}</a>
	@endif
</li>