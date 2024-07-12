<?php

namespace App\Models;

use Illuminate\Support\Collection;

/**
 * Class Pokemon
 */
class Pokemon
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @var integer
     */
    protected $weight;

    /**
     * @var Collection
     */
    protected $abilities;

    /**
     * @var Collection
     */
    protected $sprites;

    /**
     * @var Collection
     */
    protected $species;

    /**
     * Pokemon constructor.
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];

        $this->height = $data['height'];
        $this->weight = $data['weight'];
        
        $this->sprites = collect($data['sprites']);
        $this->species = collect($data['species']);
        $this->abilities = collect($data['abilities']);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'height' => $this->height,
            'weight' => $this->weight,
            'species' => $this->species->get('name'),
            'abilities' => $this->abilities->map(function($e) {
                return $e['ability']['name'];
            })->values(),
            'image' => [
                'front' => $this->sprites->get('front_default'),
                'back' => $this->sprites->get('back_default'),
            ]
        ];
    }
}
