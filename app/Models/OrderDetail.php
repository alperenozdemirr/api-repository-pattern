<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order(): HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

}
