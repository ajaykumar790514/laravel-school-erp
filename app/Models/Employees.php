<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [

        'employee_type', 'employee_category', 'designation_id',

    ];
    static function getEmployeeName($id){
    	 $data=Employees::where('id', '=', $id)->first();
    	 return $data['employee_name'];
    }

    static function getMobile($id){
    	 $data=Employees::where('id', '=', $id)->first();
    	 return $data['mobile_whatsapp'];
    }
}
