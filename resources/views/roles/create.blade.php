<!-- Primary modal -->
<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create New Role</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="CompanyForm"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" class="name form-control"  name='name' id='name'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>Permission:</strong>
                            <div class="row">
                                @foreach($permissionHeading as $Headingvalue)
                                <div class="col-md-3">
                                    <h4>{{ $Headingvalue->parent_id }}</h4>
                                    <div class="form-group">
                                        <?php
                                                     $permission1=App\Models\User::getPermission($Headingvalue->parent_id);
                                                     ?>
                                        @foreach($permission1 as $value)
                                        <label><input type="checkbox" class='addRoles'  name="permission[]" value="{{$value->id}}">
                                             {{ $value->name }}</label>
                                        <br />
                                        @endforeach
                                    </div>

                                </div>

                                @endforeach
                            </div>


                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" id='SaveButton' class="btn btn-success add_role">Save Roles</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->