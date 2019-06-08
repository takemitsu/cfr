<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Project extends Model
{
    protected static function boot()
    {
        parent::boot();
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
}
