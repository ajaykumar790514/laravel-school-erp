<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSetups extends Model
{
    static function getClassStrength($id){
       $data=ClassSetups::where(['id'=>$id])->first();
        return $data['class_strength'];

    }

    static function getClassName($id){
       $data=ClassSetups::where(['id'=>$id])->first();
        return $data['class_name'];

    }

}
