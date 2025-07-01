<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function itype()
    {
        return $this->belongsTo(Extra::class, 'type', 'id');
    }

    public function iunit()
    {
        return $this->belongsTo(Extra::class, 'unit', 'id');
    }
}
