<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasCreator
{
    protected static function bootHasCreator()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                if (in_array('created_by', $model->getFillable()) && !$model->created_by) {
                    $model->created_by = Auth::id();
                }
                if (in_array('prepared_by', $model->getFillable()) && !$model->prepared_by) {
                    $model->prepared_by = Auth::id();
                }
            }
        });
    }
}
