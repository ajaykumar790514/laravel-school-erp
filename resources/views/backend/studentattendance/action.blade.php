@can('student-attendance-list')
<a class="btn bg-pink" href='{{ url("/attendance/student-attendance-list/{$id}/{$sessionId}/{$classmapingId}/{$sectionId}")}}'>Student List</a>
@endcan