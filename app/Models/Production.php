<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['production_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : (($this->status == 7) ? "<span class='badge bg-success'>Open</span>" : "<span class='badge bg-warning'>Closed</span>");
    }
    public function bstatus()
    {
        return $this->belongsTo(Extra::class, 'status', 'id');
    }

    public function fromEntity()
    {
        return $this->belongsTo(Entity::class, 'from_entity', 'id');
    }

    public function toEntity()
    {
        return $this->belongsTo(Entity::class, 'to_entity', 'id');
    }

    public function batchNumber()
    {
        return $this->toEntity()->first()->code . '/' . Carbon::parse($this->production_date)->format('dmy') . '/' . $this->id;
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
