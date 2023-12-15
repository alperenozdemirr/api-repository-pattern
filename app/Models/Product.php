<?php

namespace App\Models;

use App\Observers\ModelLogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        //'original_price' => 'decimal:2',
        //'discount_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::observe(ModelLogObserver::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }
}
