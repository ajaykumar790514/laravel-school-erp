<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('blog-view')
	        <li><a href='{{url("/blog/{$slug}")}}' target="_blank"><i class="icon-eye"></i> View</a></li>
	    @endcan
	    @can('blog-edit')
		    <li><a href='{{url("/blog-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
            <li class="divider"></li>
        @can('blog-edit')
        <li>
            <a href='{{url("/blog-delete/{$id}")}}'  onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Move to trash</a>
        </li>
		@endcan
	</ul>
</li>
</ul>