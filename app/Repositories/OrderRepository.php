<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;


class OrderRepository implements OrderRepositoryInterface 
{
    public function getAllOrders() 
    {
        return "testing";
    }

    public function getOrderById($orderId) 
    {
        return Order::findOrFail($orderId);
    }

    public function deleteOrder($orderId) 
    {
        Order::destroy($orderId);
    }

    public function createOrder(array $orderDetails) 
    {
        return Order::create($orderDetails);
    }

    public function updateOrder($orderId, array $newDetails) 
    {
        return Order::whereId($orderId)->update($newDetails);
    }

    public function getFulfilledOrders() 
    {
        return Order::where('is_fulfilled', true);
    }
}