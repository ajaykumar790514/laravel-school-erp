<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    static function getStudentName($id){
    	 $data=Students::where('id', '=', $id)->first();
    	 return $data->student_name;
    }
    
    public function parents(){
        return $this->hasOne(\App\Models\Parents::class,'id', 'parent_id');
    }
    
    public function sessionsetup(){
        return $this->hasOne(\App\Models\SessionSetups::class,'id', 'session_id');
    }
    
    public function classsetup(){
        return $this->hasOne(\App\Models\ClassSetups::class,'id', 'class_id');
    }
    
    public function religions(){
        return $this->hasOne(\App\Models\Religions::class,'id', 'religions_id');
    }
    
    public function castcategory(){
        return $this->hasOne(\App\Models\CastCategorySetups::class,'id', 'cast_category_setups_id');
    }
    
   
}
