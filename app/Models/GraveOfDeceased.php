<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraveOfDeceased extends Model
{
    protected $table = 'grave_of_deceased';
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
