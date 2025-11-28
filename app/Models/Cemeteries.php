<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cemeteries extends Model
{
    protected $table = 'cemeteries';
    
    protected $fillable = [
        'name',
        'municipality_id',
        'city',
        'address',
        'zip_code',
        'image_hash_url',
        'description',
    ];

    public function graves()
    {
        return $this->hasMany(Graves::class, 'cemetery_id');
    }
}
