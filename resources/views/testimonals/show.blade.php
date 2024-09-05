<!-- Primary modal -->
<div id="show_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg  ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'>Testimonals Details</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-12 text-center">
                            	<span id='displayImgShow'></span>
                            	<div name='name' id='show_name' class='text-bold'></div>
                                <div id='show_descraption' name='descraption' ></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                   
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->