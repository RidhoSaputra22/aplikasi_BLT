<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Hasil PSI</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-800">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <!-- Kop Surat -->
        <div class="flex items-center border-b-4 border-black pb-4 mb-6">
            <!-- Logo -->
            <div class="flex-shrink-0 w-24 text-center">
                <img src="{{ public_path('logo-kolaka-utara.png') }}" alt="Logo Pemda" class="w-50 mx-auto">
            </div>

            <!-- Teks Kop Surat -->
            <div class="flex-1 text-center">
                <h2 class="text-lg font-bold">PEMERINTAH KABUPATEN KOLAKA UTARA</h2>
                <h3 class="text-base font-semibold">KECAMATAN TOLALA</h3>
                <h3 class="text-base font-semibold">DESA LAWAKI JAYA</h3>
                <p class="text-sm mt-1">
                    Alamat: Desa Lawaki Jaya, Kec. Tolala, Kab. Kolaka Utara, Provinsi Sulawesi Tenggara, Kode Pos 93951
                </p>
            </div>
        </div>

        {{-- <div class="border-b-2 border-black mb-4"></div> --}}

        <!-- Header -->
        <h2 class="text-xl font-bold text-black mt-14">Laporan Hasil Perhitungan Penerima BLT</h2>
        <p class="text-sm text-gray-600 mb-2">
            Berikut adalah daftar penerima BLT untuk periode yang ditentukan <br>
            Tanggal print: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
        </p>
        <div class="border-b-2 border-black mb-4"></div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="text-left text-gray-700">
                        <th class="py-2 px-4 font-semibold">NIK</th>
                        <th class="py-2 px-4 font-semibold">Nama Calon Penerima</th>
                        <th class="py-2 px-4 font-semibold">Nilai Preferensi</th>
                        <th class="py-2 px-4 font-semibold">Status</th>
                        <th class="py-2 px-4 font-semibold">Periode</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($hasilPsi as $item)
                        <tr>
                            <td class="py-2 px-4">{{ $item->calon_penerima->nik ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $item->calon_penerima->nama ?? '-' }}</td>
                            <td class="py-2 px-4">{{ number_format($item->nilai_preferensi, 4) }}</td>
                            <td class="py-2 px-4">{{ $item->status }}</td>
                            <td class="py-2 px-4">{{ $item->periode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tanda Tangan Kepala Desa -->
    <div class="mt-16 mr-8 flex justify-end">
        <div class="text-center">
            <p class="mb-3">Lawaki Jaya, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p class="font-semibold">Kepala Desa Lawaki Jaya</p>
            <div style="height: 80px;"></div>
            <p class="font-bold underline">Nama Kepala Desa</p>
        </div>
    </div>


</body>

</html>
