<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    protected $guarded = [];
     protected function getAllCategory($status){
        $dataArray=ProductCategories::where('status',$status)->get();  
        return $dataArray;
    }
    
    
   
    public function childs()
    {
        return $this->hasMany(ProductCategories::class, 'parent_id', 'id');
    }

    static function getChild($parentId)
    {
        $statearray = ProductCategories::select('*')->where(['status' => 0, 'parent_id' => $parentId])->orderBy('order_by', 'asc')->get();
        return $statearray;
    }

    public function parents()
    {
        return $this->hasMany(ProductCategories::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategories::class, 'parent_id')->with('parents');
    }
    
    static function getParentName($parentId)
    {
        $statearray = ProductCategories::select('title')->where(['id' =>$parentId])->first();
         if($statearray){
             return $statearray->title;
         } else {
             return 'root';
         }
    }
    
    
}
