<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linge;
use App\Models\Vehicule;

class LingeController extends Controller
{
    public function index()
    {
        $lingesParCategorie = Linge::actif()
            ->orderBy('categorie')
            ->orderBy('nom')
            ->get()
            ->groupBy('categorie');


            // Véhicules depuis la DB, ordonnés par coefficient croissant
            $vehicules = Vehicule::orderBy('coefficient')->get();

        return view('dash', compact('lingesParCategorie', 'vehicules'));
    }
}
