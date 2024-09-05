<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-right">
		    @can('contact-delete') 
			    <li><a href='{{$id}}' class='delete' delete-id='{{$id}}' id='deleteID'> Delete</a></li>
			@endcan
		</ul>
	</li>
</ul>

