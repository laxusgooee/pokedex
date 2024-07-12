<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Exceptions\NetworkException;

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
     * @throws NetworkException
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
     * @param string $query
     * @return Collection
     * @throws NetworkException
     */
    public function find($query) : Collection
    {
        $pokemons = $this->getAll();

        if (empty($query)) {
            return $pokemons;
        }

        return $pokemons->filter(function ($pokemon) use ($query) {
            return Str::contains(strtolower($pokemon['name']), strtolower($query));
        })->values();
    }

    /**
     * @param string $url
     * @return mixed
     * @throws NetworkException
     */
    public function sendRequest($url)
    {
        $response = Http::get($url);
    
        if ($response->failed()) {
            throw new NetworkException($url, 'Failed to fetch Pokémon data.');
        }

        return $response->json();
    }
}
