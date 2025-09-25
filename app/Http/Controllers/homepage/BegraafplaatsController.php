<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class BegraafplaatsController extends Controller
{
    public function index()
    {
        // dummy data om in je Svelte te tonen
        $begraafplaats = [
            'titel' => 'Titel begraafplaats',
            'omschrijving' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Proin vitae urna sed velit porttitor tincidunt. Integer nec dolor sed nulla euismod cursus.',
        ];

        return Inertia::render('BegraafplaatsHome', [
            'begraafplaats' => $begraafplaats,
        ]);
    }
}
