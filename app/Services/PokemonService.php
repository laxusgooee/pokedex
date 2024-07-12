<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Class PokemonService
 */
class PokemonService
{
    /**
     * @var string
     */
    private $baseUrl = 'https://pokeapi.co/api/v2/pokemon';

    /**
     * @return Collection
     */
    public function getAll() : Collection
    {
        $pokemons = new Collection();
        $next_url = $this->baseUrl . '?limit=250&offset=0';

        do {
            $res= $this->sendRequest($next_url);

            $pokemons = $pokemons->merge($res['results']);
            $next_url = $res['next'];

        } while ($next_url !== null);

        return $pokemons;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function sendRequest($url)
    {
        $response = Http::get($url);
    
        return $response->json();
    }
}