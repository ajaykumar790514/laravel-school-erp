@can('role-edit')
<a class="btn btn-primary btn-sm openEditModal" edit-id='{{$id}}'  id='editID' href='{{$id}}'><i class=' icon-pencil'></i> Edit</a> 
@endcan
@can('role-delete')
    @if(base64_decode($id)!=1 && base64_decode($id)!=2 && base64_decode($id)!=3)
         <a href='{{$id}}' class='btn btn-danger delete btn-sm ' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Delete</a>
    @endif
 @endcan
 