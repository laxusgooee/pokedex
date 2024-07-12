<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PokemonController::class, 'index'])->name('pokemon.index');
Route::get('/{name}', [PokemonController::class, 'show'])->name('pokemon.show');
