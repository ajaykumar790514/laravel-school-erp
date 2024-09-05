<?php

namespace App\Interfaces;

interface ProductRepositoryInterface 
{
   
    public function create(array $data);
    
    public function update($id, array $data);
    
    public function variantProductCreate(array $data);
    
    public function uploadThumbnail(array $data);
    
    public function uploadImages(array $data);
    
    public function tags(array $data);
    
    public function productseo(array $data);
    
    
}