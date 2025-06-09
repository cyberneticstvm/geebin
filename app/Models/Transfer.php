<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = ['date' => 'datetime'];

    public function status()
    {
        return ($this->deleted_at) ? "<span class='badge bg-danger'>Deleted</span>" : "<span class='badge bg-success'>Active</span>";
    }

    public function details()
    {
        return $this->hasMany(TransferDetail::class, 'transfer_id', 'id');
    }

    public function fromCompany()
    {
        return $this->belongsTo(Company::class, 'from_company_id', 'id');
    }

    public function toCompany()
    {
        return $this->belongsTo(Company::class, 'to_company_id', 'id');
    }
}
