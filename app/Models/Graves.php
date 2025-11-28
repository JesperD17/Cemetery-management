<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graves extends Model
{
    protected $fillable = [
        'cemetery_id',
        'latitude',
        'longitude',
        'image_hash_url',
        'grave_number',
        'status_id',
        'description',
        'start_date',
        'end_date',
    ];

    public function cemetery()
    {
        return $this->belongsTo(Cemeteries::class, 'cemetery_id');
    }

    public function graveStatus()
    {
        return $this->belongsTo(GraveStatuses::class, 'status_id');
    }

    public function graveUsers()
    {
        return $this->hasMany(GraveUsers::class, 'grave_id');
    }

    public function deceased()
    {
        return $this->hasMany(GraveOfDeceased::class, 'grave_id');
    }
}
