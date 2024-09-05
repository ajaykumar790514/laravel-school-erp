<!-- Primary modal -->
<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create New Role</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="CompanyForm-add"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Username/Email <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="1" class="form-control"  name='email' id='email'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Role<span class="text-danger">*</span></strong>
                                <select tabindex="2" class='form-control select' name="roles_id" id="roles_id">
                                    <option value="">-Select Role-</option>
                                    @foreach($roles as $roleDetails)
                                        <option value="{{$roleDetails->id}}">{{$roleDetails->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Password <span class="text-danger">*</span></strong>
                                <input type="password" tabindex="3" class="form-control"  name='password' id='password'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Confirm Password<span class="text-danger">*</span></strong>
                                <input type="password" tabindex="4" class="form-control"  name='confirmpassword' id='confirmpassword'>
                            </div>
                        </div>
                    </div>
                    <p class="h3">Personal Details</p>
                    <hr>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Name <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="5" class="form-control"  name='name' id='name'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Qualification </strong>
                                <input type="text" tabindex="6" class="form-control"  name='qualification' id='qualification'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Mobile <span class="text-danger">*</span></strong>
                                <input type="text" tabindex="7" class="form-control" maxlength='10'  name='mobile' id='mobile'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                        <div class="form-group">
                                <strong>Address </strong>
                                <input type="text" tabindex="8" class="form-control"  name='address' id='address'>
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