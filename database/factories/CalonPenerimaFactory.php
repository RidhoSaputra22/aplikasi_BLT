<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalonPenerima>
 */
class CalonPenerimaFactory extends Factory
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
            'nik' => $this->faker->unique()->numerify('##########'),
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'no_kk' => $this->faker->numerify('###########'),
            'desa' => $this->faker->citySuffix(),
            'kecamatan' => $this->faker->city(),
            'kabupaten' => $this->faker->state(),
            'tanggal_input' => now(),
        ];
    }
}
