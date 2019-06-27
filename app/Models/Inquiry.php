<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    public function details()
    {
        return $this->hasMany('App\Models\InquiryDetail')
            ->orderBy('id', 'desc');
    }
}
