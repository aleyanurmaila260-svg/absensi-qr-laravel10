<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        h3 { margin-bottom: 4px; }
    </style>
</head>
<body>
    <h3>Laporan Rekap Absensi</h3>
    <p>Periode: {{ $dateFrom }} s/d {{ $dateTo }}</p>
    <table>
        <thead><tr><th>Nama</th><th>Kelas</th><th>Hadir</th><th>Telat</th></tr></thead>
        <tbody>
        @foreach ($recap as $row)
            <tr>
                <td>{{ $row['student']->name }}</td>
                <td>{{ $row['student']->schoolClass->name }}</td>
                <td>{{ $row['hadir'] }}</td>
                <td>{{ $row['telat'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
