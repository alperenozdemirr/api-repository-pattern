<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function city(){
        return $this->hasOne(City::class,'code','city_code');
    }
}
