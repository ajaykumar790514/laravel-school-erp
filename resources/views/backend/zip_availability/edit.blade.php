<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Zip Availability</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                         <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>State <span class="text-danger">*</span></strong>
                                <select class="form-control" name='edit_state_id' id='edit_state_id'>
									@foreach(get_state() as $state)
                                        <option value="{{$state->id}}">{{ $state->name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>City <span class="text-danger">*</span></strong>
                                <select class="form-control select" name='edit_city_id' id='edit_city_id'>
                                    <option value="">--Select--</option>
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Area </strong>
                                <input type="text" class="form-control" name="edit_area" id="edit_area"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Pincode/Zip Code <span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="edit_pincode" id="edit_pincode"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Available<span class="text-danger">*</span></strong>
                                <select id="edit_available"  class="form-control" name="edit_available" >
                                    <option value=''>--Select--</option>
                                    <option value='0' {{ old('status')==0?"selected":""}}>Yes</option>   
                                    <option value='1' {{old('status')==1?"selected":""}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Days</strong>
                                <input type="text" class="form-control" name="edit_deliver_with_days" id="edit_deliver_with_days" maxlength='3'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Extra Charges</strong>
                                <input type="text" class="form-control" name="edit_extra_charges" id="edit_extra_charges" maxlength='5'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <strong>Status<span class="text-danger">*</span></strong>
                                <select id="edit_status"  class="form-control" name="edit_status" >
                                    <option value=''>--Select--</option>
                                    <option value='0' {{ old('status')==0?"selected":""}}>Active</option>   
                                    <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" id='editButton' class="btn btn-success edit_button">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    // This function for Open modal and fill update data in modal               
    $(document).on('click', '.openEditModal', function (e) {
        e.preventDefault();   
        $('#edit_modal_theme_primary').modal({
            keyboard: false
        })  
        $('#form_edit')[0].reset();
        var id= $(this).attr("href"); 
        
        $.get('zip-availability-loaddata/' + id , function (data) {
           $('#edit_state_id').val(data.data.state_id); 
           loadCity(data.data.city_id);
           $('#edit_area').val(data.data.area); 
           $('#edit_pincode').val(data.data.pincode); 
           $('#edit_deliver_with_days').val(data.data.deliver_with_days); 
           $('#edit_status').val(data.data.status);
           $('#edit_city_id').val(data.data.city_id); 
           $('#edit_save_msgList').html("<input type='hidden' id='hiddenId' name='id' value='"+data.data.id+"'>");    
        })
    }); 
    
    function loadCity(cityId){
        $("#edit_city_id").empty(); 
        $("#edit_city_id").append('<option>Loading...</option>');
        var stateID= $('#edit_state_id').val();
        if(stateID!=''){
                   $.ajax({
                        type: "POST",
                        url: "/get-city",
                        data: {stateID:stateID},
                        //dataType: "json",
                        success: function (response) {
                            //console.log(response);
                             var obj = jQuery.parseJSON(response);
                             $("#edit_city_id").empty(); 
                            var tblRow='';
                            $.each( obj, function( i, obj ) { 
                                if(cityId==obj.id){
                                    tblRow += '<option value="'+obj.id+'" selected>'+obj.name+'</option> ';
                                } else{
                                    tblRow += '<option value="'+obj.id+'">'+obj.name+'</option> ';
                                }
                            });
                            $("#edit_city_id").append(tblRow);
                        }
                    });
               }
    }
    
    $('#edit_state_id').on('change', loadCity(0)).change();  
    
    
    
});            
</script>
