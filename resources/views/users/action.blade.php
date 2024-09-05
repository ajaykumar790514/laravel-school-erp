<a class="btn btn-primary btn-sm openShowModal" show-id='{{$id}}'  id='editID' href='{{$id}}'><i class=' icon-eye'></i> show</a> 

@can('user-edit')
<a class="btn btn-primary btn-sm openEditModal" edit-id='{{$id}}'  id='editID' href='{{$id}}'><i class=' icon-pencil'></i> Edit</a> 
@endcan
@can('user-delete')
 <a href='{{$id}}' class='btn btn-danger delete btn-sm ' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a>
@endcan
