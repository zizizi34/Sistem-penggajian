<div>
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold">Jadwal: {{ $pegawai->nama_pegawai }}</h2>
    </div>

    <form id="formTambahJadwal" method="POST" action="{{ route('jadwal.store', $pegawai->id_pegawai) }}" class="mt-2 grid grid-cols-4 gap-3">
        @csrf
        <div>
            <label class="block text-sm">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" required class="mt-1 block w-full border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="mt-1 block w-full border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="mt-1 block w-full border rounded px-2 py-1">
        </div>
        <div class="flex items-end">
            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded">Tambah</button>
        </div>
    </form>

    <div class="mt-4">
        <ul class="divide-y divide-gray-200" id="jadwalList">
            @forelse($jadwals as $jadwal)
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $jadwal->tanggal_mulai }} @if($jadwal->tanggal_selesai) - {{ $jadwal->tanggal_selesai }}@endif</div>
                        <div class="text-sm text-gray-500">{{ $jadwal->jam_mulai ?? '-' }} - {{ $jadwal->jam_selesai ?? '-' }} | {{ $jadwal->keterangan }}</div>
                    </div>
                    <div>
                        <form class="formDeleteJadwal" method="POST" action="{{ route('jadwal.destroy', ['id' => $pegawai->id_pegawai, 'jadwal' => $jadwal->id]) }}" onsubmit="return confirm('Hapus jadwal?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="py-3 text-sm text-gray-500">Belum ada jadwal.</li>
            @endforelse
        </ul>
    </div>
</div>

<script>
    (function(){
        const modal = document.getElementById('modalJadwal');
        const body = modal ? modal.querySelector('.modal-body') : null;

        if (!body) return;

        // Intercept form submit for adding jadwal (AJAX)
        body.addEventListener('submit', function(e){
            const form = e.target;
            if (form.id !== 'formTambahJadwal') return;
            e.preventDefault();
            const action = form.action;
            const data = new FormData(form);
            fetch(action, { method: 'POST', body: data, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.text())
                .then(()=> {
                    // refresh fragment
                    const pegId = '{{ $pegawai->id_pegawai }}';
                    fetch(`{{ url('') }}/pegawai/${pegId}/jadwal?ajax=1`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(r => r.text()).then(html => { body.innerHTML = html; });
                })
                .catch(err => console.error(err));
        });

        // Delegate delete form clicks
        body.addEventListener('submit', function(e){
            const form = e.target;
            if (!form.classList.contains('formDeleteJadwal')) return;
            e.preventDefault();
            if (!confirm('Hapus jadwal?')) return;
            const action = form.action;
            const data = new FormData(form);
            data.append('_method', 'DELETE');
            fetch(action, { method: 'POST', body: data, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(()=> {
                    const pegId = '{{ $pegawai->id_pegawai }}';
                    fetch(`{{ url('') }}/pegawai/${pegId}/jadwal?ajax=1`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(r => r.text()).then(html => { body.innerHTML = html; });
                })
                .catch(err => console.error(err));
        });
    })();
</script>
