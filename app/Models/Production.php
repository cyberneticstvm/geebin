<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
