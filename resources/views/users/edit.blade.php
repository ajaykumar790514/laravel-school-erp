<!-- Primary modal -->
<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit User Details</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="edit_CompanyForm"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Username/Email <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="1" class="form-control"  name='email' id='edit_email'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Role<span class="text-danger">*</span></strong>
                                <select tabindex="2" class='form-control select' name="roles_id" id="edit_roles_id">
                                    <option value="">-Select Role-</option>
                                    @foreach($roles as $roleDetails)
                                        <option value="{{$roleDetails->id}}">{{$roleDetails->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="h3">Personal Details</p>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="5" class="form-control"  name='name' id='edit_name'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Qualification </strong>
                                <input type="text" tabindex="6" class="form-control"  name='qualification' id='edit_qualification'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Mobile <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="7" class="form-control" maxlength='10'  name='mobile' id='edit_mobile'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                        <div class="form-group">
                                <strong>Address </strong>
                                <input type="text" tabindex="8" class="form-control"  name='address' id='edit_address'>
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