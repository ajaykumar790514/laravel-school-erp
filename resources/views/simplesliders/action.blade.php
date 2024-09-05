<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('simple-sliders-edit')
		    <li><a href='{{url("/simple-sliders-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
            <li class="divider"></li>
        @can('simple-sliders-edit')
        <li>
            <a href='{{$id}}' class=' delete  ' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Delete</a>
            
        </li>
		@endcan
	</ul>
</li>
</ul>