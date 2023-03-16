<?php

namespace Modules\Api\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Api\Repositories\ApiRepositoryInterface as ApiRepo;

class ApiController extends Controller
{
     public function __construct(ApiRepo $ApiRepo){
        $this->ApiRepo =  $ApiRepo;
    }

    public function getOrders(Request $request){
        $response = $this->ApiRepo->getOrders($request);
        return $response;
    }

    public function addOrder(Request $request){
        $response = $this->ApiRepo->addOrder($request);
        return $response;
    } 

    public function updateOrder($orderid,Request $request){
        $response = $this->ApiRepo->updateOrder($orderid,$request);
        return $response;
    }

    public function deleteOrder($orderid,Request $request){
        $response = $this->ApiRepo->deleteOrder($orderid,$request);
        return $response;
    }

    public function addProductToOrder($orderid,Request $request){
        $response = $this->ApiRepo->addProductToOrder($orderid,$request);
        return $response;
    }

    public function createPayOrder($orderid,Request $request){
        $response = $this->ApiRepo->createPayOrder($orderid,$request);
        return $response;
    }
}
