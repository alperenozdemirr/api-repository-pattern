<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Base
{
    use HasFactory;

    protected $guarded = [];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class,'id','address_id');
    }

    public function invoice_address(): HasOne
    {
        return $this->hasOne(Address::class,'id','invoice_address_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

}
