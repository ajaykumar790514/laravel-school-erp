<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionSetups extends Model
{
     static function getSectionName($id){
       $data=SectionSetups::where(['id'=>$id])->first();
        return $data->section_name;

    }
}
