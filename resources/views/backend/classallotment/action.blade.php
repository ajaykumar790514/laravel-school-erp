@can('promoted-studen-delete')
@if($rollnumber=="")
 <a href='{{url("promoted-studen-delete/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
@endif
 @endcan
