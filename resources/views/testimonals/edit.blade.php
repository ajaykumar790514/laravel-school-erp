<!-- Primary modal -->
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
<style>
    .filepond--root,
.filepond--root .filepond--drop-label {
  height: 100px;
  width:100px;
}
</style>
<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Testimonals Details</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name<span class="text-danger">*</span></strong>
                                <input type="text" tabindex="1" class="form-control"  name='name' id='edit_name'>
                            </div>
                        </div>
                         <div class='row'>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <div class='rov'>
                                        <div class="col-md-6 col-6">                                   
                                        <input type="file" 
                                        class="filepond"
                                        id='images'
                                        name="images" 
                                         multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        accept="image/png, image/jpeg, image/gif"/
                                        data-max-files="1"></div>
                                         <div class="col-md-6 col-6"><span id='displayImgEdit'></span></div>
                                    </div>

                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('descraption') ? ' has-error' : '' }}">
								<label>Description<span class="text-danger">*</span></label>
								<textarea rows="5" cols="5" class="form-control" id='edit_descraption' name='descraption' placeholder="Enter your description here">{{ old('descraption')}}</textarea>
							</div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
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
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script>
$(document).ready(function() {
                FilePond.registerPlugin(FilePondPluginImagePreview);
                 FilePond.create(document.querySelector('input[id="images"]'),
                  {
                    labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,
                    
                    stylePanelLayout: 'compact circle',
                    styleLoadIndicatorPosition: 'center bottom',
                    styleProgressIndicatorPosition: 'right bottom',
                    styleButtonRemoveItemPosition: 'left bottom',
                    styleButtonProcessItemPosition: 'right bottom',
                    server:{
                        url: '/testimonalAvtar',
                        headers: {
                              'X-CSRF-TOKEN': '{{ csrf_token() }}'
                              }
                    }
                  });

            
});            
   </script>     