<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cemeteries extends Model
{
    protected $table = 'cemeteries';
    
    protected $fillable = [
        'name', 
        'municipality',
        'latitude', 
        'longitude'
    ];

    public function graves()
    {
        return $this->hasMany(Graves::class, 'cemetery_id');
    }
}
