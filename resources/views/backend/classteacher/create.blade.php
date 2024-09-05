@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->Create Class & Teacher Setup</h4>
            </div>
          </div>
        </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('/academics/class-teacher-create')}}" enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('class-teacher-list')
                                    <a href="{{ url('/academics/class-teacher-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i>Class Teacher Setup List</a>
                                 @endcan
                                
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                            <label>Session <span class="text-danger">*</span></label>

                                            <select id="session_id"  class="form-control" name="session_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($sessions)>0)
                                                    @foreach($sessions as $session)
                                                     <option value='{{$session->id}}' <?php echo getSessionDefault()==$session->id?"selected":"";?>>{{$session->session_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                          </div>
                                           <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                            <label>Class <span class="text-danger">*</span></label>
                                            <select id="class_id"  class="form-control" name="class_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($classesmapings)>0)
                                                    @foreach($classesmapings as $classesmaping)
                                                     <option value='{{$classesmaping->class_setups_id}}' <?php echo old('class_id')==$classesmaping->class_setups_id?"selected":"";?>>{{$classesmaping->class_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                          </div>

                                          <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                            <label>Section <span class="text-danger">*</span></label>

                                            <select id="section_id"  class="form-control" name="section_id" >
                                                <option value=''>--Select--</option>
                                                
                                            </select>
                                          </div>
                                        
                                        
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('teacher_id') ? ' has-error' : '' }}">
                                            <label>Teacher <span class="text-danger">*</span></label>
                                                <select id="teacher_id"  class="form-control" name="teacher_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($teachers)>0)
                                                    @foreach($teachers as $teacher)
                                                     <option value='{{$teacher->id}}' <?php echo old('teacher_id')==$teacher->id?"selected":"";?>>{{$teacher->employee_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                          </div>
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ old('status')==0?'selected':''}}>Active</option>   
                                                <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                            </select>
                                           </div>

                                           
                                       
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Save </button>
                                </div>
                            </div>
                        </div>
                    </form>
                   </div>
@endsection
@section('script')  
 <script type="text/javascript">
$(document).ready(function(){
    var url = "{{url('/')}}";
      $('#class_id').bind('load, change', function () {
        $('#section_id').empty();
        var id = $('#class_id').val();
        $('#section_id').html('<option selected="selected" value="">Loading...</option>');
        $.ajax({
            url: "{{ url('get-section') }}",
            type: "GET",
            data: {
                     id:id,
                    
                  },
            dataType: "json",
            success:function(data) {
                //alert(data);
                $('#section_id').html('<option selected="selected" value="">Select Section</option>');
                $.each(data, function(key, value) {
                    $('#section_id').append('<option value="'+key+'">'+value+'</option>');
                });

            }
        });
      });
       $('#class_id').trigger('change');
});
    </script>
@endsection
