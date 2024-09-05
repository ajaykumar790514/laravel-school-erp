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
<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create New Testimonals</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form-add"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="1" class="form-control"  name='name' id='name'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    	<input type="file" 
                                        class="filepond"
                                        id='images'
                                        name="images" 
                                        multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        accept="image/png, image/jpeg, image/gif"/
                                        data-max-files="1">
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('descraption') ? ' has-error' : '' }}">
								<label>Description<span class="text-danger">*</span></label>
								<textarea rows="5" cols="5" class="form-control" id='descraption' name='descraption' placeholder="Enter your description here">{{ old('descraption')}}</textarea>
							</div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
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
<!-- /primary modal -->
 <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="{{asset('admin/ckeditor/ckeditor/ckeditor.js')}}"> </script>
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
      FilePond.registerPlugin(FilePondPluginImagePreview);
                // const bannerElement = document.querySelector('input[id="images"]');
                // FilePond.create(bannerElement, {
                // server:{
                //     url: '/testimonalAvtar',
                //     headers: {
                //           'X-CSRF-TOKEN': '{{ csrf_token() }}'
                //           }
                // }
                // })  
                
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
        
            
            