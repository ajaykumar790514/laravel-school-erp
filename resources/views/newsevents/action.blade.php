<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('newsevents-view')
	        <li><a href='{{url("/newsevents/{$slug}")}}' target="_blank"><i class="icon-eye"></i> View</a></li>
	    @endcan
	    @can('newsevents-edit')
		    <li><a href='{{url("/newsevents-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
            <li class="divider"></li>
        @can('newsevents-edit')
        <li>
            <a href='{{url("/newsevents-delete/{$id}")}}'  onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Move to trash</a>
        </li>
		@endcan
	</ul>
</li>
</ul>