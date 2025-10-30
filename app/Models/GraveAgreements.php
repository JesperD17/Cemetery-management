<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraveAgreements extends Model
{
    protected $guarded = [];

    public function rightsHolders()
    {
        return $this->belongsTo(RightsHolders::class, 'rights_holder_id');
    }

    public function graves()
    {
        return $this->belongsTo(Graves::class, 'grave_id');
    }
}
