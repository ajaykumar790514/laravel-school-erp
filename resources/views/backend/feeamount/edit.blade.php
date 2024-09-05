<div id="edit_modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Edit Fee Amount Setup</h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form_edit"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="edit_save_msgList"></ul>
                <div id="edit_success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Select Session <span class="text-danger">*</span></strong>
                                <select class="form-control" name='edit_session_setup_id' id='edit_session_setup_id'>
									@foreach (getSession() as $sessionDetails)
                                        <option value="{{$sessionDetails->id}}">{{ $sessionDetails->session_name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Select Class <span class="text-danger">*</span></strong>
                                <select class="form-control" name='edit_class_setup_id' id='edit_class_setup_id'>
									@foreach (getClasses() as $classDetails)
                                        <option value="{{$classDetails->id}}">{{ $classDetails->class_name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                               <strong>Select Fee Head <span class="text-danger">*</span></strong>
                                <select class="form-control" name='edit_fee_head_setup_id' id='edit_fee_head_setup_id'>
									@foreach (getFeeHead() as $feeHeads)
                                        <option value="{{$feeHeads->id}}">{{ $feeHeads->fee_head_name}}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Amount<span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="edit_fee_amount" id="edit_fee_amount" maxlength='5'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Order By</strong>
                                <input type="text" class="form-control" name="edit_order_by" id="edit_order_by"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Status<span class="text-danger">*</span></strong>
                                <select id="edit_status"  class="form-control" name="edit_status" >
                                    <option value=''>--Select--</option>
                                    <option value='0'>Active</option>   
                                    <option value='1'>Inactive</option>
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
<script>
$(document).ready(function() {
    $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    // This function for Open modal and fill update data in modal               
    $(document).on('click', '.openEditModal', function (e) {
        e.preventDefault();   
        $('#edit_modal_theme_primary').modal({
            keyboard: false
        })  
        $('#form_edit')[0].reset();
        var id= $(this).attr("href"); 
        $.get('fee-amount-setup-loaddata/' + id , function (data) {
           $('#edit_session_setup_id').val(data.data.session_setup_id); 
           $('#edit_class_setup_id').val(data.data.class_setup_id); 
           $('#edit_fee_head_setup_id').val(data.data.fee_head_setup_id); 
           $('#edit_fee_amount').val(data.data.fee_amount); 
           $('#edit_order_by').val(data.data.order_by); 
           $('#edit_status').val(data.data.status);
           $('#edit_save_msgList').html("<input type='hidden' id='hiddenId' name='id' value='"+data.data.id+"'>");    
        })
    }); 

});            
</script>
