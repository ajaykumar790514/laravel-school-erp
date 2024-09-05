<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassTeacherSetups extends Model
{
    static function checkTeacherExist($sessionId, $classID, $sectionId, $teacherId){
    	 $data=ClassTeacherSetups::where(['session_id'=>$sessionId, 'class_id'=>$classID, "section_id"=>$sectionId, "teacher_id"=>$teacherId])->count();
    	 return $data;
    }
    
     static function getClassName($id){
    	 $data=DB::table('class_teacher_setups')
                            ->join('class_section_mappings', 'class_teacher_setups.class_id', '=', 'class_section_mappings.id')
                             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
                            ->select('class_setups.class_name')
                            ->where('class_teacher_setups.class_id', '=', $id)
                            ->first();
    	 return $data->class_name;
    }
    
    static function getSectionName($id){
    	 $data=DB::table('class_teacher_setups')
                            ->join('class_section_mappings', 'class_teacher_setups.section_id', '=', 'class_section_mappings.id')
                             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->select('section_setups.section_name')
                            ->where('class_teacher_setups.section_id', '=', $id)
                            ->first();
    	 return $data->section_name;
    }

    static function getTeacherSessionId($teacherId){
         $data=DB::table('class_teacher_setups')
                            ->select('class_teacher_setups.session_id')
                            ->where('class_teacher_setups.teacher_id', '=', $teacherId)
                            ->groupBy('class_teacher_setups.session_id')
                            ->get();
         return $data;
    }
}
