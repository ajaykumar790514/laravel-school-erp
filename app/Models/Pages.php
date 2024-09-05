<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;
    
     protected function getAllPages($status){
        $dataArray=Pages::where('status',$status)->get();  
        return $dataArray;
    }
}
