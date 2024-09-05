<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
		<!--	@can('parent-login-create')
			<li>
				 <a href='{{url("parent-login-create/{$id}")}}' class=' '><i style="color: red" class='icon-lock'></i>Create Parents Login</a>
			</li>
			 @endcan-->
			 @can('add-more-student')
			<li><a href='{{url("add-more-student/{$parentID}")}}' class=' '><i style="color: red" class='icon-users'></i>Add More Student</a></li>
			 @endcan
			@can('student-upload-documents')
			<li>
				 <a href='{{url("/student-upload-documents/{$id}")}}' class=''><i style="color: #f25320" class='icon-upload4 danger'></i> Upload Documents</a>
				</li>
			 @endcan
			 @can('student-view')
			<li>
				 <a href='{{url("student-view/{$id}")}}' class=' '><i  style="color: #48a64c" class=' icon-magazine'></i> View</a>
				</li>
			 @endcan
			
			@can('student-delete')
			<li>
				 <a href='{{url("student-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class=' '><i style="color: red" class=' icon-cancel-circle2'></i> Delete</a>
				</li>
			 @endcan
			
		</ul>
	</li>
</ul>
