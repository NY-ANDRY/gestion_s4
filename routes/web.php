<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\TodoList;
use App\Livewire\Irsa;
use App\Livewire\IrsaEdit;
use App\Livewire\IrsaWork;

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