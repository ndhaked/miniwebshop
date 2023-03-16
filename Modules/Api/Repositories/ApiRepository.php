<?php

namespace Modules\Api\Repositories;

use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;
use Modules\Api\Entities\Orders;
use Modules\Api\Entities\OrderProducts;

class ApiRepository implements ApiRepositoryInterface {

    function __construct(Orders $Orders,OrderProducts $OrderProducts) {
       $this->Orders = $Orders;
       $this->OrderProducts = $OrderProducts;
    }

    public function getOrders($request)
    {
        $orders     = $this->Orders->latest()->paginate();
        $response   = $this->paginationFormat($orders);
        $response['status_code'] = 200;
        $response['message'] = 'There is no record found.';
        $response['data'] = array(); 
        if(count($orders) > 0){
            $response['message'] = 'Orders Data';
            foreach ($orders as $key => $order) {
                $response['data'][$key] = $order;
            }
        } 
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    }

    public function addOrder($request)
    {
        $validator = Validator::make($request->all(), [
             'customer_id' =>  'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json($this->requestErrorApiResponse($validator->errors()->getMessages()), 422);
        }
        $response['status_code'] = 200;
        $response['message'] = 'Order not created';
        if($this->Orders->create($request->all())){
            $response['message'] = 'Order Created successfully';
        }
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    }

    public function updateOrder($orderid,$request)
    {
        $request['order_id'] = $orderid;
        $validator = Validator::make($request->all(), [
             'order_id' =>  'required|exists:orders,id',
             'customer_id' =>  'required|exists:customers,id',
        ]);
        if ($validator->fails()) {
            return response()->json($this->requestErrorApiResponse($validator->errors()->getMessages()), 422);
        }
        $response['status_code'] = 200;
        $response['message'] = 'Order not updated';
        $order = $this->Orders->find($orderid);
        if($order->update($request->all())){
            $response['message'] = 'Order Updated successfully';
        }
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    } 

    public function deleteOrder($orderid,$request)
    {
        $request['order_id'] = $orderid;
        $validator = Validator::make($request->all(), [
             'order_id' =>  'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($this->requestErrorApiResponse($validator->errors()->getMessages()), 422);
        }
        $response['status_code'] = 200;
        $response['message'] = 'Order not deleted';
        if($this->Orders->find($orderid)->delete()){
            $response['message'] = 'Order Deleted successfully';
        }
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    }
     
    public function addProductToOrder($orderid,$request)
    {
        $request['order_id'] = $orderid;
        $validator = Validator::make($request->all(), [
             'product_id' =>  'required|exists:products,id',
             'order_id'   =>  'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json($this->requestErrorApiResponse($validator->errors()->getMessages()), 422);
        }
        $order = $this->Orders->where('id',$orderid)->first();
        if($order->payed == 'pending'){
            $order->ordreProducts()->create($request->all());
            $response['status_code'] = 200;
            $response['message'] = 'Orders atteched successfully';
        }else{
            $response['status_code'] = 400;
            $response['message'] = 'Sorry!! Orders already payed completed';
        }
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    }    

    public function createPayOrder($orderid,$request)
    {
        $request['id'] = $orderid;
        $validator = Validator::make($request->all(), [
             'id'   =>  'required|exists:orders,id',
             'order_id'   =>  'required|exists:orders,id',
             'customer_email' => "required|email|regex:/(.+)@(.+)\.(.+)/i",
             'value' => "required|regex:/^\d+(\.\d{1,2})?$/",
        ]);
        if ($validator->fails()) {
            return response()->json($this->requestErrorApiResponse($validator->errors()->getMessages()), 422);
        }
        $order = $this->Orders->where('id',$orderid)->first();
        if($order->payed == 'pending'){
                $apiURL = 'https://superpay.view.agentur-loop.com/pay';
                $postInput = $request->all();
                $apiresponse = Http::post($apiURL, $postInput);
                $statusCode = $apiresponse->status();
                $responseBody = json_decode($apiresponse->getBody(), true);
                $response['status_code'] = 200;
                $response['message'] = $responseBody['message'];
        }else{
            $response['status_code'] = 400;
            $response['message'] = 'Sorry!! Orders already payed completed';
        }
        return response()->json($response, $response['status_code'])->setStatusCode($response['status_code']);
    }

    private function paginationFormat($request)
    {
        $res['lastPage'] = $request->lastPage();
        $res['total'] = $request->total();
        $res['nextPageUrl'] = ($request->nextPageUrl()) ? $request->nextPageUrl() : "";
        $res['prevPageUrl'] = ($request->previousPageUrl()) ? $request->previousPageUrl() : "";
        $res['currentPage'] = $request->currentPage();
        return $res;
    }

    private function requestErrorApiResponse($request)
    {
        $erro['status_code'] = 422;
        foreach ($request as $error) {
            $erro['message'] = $error[0];
        }
        return $erro;
    }
}