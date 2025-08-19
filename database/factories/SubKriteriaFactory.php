<?php

namespace Database\Factories;

use App\Models\Kriteria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubKriteria>
 */
class SubKriteriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'kriteria_id' => Kriteria::factory(),
            'nama_sub_kriteria' => $this->faker->word(),
            'bobot' => $this->faker->randomFloat(2, 0, 1),
        ];
    }
}
