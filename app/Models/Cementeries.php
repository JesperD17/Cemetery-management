<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cementeries extends Model
{
    protected $table = 'cemeteries';
    
    protected $fillable = [
        'name', 
        'municipality',
        'latitude', 
        'longitude'
    ];
}
