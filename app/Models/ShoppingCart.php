<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
