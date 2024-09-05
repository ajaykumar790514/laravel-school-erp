<?php

namespace App\Interfaces;

interface ProductAttributesInterface 
{
    public function getDataTable();
    public function getAll();
    public function getById($orderId);
    public function deleteById($orderId);
    public function create(array $data);
    public function update($orderId, array $newDetails);
    
}