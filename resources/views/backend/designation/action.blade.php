@can('designation-edit')
<a class="btn btn-primary" href='{{ url("designation-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit</a>
@endcan
@can('designation-delete')
 <a href='{{url("designation-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
 @endcan