<ul class="icons-list">
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="icon-menu9"></i>
	</a>
	<ul class="dropdown-menu dropdown-menu-right">
	    @if($status==1)
		<li><a class="" href='{{url("fee-invoice-pdf/{$invoice_no}")}}'><i class="icon-download"></i>Download </a></li>
		@endif
        
        @if($status==0)
            <li><a href='{{url("removeInvoice/{$invoice_no}")}}' onclick="return confirm('Are you sure?');"  id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
		@elseif(date('Y-m-d', strtotime($created_date))==date('Y-m-d'))
            <li><a href='{{url("removeInvoice/{$invoice_no}")}}' onclick="return confirm('Are you sure?');"  id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
		@endif
		
		
		@can('fee-register')
		<li><a class="" href='{{url("fee-register/{$studentId}")}}'><i class="icon-eye"></i> Fee Register</a></li>
		@endcan
	</ul>
</li>
</ul>