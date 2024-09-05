<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parents extends Model
{
    protected $guarded = [];
    
    static function getParentName($studentId){
    	 $data=Parents::where('students_id', '=', $studentId)->first();
    	 return $data['father_name'];
    }

    static function getParentWhatsappMobile($studentId){
    	 $data=Parents::where('students_id', '=', $studentId)->first();
    	 return $data['mobile_whatsapp'];
    }

    static function getStudentsByParentMobile($parentMobile){
    	 $data=Parents::where('mobile_whatsapp', '=', $parentMobile)->get();
    	 return $data;
    }

    static function getParentDetailsById($userID){
        
        $data= DB::table('users')->where(['users.user_id'=>$userID])
                ->join('parents', 'users.user_id', '=', 'parents.id')
                ->select('users.id','users.email', 'parents.father_name', 
                    'parents.father_qualification', 'parents.mothers_name' , 'parents.mother_occup' , 
                     'parents.city', 'parents.address' , 'parents.mobile_whatsapp')
                ->get();
            return $data;
    }

    static function getMobilebyId($id){
         $data=Parents::where('id', '=', $id)->first();
         return $data['mobile_whatsapp'];
        
    }
}
