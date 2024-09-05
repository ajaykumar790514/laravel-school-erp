<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('media-category-edit')
		    <li><a href='{{url("/media-category-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
            <li class="divider"></li>
        @can('media-category-edit')
        <li>
            <a href='{{url("/media-category-delete/{$id}")}}'  onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Move to trash</a>
        </li>
		@endcan
	</ul>
</li>
</ul>