<!-- resources/views/pdf/karyawan.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Absen Bulan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Data Absensi</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absent as $date => $data)
            <tr>
                <td>{{ $date }}</td>
                <td>{{ $data['hadir'] }}</td>
                <td>{{ $data['sakit'] }}</td>
                <td>{{ $data['izin'] }}</td>
                <td>{{ $data['alpa'] }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="font-weight: 600">Jumlah</td>
                <td style="font-weight: 600">{{ $totalHadir }}</td>
                <td style="font-weight: 600">{{ $totalSakit }}</td>
                <td style="font-weight: 600">{{ $totalIzin }}</td>
                <td style="font-weight: 600">{{ $totalAlpa }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
