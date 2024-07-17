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
    <h1>Absensi Tanggal {{ $date }}</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $ab)
            <tr>
                <td>{{ $ab->karyawan->nama }}</td>
                <td>{{ $ab->karyawan->jabatan }}</td>
                <td>{{ $ab->tanggal }}</td>
                <td>{{ $ab->jam_masuk ?? '-' }}</td>
                <td>{{ $ab->jam_keluar ?? '-' }}</td>
                <td>{{ $ab->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
