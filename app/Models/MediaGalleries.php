<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGalleries extends Model
{
    use HasFactory;
    protected function getAllMediaGalleries($status){
        $dataArray=MediaGalleries::where('status',$status)->get();  
        return $dataArray;
    }
    
    
     public function category()
    {
        return $this->hasOne(MediaCategories::class,'media_categories_id', 'id');
    }
    
    
   
}
