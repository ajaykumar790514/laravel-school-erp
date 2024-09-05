<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubjectClassMappings extends Model
{
    static function getSubjectName($id){
    	$data=DB::table('subject_class_mappings')
           ->where(['subject_class_mappings.id'=>$id])
           ->join('subject_setups', 'subject_class_mappings.subject_setups_id', '=', 'subject_setups.id')
            ->select('subject_setups.subject_name')
            ->first();
            return $data->subject_name;
    }
}
