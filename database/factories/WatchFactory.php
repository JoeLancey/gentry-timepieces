<?php

namespace Database\Factories;

use App\Models\Watch;
use Illuminate\Database\Eloquent\Factories\Factory;

class WatchFactory extends Factory
{
    protected $model = Watch::class;

    public function definition()
    {
        return [
            'brand' => $this->faker->randomElement(['Rolex','Omega','Patek Philippe','Tag Heuer','Seiko','Cartier']),
            'model' => $this->faker->word . ' ' . $this->faker->bothify('##'),
            'reference_number' => strtoupper($this->faker->bothify('REF-####')),
            'serial_number' => strtoupper($this->faker->bothify('SN#####')),
            'year_produced' => $this->faker->numberBetween(1990, 2022),
            'condition' => $this->faker->randomElement(['excellent','good','fair','mint']),
            'has_box' => $this->faker->boolean(60),
            'has_papers' => $this->faker->boolean(40),
            'asking_price' => $this->faker->numberBetween(20000, 500000),
            'cost_price' => $this->faker->numberBetween(10000, 200000),
            'status' => $this->faker->randomElement(['available','sold','consigned']),
            'image_path' => null,
            'description' => $this->faker->sentence(),
        ];
    }
}
