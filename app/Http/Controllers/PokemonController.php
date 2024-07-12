<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\PokemonService;

class PokemonController extends Controller
{
    protected $pokemonService;

    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    /**
     * Display the user's Pokemon form.
     */
    public function index(Request $request): Response
    {
        $pokemons = $this->pokemonService->getAll();

        return Inertia::render('Welcome', [
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'pokemons' => $pokemons->all()
        ]);
    }
}
