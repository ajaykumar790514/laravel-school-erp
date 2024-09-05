<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<i class="icon-menu9"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			<li>@can('user-edit')
                    <a class="openEditModal" edit-id='{{$id}}'  id='editID' href='{{$id}}'><i class=' icon-pencil'></i> Edit</a> 
                @endcan
			</li>
			<li>@can('menu-delete')
                    <a href='{{$id}}' class=' delete  ' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Delete</a>
                 @endcan
            </li>
		</ul>
	</li>
</ul>





