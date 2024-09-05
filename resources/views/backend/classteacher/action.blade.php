@can('class-teacher-edit')
<a class="btn btn-primary" href='{{ url("/academics/class-teacher-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a> 
@endcan
@can('class-teacher-delete')
 <a href='{{url("/academics/class-teacher-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
 @endcan