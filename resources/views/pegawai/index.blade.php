<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">
    <h1 class="text-2xl font-bold mb-6">Daftar Pegawai</h1>

    <table class="table-auto w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Departemen</th>
                <th class="px-4 py-2">Jabatan</th>
                <th class="px-4 py-2">Gaji Pokok</th>
                <th class="px-4 py-2">Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $pegawai)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $pegawai->nama_pegawai }}</td>
                    <td class="px-4 py-2">{{ $pegawai->departemen->nama_departemen ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $pegawai->tanggal_masuk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
