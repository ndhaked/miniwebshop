<?php

namespace Modules\Api\Entities;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $fillable = ['customer_id','payed'];
    
    public function ordreProducts()
    {
        return $this->hasMany(OrderProducts::class, 'order_id');
    }
}
