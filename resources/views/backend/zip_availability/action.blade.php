<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @can('zip-availability-edit')
		    <li><a class="openEditModal" edit-id='{{$id}}'  id='editID' href='{{$id}}'><i class="icon-pencil7"></i> Edit</a></li>
		@endcan
        <li class="divider"></li>
        @can('zip-availability-delete')
            <li><a href='{{$id}}' class='delete' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
		@endcan
	</ul>
</li>
</ul>
