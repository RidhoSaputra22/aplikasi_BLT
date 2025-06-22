<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penilaian>
 */
class PenilaianFactory extends Factory
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
            'calon_penerima_id' => \App\Models\CalonPenerima::factory(),
            'kriteria_id' => \App\Models\Kriteria::factory(),
            'nilai' => $this->faker->numberBetween(1, 10),
        ];
    }
}
