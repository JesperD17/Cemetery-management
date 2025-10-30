<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deceased extends Model
{
    protected $guarded = [];

    public function graves()
    {
        return $this->hasMany(GraveOfDeceased::class, 'deceased_id');
    }
}
