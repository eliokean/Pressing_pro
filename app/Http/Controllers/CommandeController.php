<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrixCalculator;
use App\Models\Vehicule;

class CommandeController extends Controller
{
    //
    public function calculerPrix(Request $request)
{
    $request->validate([
        'distance_metres' => 'required|numeric|min:1',
        'vehicule_type'   => 'required|string|in:Vélo,Moto,Voiture',
        'linges'          => 'required|array|min:1',
        'linges.*.prix'   => 'required|integer|min:0',
        'linges.*.quantite' => 'required|integer|min:1',
    ]);
 
    $vehicule = Vehicule::where('type', $request->vehicule_type)->firstOrFail();
 
    $resultat = PrixCalculator::calculerCommande(
        linges:          $request->linges,
        distanceMetres:  $request->distance_metres,  // directement en mètres
        vehicule:        $vehicule
    );
 
    return response()->json($resultat);
}
}
