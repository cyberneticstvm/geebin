<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['transfer_date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function fentity()
    {
        return $this->belongsTo(Entity::class, 'from_entity', 'id');
    }

    public function tentity()
    {
        return $this->belongsTo(Entity::class, 'to_entity', 'id');
    }

    public function details()
    {
        return $this->hasMany(TransferDetail::class, 'transfer_id', 'id');
    }
}
