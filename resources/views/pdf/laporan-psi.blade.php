<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Hasil PSI</title>
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1f2937;
            background-color: #ffffff;
        }

        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px 24px;
        }

        /* Kop Surat */
        .kop-surat {
            display: table;
            width: 100%;
            border-bottom: 4px solid #000;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .kop-logo {
            display: table-cell;
            width: 96px;
            vertical-align: middle;
            text-align: center;
        }

        .kop-logo img {
            width: 80px;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .kop-text h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .kop-text h3 {
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }

        .kop-text p {
            font-size: 11px;
            margin-top: 4px;
        }

        /* Header Laporan */
        .laporan-title {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-top: 40px;
        }

        .laporan-subtitle {
            font-size: 11px;
            color: #4b5563;
            margin-bottom: 8px;
        }

        /* Summary Box */
        .summary-box {
            background-color: #eff6ff;
            padding: 16px;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .summary-box h3 {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .summary-grid {
            display: table;
            width: 100%;
            font-size: 11px;
        }

        .summary-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .summary-col p {
            margin: 2px 0;
        }

        /* Divider */
        .divider {
            border-bottom: 2px solid #000;
            margin-bottom: 16px;
        }

        /* Desa Section */
        .desa-section {
            margin-bottom: 30px;
        }

        .desa-header {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 12px;
            background-color: #f3f4f6;
            padding: 8px;
            border-radius: 4px;
        }

        /* Table */
        table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 6px 10px;
            border: 1px solid #d1d5db;
            text-align: left;
        }

        table thead tr {
            background-color: #f9fafb;
            color: #374151;
        }

        table th {
            font-weight: 600;
        }

        .col-periode {
            width: 100px;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
        }

        .badge-layak {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-tidak-layak {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Desa Summary */
        .desa-summary {
            margin-top: 8px;
            font-size: 11px;
            color: #4b5563;
        }

        .desa-summary p {
            margin: 2px 0;
        }

        /* Tanda Tangan */
        .ttd-wrapper {
            margin-top: 60px;
            text-align: right;
            padding-right: 32px;
        }

        .ttd-box {
            display: inline-block;
            text-align: center;
        }

        .ttd-box .ttd-date {
            margin-bottom: 10px;
        }

        .ttd-box .ttd-title {
            font-weight: 600;
        }

        .ttd-space {
            height: 80px;
        }

        .ttd-box .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Page break helper */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <!-- Logo -->
            <div class="kop-logo">
                <img src="{{ public_path('logo-kolaka-utara.png') }}" alt="Logo Pemda">
            </div>

            <!-- Teks Kop Surat -->
            <div class="kop-text">
                <h2>PEMERINTAH KABUPATEN KOLAKA UTARA</h2>
                <h3>KECAMATAN TOLALA</h3>
                <h3>DESA LAWAKI JAYA</h3>
                <p>
                    Alamat: Desa Lawaki Jaya, Kec. Tolala, Kab. Kolaka Utara, Provinsi Sulawesi Tenggara, Kode Pos 93951
                </p>
            </div>
        </div>

        <!-- Header -->
        <h2 class="laporan-title">Laporan Hasil Perhitungan Penerima BLT</h2>
        <p class="laporan-subtitle">
            Berikut adalah daftar penerima BLT untuk periode yang ditentukan <br>
            Tanggal print: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
        </p>

        <!-- Summary Keseluruhan -->
        <div class="summary-box">
            <h3>Ringkasan Keseluruhan:</h3>
            @php
                $totalCalonPenerima = $hasilPsi->flatten()->count();
                $totalLayak = $hasilPsi->flatten()->where('status', 'Layak')->count();
                $totalTidakLayak = $hasilPsi->flatten()->where('status', 'Tidak Layak')->count();
                $totalDesa = $hasilPsi->count();
            @endphp
            <div class="summary-grid">
                <div class="summary-col">
                    <p>Total Dusun: <strong>{{ $totalDesa }}</strong></p>
                    <p>Total Calon Penerima: <strong>{{ $totalCalonPenerima }}</strong></p>
                </div>
                <div class="summary-col">
                    <p>Status Layak: <strong>{{ $totalLayak }}</strong> orang</p>
                    <p>Status Tidak Layak: <strong>{{ $totalTidakLayak }}</strong> orang</p>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Table -->
        @foreach ($hasilPsi as $desa => $data)
            <div class="desa-section">
                <!-- Header Desa -->
                <h3 class="desa-header">
                    Dusun: {{ $desa }}
                </h3>

                <table>
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Calon Penerima</th>
                            <th>Nilai Preferensi</th>
                            <th>Status</th>
                            <th class="col-periode">Periode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->calon_penerima->nik ?? '-' }}</td>
                                <td>{{ $item->calon_penerima->nama ?? '-' }}</td>
                                <td>{{ number_format($item->nilai_preferensi, 4) }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'Layak' ? 'badge-layak' : 'badge-tidak-layak' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>{{ $item->periode }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Summary untuk setiap desa -->
                <div class="desa-summary">
                    <p>Total calon penerima di {{ $desa }}: {{ $data->count() }} orang</p>
                    <p>Layak: {{ $data->where('status', 'Layak')->count() }} orang |
                        Tidak Layak: {{ $data->where('status', 'Tidak Layak')->count() }} orang</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tanda Tangan Kepala Desa -->
    <div class="ttd-wrapper">
        <div class="ttd-box">
            <p class="ttd-date">Lawaki Jaya, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p class="ttd-title">Kepala Desa Lawaki Jaya</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">Nama Kepala Desa</p>
        </div>
    </div>
</body>

</html>
