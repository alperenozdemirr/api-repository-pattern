<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelLogObserver
{
    public function created(Model $model)
    {
        activity()->log( get_class($model).": test created");
    }

    public function updated(Model $model)
    {
        activity()->log(get_class($model).": test updated");
    }

    public function deleted(Model $model)
    {
        activity()->log(get_class($model).": test deleted");
    }
}
