<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    //Subcategories for each category
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    //Parent category of a category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
