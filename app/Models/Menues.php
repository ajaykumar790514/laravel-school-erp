<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menues extends Model
{
    use HasFactory;
    
    public function parents()
    {
        return $this->hasMany(Menues::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(Menues::class, 'parent_id')->with('parents');
    }
    
    static function getRootName($id)
    {
        $data=Menues::select('name')->where(['id' =>$id])->first();
        return $data->name;
    }
    
    
}
