<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Begraafplaats extends Model
{
    use HasFactory;

    // tabelnaam (anders gaat Laravel 'begraafplaats' zoeken)
    protected $table = 'begraafplaatsen';

    // welke velden mogen gevuld worden
    protected $fillable = [
        'naam',
        'locatie',
        'status',
    ];
}
