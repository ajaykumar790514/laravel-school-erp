<div id="modal_theme_primary"  class="modal fade ">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title" id='headerHeading'> Create Fee Amount Setup </h6>
            </div>
            <form class="" method="POST" action="javascript:void(0)" id="form-add"  enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                <ul id="save_msgList"></ul>
                <div id="success_message"></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Select Session <span class="text-danger">*</span></strong>
                                <select class="form-control" name='session_setup_id' id='session_setup_id'>
                                    <option value=''>-Select-</option>
									@foreach (getSession() as $sessionDetails)
                                        <option value="{{$sessionDetails->id}}">{{ $sessionDetails->session_name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Select Class <span class="text-danger">*</span></strong>
                                <select class="form-control " name='class_setup_id' id='class_setup_id'>
                                     <option value=''>-Select-</option>
									@foreach (getClasses() as $classDetails)
                                        <option value="{{$classDetails->id}}">{{ $classDetails->class_name }}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                               <strong>Select Fee Head <span class="text-danger">*</span></strong>
                                <select class="form-control " name='fee_head_setup_id' id='fee_head_setup_id'>
                                    <option value=''>-Select-</option>
									@foreach (getFeeHead() as $feeHeads)
                                        <option value="{{$feeHeads->id}}">{{ $feeHeads->fee_head_name}}</option>
                                    @endforeach
								</select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Amount<span class="text-danger">*</span></strong>
                                <input type="text" class="form-control" name="fee_amount" id="fee_amount" maxlength='5'/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Order By</strong>
                                <input type="text" class="form-control" name="order_by" id="order_by"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-6">
                            <div class="form-group">
                                <strong>Status<span class="text-danger">*</span></strong>
                                <select id="status"  class="form-control form-add" name="status" >
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
                    <button type="submit" id='SaveButton' class="btn btn-success add_button">Save</button>
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
            $('#form-add')[0].reset();
            $("#form-add select").val("-1");
            // sucess massage display in this div
            $('#success_message').html("").hide();
            $('#save_msgList').html("").hide();
            $('#modal_theme_primary').modal({
                keyboard: false
            }) 
           
    }); 
});            
</script>                
        
            
            