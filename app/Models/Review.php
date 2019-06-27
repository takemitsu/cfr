<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Review extends Model
{
    protected static function boot()
    {
        parent::boot();
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
}
