<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('product-view')
	        <li><a href='{{url("/product/{$slug}")}}' target="_blank"><i class="icon-eye"></i> View</a></li>
	    @endcan
	    @can('product-edit')
		    <li><a href='{{url("/product-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
		<!--@if($data->product_type==0)
    		@can('product-single-stock')
    		    <li><a href='{{url("/product-single-stock/{$id}")}}' title='Single Stock Manage'><i class="icon-pencil7"></i> Single Stock Manage</a></li>
    		@endcan
    	@endif-->
    	<!--@if($data->product_type==1)
    		@can('product-variant-stock')
    		    <li><a href='{{url("/product-variant-stock/{$id}")}}' title='Variant Stock Manage'><i class="icon-pencil7"></i> Variant Stock Manage</a></li>
    		@endcan
    	@endif-->
        <li class="divider"></li>
        @can('product-delete')
        <li>
            <a href='{{url("/product-delete/{$id}")}}'  onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Move to trash</a>
        </li>
		@endcan
	</ul>
</li>
</ul>