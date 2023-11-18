<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($category) {
            $category->deleteChildrenRecursively($category);
        });
    }

    protected function deleteChildrenRecursively($category)
    {
        $children = $category->children;

        foreach ($children as $child) {
            $this->deleteChildrenRecursively($child);
            $child->delete();
        }
    }

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
