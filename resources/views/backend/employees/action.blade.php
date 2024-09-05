<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			@can('employees-upload-documents')
			<li>
				 <a href='{{url("employees-upload-documents/{$id}")}}' class=' '><i class='icon-upload4'></i> Upload Documents</a>
				</li>
			 @endcan
			 @can('employees-view')
			<li>
				 <a href='{{url("employees-view/{$id}")}}' class=' '><i class=' icon-magazine'></i> View</a>
				</li>
			 @endcan
			@can('employees-edit')
			<li>
				<a class="" href='{{ url("employees-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a> 
			</li>	
			@endcan
			@can('employees-delete')
			<li>
				 <a href='{{url("employees-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i class=' icon-cancel-circle2'></i> Delete</a>
				</li>
			 @endcan
			
		</ul>
	</li>
</ul>