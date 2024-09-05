<?php $rollNumber=App\Models\StudentClassAllotments::getRollnumber(base64_decode($id));
if($rollNumber->roll_no==""){
?>
 <a href='{{url("unalloted/{$id}")}}' onclick="return confirm('Are you sure?');" class='btn btn-danger '><i class=' icon-cancel-circle2'></i> Delete</a>
<?php } else {?>
	Roll Number Alloted
<?php } ?>

