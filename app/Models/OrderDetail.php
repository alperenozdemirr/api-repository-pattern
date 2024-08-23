<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
