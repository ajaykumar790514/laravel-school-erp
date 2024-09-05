<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('sectionsetup-edit')
		    <li><a class="" href='{{url("sectionsetup-edit/{$id}")}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
        <li class="divider"></li>
        @can('sectionsetup-delete')
            <li><a href='{{url("sectionsetup-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='delete' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
		@endcan
	</ul>
</li>
</ul>
