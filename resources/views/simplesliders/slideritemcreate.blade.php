<!-- Primary modal -->
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'>Add Slider Item</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form-add"  enctype="multipart/form-data">
                <input name='id' type="hidden" style="width:60%" value='{{$data->id}}'>
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="1" class="form-control"  name='title' id='title'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <input type="file" 
                                        class="filepond"
                                        id='image'
                                        name="image" 
                                        multiple 
                                        allowImagePreview='true'
                                        data-allow-reorder="true"
                                        data-max-file-size="3MB"
                                        data-max-files="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
								<label>Description<span class="text-danger">*</span></label>
								<textarea rows="5" cols="5" tabindex="2" class="form-control" id='description' name='description' placeholder="Enter your description here">{{ old('descraption')}}</textarea>
							</div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                                <label>Orderby <span class="text-danger">*</span></label>
                                 <input type="text"  tabindex="3" class="form-control"  name='order' id='order'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label>Status <span class="text-danger">*</span></label>
                                <select id="status"  tabindex="4" class="form-control" name="status" >
                                    <option value=''>--Select--</option>
                                    <option value='0' {{ old('status')==0?"selected":""}}>Published</option>   
                                    <option value='1' {{old('status')==1?"selected":""}}>Un Published</option>
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
 <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script>
$(document).ready(function() {
    //for banner
        FilePond.registerPlugin(FilePondPluginImagePreview);
        const bannerElement = document.querySelector('input[id="image"]');
        FilePond.create(bannerElement, {
        server:{
            url: '/sliderImage',
            headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  }
        }
        });    
});            
   </script>                
        
            
            