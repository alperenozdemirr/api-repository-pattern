<?php

namespace App\Models;

use App\Observers\ModelLogObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::observe(ModelLogObserver::class);
    }
}
