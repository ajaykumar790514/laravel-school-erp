@can('teacher-login-edit')
<a class="btn btn-primary" href='{{url("teacher-login-edit/{$id}")}}'><i class=' icon-pencil'></i> Edit/Reset Password</a> 
@endcan
@can('teacher-login-delete')
 <a href='{{url("teacher-login-delete/{$id}")}}' class='btn btn-danger ' onclick="return confirm('Are you sure?');"><i class=' icon-cancel-circle2'></i> Delete</a>
@endcan