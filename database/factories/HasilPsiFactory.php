<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HasilPsi>
 */
class HasilPsiFactory extends Factory
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
            'nilai_preferensi' => $this->faker->randomFloat(4, 0, 1),
            'periode' => '2025-Q' . $this->faker->numberBetween(1, 4),
            'status' => $this->faker->randomElement(['Layak', 'Tidak Layak']),
        ];
    }
}
