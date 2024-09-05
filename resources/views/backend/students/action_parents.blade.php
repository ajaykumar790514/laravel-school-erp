<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-right">
			 @can('add-more-student')
			<li><a href='{{url("add-more-student/{$id}")}}' class=' '><i style="color: red" class='icon-users'></i>Add More Student</a></li>
			 @endcan
		
			@can('parent-delete')
			<li>
				 <a href='{{url("parent-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i style="color: red" class=' icon-cancel-circle2'></i> Delete</a>
				</li>
			 @endcan
			
		</ul>
	</li>
</ul>
