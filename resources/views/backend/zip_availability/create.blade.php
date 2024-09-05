<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create New Zip Availability </h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form-add"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>State <span class="text-danger">*</span></strong>
                                <select class="form-control select" name='state_id' id='state_id'>
									@foreach (get_state() as $state)
                                        <option value="{{$state->id}}" {{ old('state_id')==$state->id?"selected":""}}>{{ $state->name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>City <span class="text-danger">*</span></strong>
                                <select class="form-control select" name='city_id' id='city_id'>
                                    <option value="">--Select--</option>
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Area </strong>
                                <input type="text" class="form-control" name="area" id="area"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Pincode/Zip Code <span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="pincode" id="pincode"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Available<span class="text-danger">*</span></strong>
                                <select id="available"  class="form-control" name="available" >
                                    <option value=''>--Select--</option>
                                    <option value='0' {{ old('status')==0?"selected":""}}>Yes</option>   
                                    <option value='1' {{old('status')==1?"selected":""}}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Days</strong>
                                <input type="text" class="form-control" name="deliver_with_days" id="deliver_with_days" maxlength='3'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Extra Charges</strong>
                                <input type="text" class="form-control" name="extra_charges" id="extra_charges" maxlength='5'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <strong>Status<span class="text-danger">*</span></strong>
                                <select id="status"  class="form-control" name="status" >
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
                    <button type="submit" id='SaveButton' class="btn btn-success add_button">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->
<script>
$(document).ready(function() {
    // This function for Open modal and save roles data
    $(document).on('click', '#openModal', function (e) {
            e.preventDefault();   
            // sucess massage display in this div
            $('#success_message').html("").hide();
            $('#save_msgList').html("").hide();
            $('#modal_theme_primary').modal({
                keyboard: false
            }) 
            // reset 
            $('#form-add')[0].reset();
    }); 
    
    $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#state_id').change(function() {
        $("#city_id").empty(); 
        $("#city_id").append('<option>Loading...</option>');
        var stateID= $('#state_id').val();
        if(stateID!=''){
                   $.ajax({
                        type: "POST",
                        url: "/get-city",
                        data: {stateID:stateID},
                        //dataType: "json",
                        success: function (response) {
                            //console.log(response);
                             var obj = jQuery.parseJSON(response);
                             $("#city_id").empty(); 
                            var tblRow='';
                            $.each( obj, function( i, obj ) { 
                              tblRow += '<option value="'+obj.id+'">'+obj.name+'</option> ';
                            });
                            $("#city_id").append(tblRow);
                        }
                    });
               }
    }).change();  
    
    
    
});            
</script>                
        
            
            