<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Announcements Details</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group">
                                <strong>Urls</strong>
                                <input type="text" tabindex="1" class="form-control"  name='name' id='edit_urls'>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('descraption') ? ' has-error' : '' }}">
								<label>Description<span class="text-danger">*</span></label>
								<textarea rows="5" cols="5" class="form-control" id='edit_descraption' name='descraption' placeholder="Enter your description here">{{ old('descraption')}}</textarea>
							</div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label>Status <span class="text-danger">*</span></label>
                                <select id="edit_status"  class="form-control" name="status" >
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
                    <button type="submit" id='editButton' class="btn btn-success edit_button">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
    