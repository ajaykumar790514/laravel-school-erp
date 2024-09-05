<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentClassAllotments extends Model
{
    
      
    
    
  static function getClassSection($studentId,$session){
    	$data= StudentClassAllotments::where(['student_class_allotments.session_id'=>$session, 'student_class_allotments.student_id'=>$studentId])
    		->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->select('student_class_allotments.student_id', 'class_setups.class_name', 'section_setups.section_name')->first();
            return $data;
    }
    static function getAllotmentStudent($studentId,$session, $classSessionMaping){
        $data= StudentClassAllotments::where(['student_class_allotments.session_id'=>$session, 'student_class_allotments.student_id'=>$studentId, 'student_class_allotments.class_maping_id'=>$classSessionMaping ])
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->select('student_class_allotments.student_id', 'class_setups.class_name', 'section_setups.section_name')->first();
            return $data;
    }

    

    static function getDuplicateRoll($id, $sessionId,$classmapingId, $rollnumber, $StudentId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId, 'roll_no'=>$rollnumber])
        //->where('student_id', '!=', $StudentId)
        ->where('id', '!=', $id)
        ->count();

        
    }
    static function getRollNoBySessionIDClassMapingIdStdId($sessionId,$classmapingId, $StudentId){
       $dataArray=StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId, 'student_id'=>$StudentId])->first();
       return $dataArray->roll_no;

        
    }

    static function getallPromotionStudent($sessionId, $classmapingId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId])
        ->count();
    }

    static function getallPromotionStudentByDirect($sessionId, $classmapingId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId, 'action_type'=>0])
        ->count();
    }

    static function getallPromotionStudentByPermotion($sessionId, $classmapingId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'classsetup_id'=>$classmapingId, 'action_type'=>1])
        ->count();
    }
    
    static function getCountPromotionStudent($sessionId, $classmapingId, $sectionID){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'classsetup_id'=>$classmapingId, 'sectionsetup_id'=>$sectionID, 'action_type'=>1])
        ->count();
    }

    static function getallattendeanceStudent($sessionId, $classmapingId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'classsetup_id'=>$classmapingId])
        ->where('performeance_status', '!=', 2)
        ->where('roll_no', '!=', NULL)
        ->count();
    }

    static function getAllAllotedRollNumber($sessionId, $classmapingId){
        return StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId])
        ->where('roll_no', '!=', NULL)
        ->count();
    }

    static function getRollnumber($id){
        return StudentClassAllotments::where(['id'=>$id])->first();
    }



    /* Student Reporting */
    static function getTotalStudentBySessionId($session){
        $data= StudentClassAllotments::where(['student_class_allotments.session_id'=>$session])
            ->count();
            return $data;
    }

    static function getClassSectionBySessionId($session){
        $data= StudentClassAllotments::where(['student_class_allotments.session_id'=>$session])
            ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
            ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
           ->select('class_setups.class_name', 'student_class_allotments.classsetup_id', 'section_setups.section_name', 'section_setups.id as sectionId',  'student_class_allotments.sectionsetup_id')
           ->groupBy('class_setups.class_name', 'student_class_allotments.classsetup_id', 'section_setups.section_name', 'section_setups.id',  'student_class_allotments.sectionsetup_id')
           ->orderBy('class_setups.order_by', 'asc')
           ->get();
            return $data;
    }


    static function getTotalStudentBySessionIdClassMapingID($session, $classId, $sectionID){
        $data= StudentClassAllotments::where(['student_class_allotments.session_id'=>$session, 
        'student_class_allotments.classsetup_id'=>$classId, 
        'student_class_allotments.sectionsetup_id'=>$sectionID])
            ->count();
            return $data;
    }

    static function getCurrentSessionByStudent($student){
        $data= StudentClassAllotments::where(['student_class_allotments.student_id'=>$student])
                ->select('student_class_allotments.session_id', 'session_setups.session_name', 'class_setups.class_name','student_class_allotments.class_maping_id', 'section_setups.section_name')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
                ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                ->orderBy('student_class_allotments.id', 'desc')->first();
                
            return $data;
    }

}
