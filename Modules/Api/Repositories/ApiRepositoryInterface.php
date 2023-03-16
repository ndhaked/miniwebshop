<?php

namespace Modules\Api\Repositories;


interface ApiRepositoryInterface
{
    public function getOrders($request);

    public function addProductToOrder($orderid,$request);
    
    public function createPayOrder($orderid,$request);
    
    public function addOrder($request); 

    public function updateOrder($orderid,$request);
    
    public function deleteOrder($orderid,$request);
}