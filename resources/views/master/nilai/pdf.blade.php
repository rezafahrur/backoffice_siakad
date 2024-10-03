<!DOCTYPE html>
<html>
<head>
    <title>Detail Nilai</title>
    <style>
        /* Styling khusus untuk PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
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
    <h2>Detail Nilai</h2>
    <p><strong>Program Studi:</strong> {{ $nilai->programStudi->nama_program_studi }}</p>
    <p><strong>Kelas:</strong> {{ $nilai->kelas->nama_kelas }}</p>
    <p><strong>Mata Kuliah:</strong> {{ $nilai->matakuliah->nama_matakuliah }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Proyek Akhir</th>
                <th>Aktivitas Partisipatif</th>
                <th>Quiz</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Nilai Angka</th>
                <th>Nilai Indeks</th>
                <th>Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilai->details as $detail)
                <tr>
                    <td>{{ $detail->mahasiswa->nama }}</td>
                    <td>{{ $detail->hasil_proyek }}</td>
                    <td>{{ $detail->aktivitas_partisipatif }}</td>
                    <td>{{ $detail->quiz }}</td>
                    <td>{{ $detail->tugas }}</td>
                    <td>{{ $detail->uts }}</td>
                    <td>{{ $detail->uas }}</td>
                    <td>{{ $detail->nilai_angka }}</td>
                    <td>{{ $detail->nilai_indeks }}</td>
                    <td>{{ $detail->nilai_huruf }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
