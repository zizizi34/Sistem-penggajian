@extends('layouts.dashboard')

@section('header')
    <h2 class="text-lg font-semibold">Tambah Pegawai</h2>
@endsection

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('pegawai.store') }}" class="mt-2 space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input name="nik_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nik_pegawai') }}">
                @error('nik_pegawai')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Pegawai</label>
                <input name="nama_pegawai" required class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('nama_pegawai') }}">
                @error('nama_pegawai')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('tanggal_masuk') }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Gaji Pokok</label>
                    <input id="gaji_pokok_display" type="text" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('gaji_pokok') ? number_format(old('gaji_pokok'), 0, ',', '.') : '' }}" placeholder="0">
                    <input type="hidden" name="gaji_pokok" id="gaji_pokok" value="{{ old('gaji_pokok') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status Karyawan</label>
                    <select name="status_karyawan" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="tetap">Pegawai Tetap</option>
                        <option value="kontrak">Kontrak</option>
                        <option value="magang">Magang</option>
                    </select>
                </div>
            </div>

            @if(auth()->user() && auth()->user()->role !== 'admin')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departemen</label>
                    <select name="id_departemen" class="mt-1 block w-full border rounded px-3 py-2">
                        <option value="">Pilih departemen</option>
                        @foreach($departemen as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex items-center space-x-3">
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
                <a href="{{ route('pegawai.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectDept = document.querySelector('select[name="id_departemen"]');
            
            if (selectDept) {
                selectDept.addEventListener('focus', function() {
                    // Sembunyikan placeholder saat fokus
                    if (this.value === '') {
                        const placeholder = this.querySelector('option[value=""]');
                        if (placeholder) {
                            placeholder.style.display = 'none';
                        }
                    }
                });
                
                selectDept.addEventListener('blur', function() {
                    // Tampilkan kembali placeholder jika tidak ada pilihan
                    if (this.value === '') {
                        const placeholder = this.querySelector('option[value=""]');
                        if (placeholder) {
                            placeholder.style.display = 'block';
                        }
                    }
                });
            }
        });
    </script>
    <script>
        // Formatting for currency input (Indonesian style: thousand separator dot)
        (function(){
            function formatDisplay(value) {
                if (value === null || value === undefined) return '';
                // Keep only digits
                let s = String(value).replace(/[^0-9]/g, '');
                // Remove leading zeros except single zero
                s = s.replace(/^0+(?=\d)/, '');
                if (s === '') return '';
                // Add thousand separators (dot) from right
                return s.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function normalizeNumber(formatted) {
                if (!formatted) return '';
                // Remove dots and return plain number string
                return formatted.replace(/\./g, '') || '';
            }

            const display = document.getElementById('gaji_pokok_display');
            const hidden = document.getElementById('gaji_pokok');
            const form = display ? display.closest('form') : null;

            if (display) {
                display.addEventListener('input', function(e){
                    const cursorPos = this.selectionStart;
                    const raw = this.value;
                    const formatted = formatDisplay(raw);
                    this.value = formatted;
                    // update hidden numeric value
                    if (hidden) hidden.value = normalizeNumber(formatted);
                    try { this.setSelectionRange(cursorPos, cursorPos); } catch (err) {}
                });

                // initialize hidden value
                if (hidden) hidden.value = normalizeNumber(display.value);
            }

            if (form) {
                form.addEventListener('submit', function(){
                    if (display && hidden) {
                        hidden.value = normalizeNumber(display.value);
                    }
                });
            }
        })();
    </script>
@endsection
