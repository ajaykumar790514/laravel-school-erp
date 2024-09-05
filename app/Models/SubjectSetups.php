<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SubjectSetups extends Model
{
 
  static function getSubSubject($parent_id, $sub_mark='', $selectedId){
    	 $datas=SubjectSetups::where('parent_id', '=', $parent_id)->get();
    	 if(count($datas)>0){
    	 	foreach ($datas as $key => $data) {
    	 		$select=$selectedId==$data->id?'selected':'';
    	 		echo "<option value='$data->id'   $select >".$sub_mark.$data->subject_initial."</option>";
    	 	SubjectSetups::getSubSubject($data->id, $sub_mark.'--', $selectedId);
    	 	}
    	 	
    	 }
    }
    static function getParent($parent_id){
    	 $datas=SubjectSetups::where('id', '=', $parent_id)->first();
    	 if(!empty($datas)){
    	 	return $datas->subject_initial;
    	 } else {
    	 	return '';
    	 }
    	 
    }
   
}
