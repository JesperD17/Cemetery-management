<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graves extends Model
{
    protected $guarded = [];

    public function cementaries()
    {
        return $this->belongsTo(Cementeries::class, 'cemetary_id');
    }

    public function graveAgreements()
    {
        return $this->hasMany(GraveAgreements::class, 'grave_id');
    }

    public function deceased()
    {
        return $this->hasMany(GraveOfDeceased::class, 'grave_id');
    }
}
