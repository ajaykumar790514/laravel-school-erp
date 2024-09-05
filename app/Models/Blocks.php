<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blocks extends Model
{
     static function getRecentBlog(){
    	 $data=Blocks::where('status', '=', 0)->first();
    	 return $data;
    }
    
    static function getBlockValue($name){
    	 $data=Blocks::where('name', '=', $name)->first();
    	 return $data['content'];
    }
}
