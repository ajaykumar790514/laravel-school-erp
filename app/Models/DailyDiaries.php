<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyDiaries extends Model
{
    static function getDetails($id){
       $data=DailyDiaries::where(['id'=>$id])->first();
        return $data;

    }
}
