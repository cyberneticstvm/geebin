<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
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
}
