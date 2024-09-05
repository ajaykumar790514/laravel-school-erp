<?php

namespace App\Interfaces;

interface ProductCategoryRepositoryInterface 
{
    public function getDataTable();
    public function getAll();
    public function getById($id);
    public function deleteById($id);
    public function create(array $data);
    public function update($id, array $newDetails);
    
}