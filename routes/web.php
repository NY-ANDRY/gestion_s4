<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Irsa\Irsa;
use App\Livewire\Irsa\IrsaEdit;
use App\Livewire\Compta\Compte;
use App\Livewire\Compta\Journaux;
use App\Livewire\Compta\Exercices;
use App\Livewire\Compta\Ecritures;
use App\Livewire\Compta\LignesEcritures;

// use App\Http\Controllers\Home;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', Home::class);
Route::get('/irsa', Irsa::class);

Route::prefix('irsa')->group(function () {
    Route::get('/', Irsa::class);
    Route::get('/edit', IrsaEdit::class);
});

Route::prefix('compta')->group(function () {
    Route::get('/', Compte::class);
    Route::get('/journaux', Journaux::class);
    Route::get('/exercices', Exercices::class);
    Route::get('/ecritures', Ecritures::class);
    Route::get('/lignes_ecritures', LignesEcritures::class);
});