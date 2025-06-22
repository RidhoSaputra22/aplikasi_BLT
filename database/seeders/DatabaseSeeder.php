<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        \App\Models\Kriteria::factory()->count(4)->create();
        \App\Models\CalonPenerima::factory()
            ->count(20)
            ->create()
            ->each(function ($calon) {
                $kriteriaIds = \App\Models\Kriteria::pluck('id');
                foreach ($kriteriaIds as $kriteriaId) {
                    \App\Models\Penilaian::factory()->create([
                        'calon_penerima_id' => $calon->id,
                        'kriteria_id' => $kriteriaId,
                    ]);
                }
            });
    }
}
