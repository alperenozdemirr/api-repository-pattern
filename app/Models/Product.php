<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
}
