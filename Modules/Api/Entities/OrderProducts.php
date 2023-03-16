<?php

namespace Modules\Api\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    protected $fillable = ['product_id','order_id'];
}
