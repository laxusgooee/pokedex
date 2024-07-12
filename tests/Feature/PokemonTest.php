<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class PokemonTest extends TestCase
{
    public function test_index_screen_can_be_rendered()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon*' => Http::response([
                "count" => 5,
                "next" => null,
                "previous" => null,
                'results' => [
                    ['name' => 'bulbasaur', 'url' => 'http://example.com/pokemon/1'],
                    ['name' => 'ivysaur', 'url' => 'http://example.com/pokemon/2'],
                    ['name' => 'venusaur', 'url' => 'http://example.com/pokemon/3'],
                    ['name' => 'charmander', 'url' => 'http://example.com/pokemon/4'],
                    ['name' => 'charmeleon', 'url' => 'http://example.com/pokemon/5'],
                ]
            ], 200),
        ]);

        $response = $this->get(route('pokemon.index'));

        $response->assertStatus(200);
    }

    public function test_index_screen_with_query_can_be_rendered()
    {
        Http::fake([
            'https://pokeapi.co/api/v2/pokemon*' => Http::response([
                "count" => 5,
                "next" => null,
                "previous" => null,
                'results' => [
                    ['name' => 'bulbasaur', 'url' => 'http://example.com/pokemon/1'],
                    ['name' => 'ivysaur', 'url' => 'http://example.com/pokemon/2'],
                    ['name' => 'venusaur', 'url' => 'http://example.com/pokemon/3'],
                    ['name' => 'charmander', 'url' => 'http://example.com/pokemon/4'],
                    ['name' => 'charmeleon', 'url' => 'http://example.com/pokemon/5'],
                ]
            ], 200),
        ]);

        $response = $this->get(route('pokemon.index',  ['query' => 'char']));

        $response->assertStatus(200);
    }
}