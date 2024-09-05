@if($status==0)
<a class="btn bg-success"  title="Click for change attendance " onclick="return confirm('Are you sure change attendance status?');"   href='{{ url("/attendance/update_attendance/{$id}/1")}}'>Present</a>
@else
<a class="btn bg-pink" title="Click for change attendance " onclick="return confirm('Are you sure change attendance status?');" href='{{ url("/attendance/update_attendance/{$id}/0")}}'>Absent</a>
@endif


