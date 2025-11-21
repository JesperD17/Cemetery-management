<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraveUsers extends Model
{
    protected $table = 'grave_users';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function grave()
    {
        return $this->belongsTo(Graves::class, 'grave_id');
    }
}
