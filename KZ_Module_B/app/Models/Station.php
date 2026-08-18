<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public $timestamps = false;

    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
