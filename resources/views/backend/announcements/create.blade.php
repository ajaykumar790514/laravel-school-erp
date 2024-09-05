<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create New Announcements</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form-add"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group">
                                <strong>Urls</strong>
                                <input type="text" tabindex="1" class="form-control"  name='urls' id='urls'>
                            </div>
                        </div>
                        
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
								<label>Description<span class="text-danger">*</span></label>
								<textarea rows="5" cols="5" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ old('description')}}</textarea>
							</div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label>Status <span class="text-danger">*</span></label>
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
                    <button type="submit" id='SaveButton' class="btn btn-success add_button">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
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
      
});            
</script>                
        
            
            