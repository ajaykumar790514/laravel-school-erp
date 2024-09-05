<!-- Primary modal -->
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
                                    <!--<strong>Password <span class="text-danger">*</span></strong>--><br>
                                    <input id="ckfinder-input-1" name='image' type="hidden" style="width:60%">
                                    <button id="ckfinder-modal-1" class="button-a button-a-background">Select Aavatars</button>
                                    <span id='displayImg'></span>
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
            
    
    
    var button1 = document.getElementById( 'ckfinder-modal-1' );
    button1.onclick = function() {
        selectFileWithCKFinder( 'ckfinder-input-1', 'displayImg' );
    };
    function selectFileWithCKFinder( elementId, displayId ) {
            	CKFinder.modal( {
            		chooseFiles: true,
            		width: 800,
            		height: 600,
            		onInit: function( finder ) {
            			finder.on( 'files:choose', function( evt ) {
            				var file = evt.data.files.first();
            				var output = document.getElementById( elementId );
            				var outputdisplay = document.getElementById( displayId );
            				output.value = file.getUrl();
            			    $("<img />", {
                                 "src": file.getUrl(),
                                 "class": "thumb-image rounded float-start",
                                 "style":"width:25px"
                             }).appendTo(outputdisplay);
                 			
            			} );
            
            			finder.on( 'file:choose:resizedImage', function( evt ) {
            				var output = document.getElementById( elementId );
            				output.value = evt.data.resizedUrl;
            			} );
            		}
            	} );
            }
            
});            
   </script>                
        
            
            