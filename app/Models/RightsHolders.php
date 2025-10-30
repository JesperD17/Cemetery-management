<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RightsHolders extends Model
{
    protected $guarded = [];

    public function graveAgreements()
    {
        return $this->hasMany(GraveAgreements::class, 'rights_holder_id');
    }
}
