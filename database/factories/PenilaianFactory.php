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
        $kriteriaIds = \App\Models\Kriteria::pluck('id')->random();

        return [
            //
            'calon_penerima_id' => \App\Models\CalonPenerima::factory(),
            'kriteria_id' => $kriteriaIds,
            'sub_kriteria_id' => \App\Models\SubKriteria::where('kriteria_id', $kriteriaIds)->pluck('id')->random()
        ];
    }
}