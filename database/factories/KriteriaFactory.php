<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kriteria>
 */
class KriteriaFactory extends Factory
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
            'kode' => 'C' . $this->faker->unique()->randomDigitNotNull(),
            'nama_kriteria' => $this->faker->randomElement(['Penghasilan', 'Tanggungan', 'Status Rumah', 'Pendidikan']),
            'tipe' => $this->faker->randomElement(['Benefit', 'Cost']),
            'bobot' => $this->faker->randomFloat(2, 0.1, 0.5),
        ];
    }
}
