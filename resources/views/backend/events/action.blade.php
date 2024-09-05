<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-right">
			
			@can('events-view')
			<li>
				<a class="" href='{{ url("/academics/events-view/{$id}")}}'><i class=' icon-magazine'></i> View</a> 
			</li>	
			@endcan
			@can('events-edit')
			<li>
				<a class="" href='{{ url("/academics/events-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a> 
			</li>	
			@endcan
			@can('events-delete')
			<li>
				 <a href='{{url("/academics/events-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i class=' icon-cancel-circle2'></i> Delete</a>
				</li>
			 @endcan
			
		</ul>
	</li>
</ul>

