<ul class="icons-list">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
			<i class="icon-menu9"></i>
		</a>

		<ul class="dropdown-menu dropdown-menu-right">
			<li>
				 <a href='{{ url("/attendance/update_employee_attendance/{$id}/0")}}' onclick="return confirm('Are you sure? You want to make present');"  class=' '><i class='icon-user-check' style="color:green"></i> Present</a>
				</li>
			 <li>
				 <a href='{{ url("/attendance/update_employee_attendance/{$id}/1")}}' onclick="return confirm('Are you sure? You want to make Absent');" class=' '><i class=' icon-user-block' style="color:red"></i> Absent</a>
				</li>
			<li>
				<a class="" href='{{ url("/attendance/update_employee_attendance/{$id}/2")}}' onclick="return confirm('Are you sure? You want to make Half Time');"><i class=' icon-user-minus' style="color: blue"></i> Half Time</a> 
			</li>	
			<li>
				 <a href='{{ url("/attendance/update_employee_attendance/{$id}/3")}}' onclick="return confirm('Are you sure? You want to make Late');" class=' '><i class=' icon-user-lock' style="color: grey"></i> Late</a>
				</li>
			
			
		</ul>
	</li>
</ul>
