<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelLogObserver
{
    protected $user = null;

    public function __construct()
    {
        $user = Auth::user();
        if ($user) {
            $this->user = $user;
        }
    }

    /**
     * @param Model $model
     * @return false|string
     */
    protected function getModelName(Model $model)
    {
        $modelName = get_class($model);
        $explodedClassName = explode('\\', $modelName);
        $shortClassName = end($explodedClassName);

        return $shortClassName;
    }

    /**
     * @param Model $model
     * @param string $message
     * @return void
     */
    protected function logActivity(Model $model, string $message)
    {
        activity()
            ->performedOn($model)
            ->causedBy(Auth::user())
            //->withProperties(['action' => $this->getModelName($model)])
            ->inLog($this->getModelName($model))
            ->log($message);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->logActivity($model,'created');
    }

    /**
     * @param Model $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->logActivity($model,'updated');
    }

    /**
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->logActivity($model,'deleted');
    }
}
