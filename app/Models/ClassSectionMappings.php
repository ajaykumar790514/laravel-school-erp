<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ClassSectionMappings extends Model
{
   static function getClassName($id){
    	$data=DB::table('class_section_mappings')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('class_setups.class_name')
            ->first();
            return $data->class_name;
    }
    static function getSectionName($id){
    	$data=DB::table('class_section_mappings')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->select('section_setups.section_name')
            ->first();
            return $data->section_name;
    }

    static function getClassSetupById($id){
        $data=DB::table('class_section_mappings')
            ->where(['id'=>$id])
            ->select('class_setups_id')
            ->first();
            return $data->class_setups_id;
    }
    
    static function getSectionIdByMapingId($id){
        $data=DB::table('class_section_mappings')
            ->where(['id'=>$id])
            ->select('section_setup_id')
            ->first();
            return $data->section_setup_id;
    }

    static function getClassNameByClassMapingID($id){
        $data=DB::table('class_section_mappings')
            ->where(['class_section_mappings.id'=>$id])
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->select('class_setups.class_name', 'section_setups.section_name')
            ->first();
            return $data->class_name.'-->'.$data->section_name;
    }
}
