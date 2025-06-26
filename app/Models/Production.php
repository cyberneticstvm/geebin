<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['production_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }
    public function bstatus()
    {
        return $this->belongsTo(Extra::class, 'status', 'id');
    }

    public function batchNumber()
    {
        return $this->entity->code . '/' . $this->id;
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by', 'id');
    }

    public function details()
    {
        return $this->hasMany(ProductionDetail::class, 'production_id', 'id');
    }
}
