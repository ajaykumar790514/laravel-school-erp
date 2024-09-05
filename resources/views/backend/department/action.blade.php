@can('department-edit')
<a class="btn btn-primary" href='{{ url("department-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a>
@endcan
@can('department-delete')
 <a href='{{url("department-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
 @endcan