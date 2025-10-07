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

        <!-- Summary Keseluruhan -->
        <div class="bg-blue-50 p-4 rounded mb-4">
            <h3 class="font-semibold mb-2">Ringkasan Keseluruhan:</h3>
            @php
                $totalCalonPenerima = $hasilPsi->flatten()->count();
                $totalLayak = $hasilPsi->flatten()->where('status', 'Layak')->count();
                $totalTidakLayak = $hasilPsi->flatten()->where('status', 'Tidak Layak')->count();
                $totalDesa = $hasilPsi->count();
            @endphp
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p>Total Dusun: <strong>{{ $totalDesa }}</strong></p>
                    <p>Total Calon Penerima: <strong>{{ $totalCalonPenerima }}</strong></p>
                </div>
                <div>
                    <p>Status Layak: <strong>{{ $totalLayak }}</strong> orang</p>
                    <p>Status Tidak Layak: <strong>{{ $totalTidakLayak }}</strong> orang</p>
                </div>
            </div>
        </div>

        <div class="border-b-2 border-black mb-4"></div>

        <!-- Table -->
        <div class="overflow-x-auto">
            @foreach ($hasilPsi as $desa => $data)
                <div class="mb-8">
                    <!-- Header Desa -->
                    <h3 class="text-lg font-bold text-black mb-4 bg-gray-100 p-2 rounded">
                        Dusun: {{ $desa }}
                    </h3>

                    <table class="w-full text-sm border-collapse border border-gray-300">
                        <thead>
                            <tr class="text-left text-gray-700 bg-gray-50">
                                <th class="py-2 px-4 font-semibold border border-gray-300">NIK</th>
                                <th class="py-2 px-4 font-semibold border border-gray-300">Nama Calon Penerima</th>
                                <th class="py-2 px-4 font-semibold border border-gray-300">Nilai Preferensi</th>
                                <th class="py-2 px-4 font-semibold border border-gray-300">Status</th>
                                <th class="py-2 px-4 font-semibold border border-gray-300">Periode</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($data as $item)
                                <tr>
                                    <td class="py-2 px-4 border border-gray-300">{{ $item->calon_penerima->nik ?? '-' }}
                                    </td>
                                    <td class="py-2 px-4 border border-gray-300">
                                        {{ $item->calon_penerima->nama ?? '-' }}</td>
                                    <td class="py-2 px-4 border border-gray-300">
                                        {{ number_format($item->nilai_preferensi, 4) }}</td>
                                    <td class="py-2 px-4 border border-gray-300">
                                        <span
                                            class="px-2 py-1 rounded text-xs {{ $item->status == 'Layak' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-4 border border-gray-300">{{ $item->periode }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Summary untuk setiap desa -->
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Total calon penerima di {{ $desa }}: {{ $data->count() }} orang</p>
                        <p>Layak: {{ $data->where('status', 'Layak')->count() }} orang |
                            Tidak Layak: {{ $data->where('status', 'Tidak Layak')->count() }} orang</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tanda Tangan Kepala Desa untuk halaman terakhir -->
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
