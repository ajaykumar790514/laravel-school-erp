@can('blocks-edit')
<!--<a class="btn btn-primary btn-sm openEditModal" edit-id='{{$id}}'  id='editID' href='{{$id}}'><i class=' icon-pencil'></i> Edit</a> -->
<a href='{{url("/blocks-edit/{$id}")}}' class='btn btn-primary btn-sm'><i class="icon-pencil7"></i> Edit</a>
@endcan
