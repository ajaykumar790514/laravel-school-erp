<!-- Primary modal -->
<div id="show_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg  ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'>User Details</h6>
            </div>
            
            <form class="" method="POST" action="javascript:void(0)" id="CompanyForm"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Username/Email <span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_username'>Purple</span></div>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Role<span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_role'></span></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_name'></span></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Qualification<span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_qualification'></span></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Mobile<span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_mobile'></span></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Address<span class="text-danger">*</span></strong>
                                <div><span class="label label-info" id='show_address'></span></div>
                            </div>
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