<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelledDeparture extends Model
{
    public $guarded = [];
    public $timestamps = false;

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
