<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formula extends Model
{
    public function product()
    {
        return $this->belongsTo(Material::class, 'bin_id', 'id');
    }

    public function parts()
    {
        return $this->belongsTo(Material::class, 'part_id', 'id');
    }
}
