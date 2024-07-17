<!-- resources/views/pdf/karyawan.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Data Karyawan</title>
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
    <h1>Rekap Absensi Karyawan</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Total Hadir</th>
                <th>Total Sakit</th>
                <th>Total Izin</th>
                <th>Total Alpa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $karyawan)
            <tr>
                <td>{{ $karyawan->nama }}</td>
                <td>{{ $karyawan->jabatan }}</td>
                <td>{{ $karyawan->jumlah_hadir }}</td>
                <td>{{ $karyawan->jumlah_sakit }}</td>
                <td>{{ $karyawan->jumlah_izin }}</td>
                <td>{{ $karyawan->jumlah_alpa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
