<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LingeController;
use App\Http\Controllers\CommandeController;

// Page principale (vue panier + sélection linge)
Route::get('/', [LingeController::class, 'index'])->name('pressing.linge');

// API de calcul des prix (appelée en AJAX depuis la vue)
Route::post('/commande/calculer-prix', [CommandeController::class, 'calculerPrix'])
    ->name('commande.calculer-prix');