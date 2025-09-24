<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use App\Models\TipeKriteria;
use App\Models\CalonPenerima;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
        ]);

        Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        $dataKriteria = [
            [
                'kode' => 'C1',
                'nama_kriteria' => 'Pekerjaan Suami',
                'tipe' => TipeKriteria::Cost,

                'sub_kriteria' => [
                    ['label' => 'PNS', 'bobot' => 1],
                    ['label' => 'Wirausaha/Wiraswasta', 'bobot' => 2],
                    ['label' => 'Petani', 'bobot' => 3],
                    ['label' => 'Buruh', 'bobot' => 4],
                    ['label' => 'Pengangguran', 'bobot' => 5],
                ]
            ],
            [
                'kode' => 'C2',
                'nama_kriteria' => 'Pekerjaan Istri',
                'tipe' => TipeKriteria::Cost,

                'sub_kriteria' => [
                    ['label' => 'PNS', 'bobot' => 1],
                    ['label' => 'Wirausaha/Wiraswasta', 'bobot' => 2],
                    ['label' => 'Petani', 'bobot' => 3],
                    ['label' => 'Buruh', 'bobot' => 4],
                    ['label' => 'Pengangguran', 'bobot' => 5],
                ]
            ],
            [
                'kode' => 'C3',
                'nama_kriteria' => 'Penghasilan Keseluruhan',
                'tipe' => TipeKriteria::Cost,
                'sub_kriteria' => [
                    ['label' => '>= 2.000.000', 'bobot' => 1],
                    ['label' => 'Rp. 1.600.000 – Rp. 2.000.000', 'bobot' => 2],
                    ['label' => 'Rp. 1.100.000 – 1.500.000', 'bobot' => 3],
                    ['label' => 'Rp. 500.000 – Rp. 1.000.000', 'bobot' => 4],
                    ['label' => '<=500.000', 'bobot' => 5],
                ]
            ],
            [
                'kode' => 'C4',
                'nama_kriteria' => 'Jumlah Tanggungan',
                'tipe' => TipeKriteria::Benefit,

                'sub_kriteria' => [
                    ['label' => '<= 2 Anak', 'bobot' => 1],
                    ['label' => '3 Anak', 'bobot' => 2],
                    ['label' => '4 Anak', 'bobot' => 3],
                    ['label' => '5 Anak', 'bobot' => 4],
                    ['label' => '>= 6 Anak', 'bobot' => 5],
                ]
            ],
            [
                'kode' => 'C5',
                'nama_kriteria' => 'Kondisi Rumah',
                'tipe' => TipeKriteria::Cost,
                'sub_kriteria' => [
                    ['label' => 'Betom', 'bobot' => 1],
                    ['label' => 'Batu Bara', 'bobot' => 2],
                    ['label' => 'Triplek', 'bobot' => 3],
                    ['label' => 'Papan', 'bobot' => 4],
                    ['label' => 'Bambu', 'bobot' => 5],
                ]
            ],
        ];



        $calonPenerima = [
            [
                'nik' => '1234567890',
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Melati No. 12',
                'no_kk' => '98765432101',
                'desa' => 'Barat',
                'kecamatan' => 'Cilandak',
                'kabupaten' => 'Jawa Barat',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '2345678901',
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. Mawar No. 5',
                'no_kk' => '87654321012',
                'desa' => 'Timur',
                'kecamatan' => 'Kebayoran',
                'kabupaten' => 'Jawa Tengah',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '3456789012',
                'nama' => 'Agus Prasetyo',
                'alamat' => 'Jl. Kenanga No. 8',
                'no_kk' => '76543210123',
                'desa' => 'Utara',
                'kecamatan' => 'Pasar Minggu',
                'kabupaten' => 'Jawa Timur',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '4567890123',
                'nama' => 'Dewi Lestari',
                'alamat' => 'Jl. Dahlia No. 3',
                'no_kk' => '65432101234',
                'desa' => 'Selatan',
                'kecamatan' => 'Pancoran',
                'kabupaten' => 'Sumatera Utara',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '5678901234',
                'nama' => 'Rudi Hartono',
                'alamat' => 'Jl. Anggrek No. 7',
                'no_kk' => '54321012345',
                'desa' => 'Barat',
                'kecamatan' => 'Menteng',
                'kabupaten' => 'Banten',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '6789012345',
                'nama' => 'Fitriani',
                'alamat' => 'Jl. Flamboyan No. 9',
                'no_kk' => '43210123456',
                'desa' => 'Timur',
                'kecamatan' => 'Setiabudi',
                'kabupaten' => 'Lampung',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '7890123456',
                'nama' => 'Andi Wijaya',
                'alamat' => 'Jl. Sakura No. 11',
                'no_kk' => '32101234567',
                'desa' => 'Utara',
                'kecamatan' => 'Tebet',
                'kabupaten' => 'Sulawesi Selatan',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '8901234567',
                'nama' => 'Sri Wahyuni',
                'alamat' => 'Jl. Teratai No. 2',
                'no_kk' => '21012345678',
                'desa' => 'Selatan',
                'kecamatan' => 'Jagakarsa',
                'kabupaten' => 'Kalimantan Barat',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '9012345678',
                'nama' => 'Eko Saputra',
                'alamat' => 'Jl. Kamboja No. 6',
                'no_kk' => '10123456789',
                'desa' => 'Barat',
                'kecamatan' => 'Cipayung',
                'kabupaten' => 'Bali',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ],
            [
                'nik' => '0123456789',
                'nama' => 'Lina Marlina',
                'alamat' => 'Jl. Bougenville No. 4',
                'no_kk' => '01234567890',
                'desa' => 'Timur',
                'kecamatan' => 'Mampang',
                'kabupaten' => 'NTB',
                'tanggal_input' => now(),
                'kriteria' => [
                    '1' => '1',
                    '2' => '1',
                    '3' => '1',
                    '4' => '1',
                    '5' => '1',
                ]
            ]
        ];

        foreach ($dataKriteria as $kriteria) {
            $kriteriaData = Kriteria::create([
                'kode' => $kriteria['kode'],
                'nama_kriteria' => $kriteria['nama_kriteria'],
                'tipe' => $kriteria['tipe'],
            ]);

            foreach ($kriteria['sub_kriteria'] as $sub) {
                SubKriteria::create([
                    'nama_sub_kriteria' => $sub['label'],
                    'bobot' => $sub['bobot'],
                    'kriteria_id' => $kriteriaData->id
                ]);
            }
        }

        foreach ($calonPenerima as $penerima) {
            $penerimaData = CalonPenerima::create([
                'nik' => $penerima['nik'],
                'nama' => $penerima['nama'],
                'alamat' => $penerima['alamat'],
                'no_kk' => $penerima['no_kk'],
                'desa' => $penerima['desa'],
                'kecamatan' => $penerima['kecamatan'],
                'kabupaten' => $penerima['kabupaten'],
                'tanggal_input' => $penerima['tanggal_input'],
            ]);

            foreach ($penerima['kriteria'] as $key => $value) {
                Penilaian::create([
                    'calon_penerima_id' => $penerimaData->id,
                    'kriteria_id' => $key,
                    'sub_kriteria_id' => SubKriteria::where('kriteria_id', $key)->inRandomOrder()->first()->id
                ]);
            }
        }

        CalonPenerima::factory(50)->create()->each(function ($calon) {
            $calon->penilaian()->saveMany(
                Penilaian::factory(5)->make()
            );
        });
    }
}
