<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi - {{ $agenda->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .agenda-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }
        .stat-card {
            text-align: center;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
            min-width: 120px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .hadir {
            color: green;
            font-weight: bold;
        }
        .tidak-hadir {
            color: red;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN ABSENSI</h1>
        <h2>{{ $agenda->name }}</h2>
        <p>{{ optional($agenda->opd)->name }}</p>
    </div>

    <div class="agenda-info">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 25%;"><strong>OPD Penyelenggara:</strong></td>
                <td style="border: none; width: 25%;">{{ optional($agenda->opd)->name }}</td>
                <td style="border: none; width: 25%;"><strong>Tanggal:</strong></td>
                <td style="border: none; width: 25%;">{{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Waktu:</strong></td>
                <td style="border: none;">{{ \Carbon\Carbon::parse($agenda->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($agenda->jam_selesai)->format('H:i') }}</td>
                <td style="border: none;"><strong>Tempat:</strong></td>
                <td style="border: none;">{{ $agenda->link_zoom ?? 'Tidak tersedia' }}</td>
            </tr>
            @if($agenda->catatan)
            <tr>
                <td style="border: none;"><strong>Catatan:</strong></td>
                <td style="border: none;" colspan="3">{{ $agenda->catatan }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-number">{{ $total }}</div>
            <div class="stat-label">Total Peserta</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $hadir }}</div>
            <div class="stat-label">Hadir</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $tidak_hadir }}</div>
            <div class="stat-label">Tidak Hadir</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP/NIK</th>
                <th>Jabatan</th>
                <th>Instansi</th>
                <th>Waktu Absen</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attendance->name }}</td>
                <td>{{ $attendance->nip_nik ?? '-' }}</td>
                <td>{{ $attendance->jabatan ?? '-' }}</td>
                <td>{{ $attendance->instansi ?? '-' }}</td>
                <td>{{ $attendance->waktu_hadir ? \Carbon\Carbon::parse($attendance->waktu_hadir)->format('d/m/Y H:i') : '-' }}</td>
                <td class="{{ $attendance->status == 'hadir' ? 'hadir' : 'tidak-hadir' }}">
                    {{ $attendance->status }}
                </td>
                <td>{{ $attendance->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Belum ada data absensi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $date_generated }}
    </div>
</body>
</html>
