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
    <h1>Data Karyawan</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur</th>
                <th>Jabatan</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($karyawans as $karyawan)
            <tr>
                <td>{{ $karyawan->nama }}</td>
                <td>{{ $karyawan->umur }}</td>
                <td>{{ $karyawan->jabatan }}</td>
                <td>{{ $karyawan->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
