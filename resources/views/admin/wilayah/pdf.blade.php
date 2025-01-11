<!DOCTYPE html>
<html>
<head>
    <title>Data Wilayah</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Wilayah</h2>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Status</th>
                <th>Penduduk</th>
                <th>Luas (km²)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wilayah as $w)
                <tr>
                    <td>{{ $w->kode_wilayah }}</td>
                    <td>{{ $w->nama_wilayah }}</td>
                    <td>{{ ucfirst($w->jenis) }}</td>
                    <td>{{ ucfirst($w->status) }}</td>
                    <td>{{ $w->detail->jumlah_penduduk ?? 0 }}</td>
                    <td>{{ $w->detail->luas_wilayah ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 