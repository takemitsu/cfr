<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryDetail extends Model
{
    public function inquiry()
    {
        return $this->belongsTo('App\Models\Inquiry');
    }
}
