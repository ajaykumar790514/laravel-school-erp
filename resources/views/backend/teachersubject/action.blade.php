@can('session-edit')
<a class="btn btn-primary" href='{{ url("/academics/teacher-subject-maping-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a> 
@endcan
@can('session-delete')
 <a href='{{url("/academics/teacher-subject-maping-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
 @endcan