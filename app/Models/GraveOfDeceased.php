<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraveOfDeceased extends Model
{
    protected $guarded = [];

    public function deceased()
    {
        return $this->belongsTo(Deceased::class, 'deceased_id');
    }

    public function graves()
    {
        return $this->belongsTo(Graves::class, 'grave_id');
    }
}
