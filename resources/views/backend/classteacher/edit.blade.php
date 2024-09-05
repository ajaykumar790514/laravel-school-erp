@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->Edit Class & Teacher Setup</h4>
            </div>
          </div>
        
        </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <?php $id=base64_encode($data->id);?>
                    <form class="" method="POST" action='{{ url("/academics/class-teacher-edit/{$id}")}}' enctype="multipart/form-data">
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
                                            <br>
                                            {{$data->session_name}}
                                            
                                          </div>
                                           <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                            <label>Class <span class="text-danger">*</span></label>
                                            <br>
                                            {{$data->class_name}}
                                          </div>

                                          <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                            <label>Section <span class="text-danger">*</span></label>
                                            <br>
                                            {{$data->class_name}}
                                          </div>
                                        
                                        
                                    </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->status==0?'selected':''}}>Active</option>   
                                                <option value='1' {{$data->status==1?"selected":""}}>Inactive</option>
                                            </select>
                                           </div>

                                           
                                       
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Update Class & Teacher Setup </button>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                   
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
@endsection
@section('script')  
 <script type="text/javascript">
$(document).ready(function(){
    var url = "{{url('/')}}";
      $('#class_id').bind('load, change', function () {
        $('#section_id').empty();
        var id = $('#class_id').val();
        $('#section_id').html('<option selected="selected" value="">Loading...</option>');
        //var url = url + '/get-section/'+id;
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
                    $('#section_id').append('<option value="'+key+'" >'+value+'</option>');
                    $("div.secId select").val(key);
                });

            }
        });
      });
       $('#class_id').trigger('change');
       
});
    </script>
@endsection
