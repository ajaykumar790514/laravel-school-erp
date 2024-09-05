<!-- Primary modal -->
<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Menu Details</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="edit_form"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }}">
                                <label>Select Parent Menu</label>
                                 <?php $flag='-';?>
                                <select name="parent_id" id="parent_id_edit" class="form-control select" tabindex="1">
                                    <option value='0'>--Select--</option>
                                    @foreach ($parentMenu as $parentMenuDetails)
                                    <option value="{{$parentMenuDetails->id}}" {{ old('parent_id')==$parentMenuDetails->id?"selected":""}}>{{ $parentMenuDetails->name }}</option>
                                    @foreach ($parentMenuDetails->children as $childCategory)
                                                @include('menu.child_menu', ['child_category' => $childCategory])
                                            @endforeach
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group {{ $errors->has('link_type') ? ' has-error' : '' }}">
                                <label>Select Link Type<span class="text-danger">*</span></label>
                                <select id="link_type_edit"  class="form-control" name="link_type" tabindex="2">
                                    <option value='0' {{ old('link_type')==0?"selected":""}}>Internal</option>   
                                    <option value='1' {{old('link_type')==1?"selected":""}}>External</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" name='name', id='name_edit' tabindex="3">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div  class="form-group{{ $errors->has('url_link_internal1') ? ' has-error' : '' }}" id="url_link_internal1_edit">
                                <label>Url Internal (Menu Link) <span class="text-danger">*</span></label>
                                <select name="url_link_internal" id="url_link_internal_edit" class="form-control select">
                                    <option value=''>--Select--</option>
                                    @foreach ($pages as $pagesDetails)
                                    <option value="{{$pagesDetails->slug}}" {{ old('url_link_internal')==$pagesDetails->id?"selected":""}}>{{ $pagesDetails->page_title }}</option>
                                    @endforeach
                                    
                                </select>
                                
                            </div>
                            
                            <div  class="form-group{{ $errors->has('url_link_external1') ? ' has-error' : '' }}" id='url_link_external1_edit'>
                                <label>Url (External) <span class="text-danger">*</span></label>
                                <input class="form-control" name='url_link_external', id='url_link_external_edit' value="{{ old('url_link_external')  }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('target_window') ? ' has-error' : '' }}">
                                <label>Open Menu </label>
                                <select id="target_window_edit"  class="form-control" name="target_window" >
                                    <option value=''>--Select--</option>
                                    <option value='_self' {{ old('target_window')==0?"selected":""}}>Self</option>   
                                    <option value='_blank' {{old('target_window')==1?"selected":""}}>New</option>
                                </select>
                            </div>
                        </div>  
                         <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('order_by') ? ' has-error' : '' }}">
                                <label>Orderby </label>
                                <input class="form-control" name='order_by', id='order_by_edit'>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label>Status <span class="text-danger">*</span></label>
                                <select id="status_edit"  class="form-control" name="status" >
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
                    <button type="submit" id='editButton' class="btn btn-success edit_button">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>