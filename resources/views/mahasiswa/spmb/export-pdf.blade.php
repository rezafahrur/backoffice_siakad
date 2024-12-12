<!-- resources/views/mahasiswa/spmb/export-all-pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Validasi Pendaftar SPMB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Validasi Pendaftar SPMB</h1>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>No Pendaftaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendaftar as $key => $spmb)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $spmb->user ? $spmb->user->name : 'Tidak Tersedia' }}</td>
                    <td>{{ $spmb->no_pendaftaran }}</td>
                    <td>
                        @if ($spmb->status == 0)
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($spmb->status == 1)
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
