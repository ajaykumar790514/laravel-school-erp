<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class SessionSetups extends Model
{
     protected $fillable = [

        'session_year', 'session_name'

    ];
    
    static function getSessionName($id){
    	 $data=SessionSetups::where('id', '=', $id)->first();
    	 return $data['session_name'];
    }
}
