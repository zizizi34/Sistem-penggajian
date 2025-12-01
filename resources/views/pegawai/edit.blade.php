@extends('layouts.dashboard')

@section('header')
    <h2 class="text-lg font-semibold">Edit Pegawai</h2>
@endsection

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" class="mt-2 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm">Nama</label>
                <input name="nama_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm">Gaji Pokok</label>
                    <input id="edit_gaji_display" type="text" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('gaji_pokok', number_format($pegawai->gaji_pokok ?? 0, 0, ',', '.')) }}">
                    <input type="hidden" name="gaji_pokok" id="edit_gaji" value="{{ old('gaji_pokok', $pegawai->gaji_pokok) }}">
                </div>
                <div>
                    <label class="block text-sm">Status</label>
                    <select name="status_karyawan" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="tetap" {{ $pegawai->status_karyawan === 'tetap' ? 'selected' : '' }}>Pegawai Tetap</option>
                        <option value="kontrak" {{ $pegawai->status_karyawan === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="magang" {{ $pegawai->status_karyawan === 'magang' ? 'selected' : '' }}>Magang</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm">Jabatan</label>
                <select name="id_jabatan" class="mt-1 block w-full border rounded px-3 py-2">
                    <option value="">Tidak ada</option>
                    @foreach($jabatans as $jab)
                        <option value="{{ $jab->id }}" {{ $pegawai->id_jabatan == $jab->id ? 'selected' : '' }}>{{ $jab->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.dashboard', ['dept' => $pegawai->id_departemen]) }}" class="px-4 py-2 bg-gray-200 rounded">Kembali</a>
            </div>
        </form>

        <div class="mt-3">
            <form method="POST" action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}" onsubmit="return confirm('Hapus pegawai ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </form>
        </div>
    </div>
    <script>
        // Formatting for edit gaji input
        (function(){
            function formatDisplay(value) {
                if (value === null || value === undefined) return '';
                let s = String(value).replace(/[^0-9]/g, '');
                s = s.replace(/^0+(?=\d)/, '');
                if (s === '') return '';
                return s.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function normalizeNumber(formatted) {
                if (!formatted) return '';
                return formatted.replace(/\./g, '') || '';
            }

            const display = document.getElementById('edit_gaji_display');
            const hidden = document.getElementById('edit_gaji');
            const form = display ? display.closest('form') : null;

            if (display) {
                display.addEventListener('input', function(){
                    const raw = this.value;
                    const formatted = formatDisplay(raw);
                    this.value = formatted;
                    if (hidden) hidden.value = normalizeNumber(formatted);
                });

                if (hidden) hidden.value = normalizeNumber(display.value);
            }

            if (form) form.addEventListener('submit', function(){ if (display && hidden) hidden.value = normalizeNumber(display.value); });
        })();
    </script>
@endsection
