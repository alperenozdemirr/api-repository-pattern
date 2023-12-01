<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function city(): HasOne
    {
        return $this->hasOne(City::class,'code','city_code');
    }
}
