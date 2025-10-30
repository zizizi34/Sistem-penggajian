<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="font-semibold text-xl text-gray-800">Admin Dashboard</h2>
			<div class="text-sm text-gray-600">Halo, <span class="font-medium">{{ auth()->user()->name ?? 'Admin' }}</span></div>
		</div>
	</x-slot>

	<div class="py-8">
		<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white shadow rounded-lg p-6">
				<h3 class="text-lg font-medium text-gray-900">Departemen Anda</h3>
				<p class="text-sm text-gray-500">Daftar pegawai di departemen Anda. Hanya data departemen Anda yang terlihat.</p>

				<div class="mt-4 flex items-center justify-between">
					<div>
						@if($selectedDept)
							<div class="text-sm text-gray-600">Departemen: <span class="font-medium">{{ $selectedDept->nama_departemen }}</span></div>
						@endif
					</div>
					<div>
						<button id="openAddPegawai" class="px-4 py-2 bg-green-600 text-white rounded">Tambah Pegawai</button>
					</div>
				</div>

				<div class="mt-6">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
								<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
								<th class="px-6 py-3"></th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							@forelse($pegawais as $pegawai)
								<tr>
									<td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->nama_pegawai }}</td>
									<td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->jabatan->nama_jabatan ?? '-' }}</td>
									<td class="px-6 py-4 whitespace-nowrap">{{ $pegawai->tanggal_masuk }}</td>
									<td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($pegawai->gaji_pokok ?? 0, 0, ',', '.') }}</td>
									<td class="px-6 py-4 whitespace-nowrap text-right">
										<a href="#" data-peg="{{ $pegawai->id_pegawai }}" class="btn-atur-jadwal inline-block px-3 py-1 bg-blue-600 text-white rounded text-sm">Atur Jadwal</a>
										<a href="{{ route('pegawai.edit', $pegawai->id_pegawai) }}" class="inline-block px-3 py-1 bg-gray-200 rounded text-sm ml-2">Edit</a>
									</td>
								</tr>
							@empty
								<tr>
									<td class="px-6 py-4" colspan="4">Belum ada pegawai di departemen ini.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

				<!-- Modal: Add Pegawai -->
				<div id="modalAdd" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
					<div class="bg-white rounded-lg p-6 w-full max-w-2xl">
						<div class="flex items-center justify-between">
							<h3 class="text-lg font-medium">Tambah Pegawai</h3>
							<button id="closeAdd" class="text-gray-500">&times;</button>
						</div>

						<!-- Modal: Jadwal (fragment loaded via AJAX) -->
						<div id="modalJadwal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
							<div class="bg-white rounded-lg p-6 w-full max-w-3xl">
								<div class="flex items-center justify-between">
									<h3 class="text-lg font-medium">Atur Jadwal</h3>
									<button id="closeJadwal" class="text-gray-500">&times;</button>
								</div>
								<div class="modal-body mt-4">
									<!-- content injected here -->
								</div>
							</div>
						</div>

						<form method="POST" action="{{ route('pegawai.store') }}" class="mt-4 space-y-3">
							@csrf
							<div class="grid grid-cols-2 gap-3">
								<div>
									<label class="block text-sm">NIK</label>
									<input name="nik_pegawai" required class="mt-1 block w-full border rounded px-3 py-2">
								</div>
								<div>
									<label class="block text-sm">Nama</label>
									<input name="nama_pegawai" required class="mt-1 block w-full border rounded px-3 py-2">
								</div>
							</div>

							<div class="grid grid-cols-3 gap-3">
								<div>
									<label class="block text-sm">Jenis Kelamin</label>
									<select name="jenis_kelamin" class="mt-1 block w-full border rounded px-3 py-2">
										<option value="L">L</option>
										<option value="P">P</option>
									</select>
								</div>
								<div>
									<label class="block text-sm">Tanggal Masuk</label>
									<input type="date" name="tanggal_masuk" class="mt-1 block w-full border rounded px-3 py-2">
								</div>
								<div>
									<label class="block text-sm">Gaji Pokok</label>
									<input name="gaji_pokok" type="number" step="0.01" min="0" max="1000000000" placeholder="0" class="mt-1 block w-full border rounded px-3 py-2">
								</div>
							</div>

							<div class="grid grid-cols-2 gap-3">
								<div>
									<label class="block text-sm">Status</label>
									<select name="status_karyawan" class="mt-1 block w-full border rounded px-3 py-2">
										<option value="tetap">Pegawai Tetap</option>
										<option value="kontrak">Kontrak</option>
										<option value="magang">Magang</option>
									</select>
								</div>
								<div>
									<label class="block text-sm">Jabatan</label>
									<select name="id_jabatan" class="mt-1 block w-full border rounded px-3 py-2">
										<option value="">Pilih jabatan</option>
										@foreach(\App\Models\Jabatan::orderBy('nama_jabatan')->get() as $jab)
											<option value="{{ $jab->id }}">{{ $jab->nama_jabatan }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="mt-4 grid gap-3">
								<div class="flex items-center gap-3">
									<input type="checkbox" id="createAccount" name="create_account" value="1" class="mr-2">
									<label for="createAccount" class="text-sm">Buat akun login untuk pegawai ini</label>
								</div>

								<div id="accountFields" class="hidden grid grid-cols-2 gap-3">
									<div>
										<label class="block text-sm">Email (login)</label>
										<input name="email" type="email" class="mt-1 block w-full border rounded px-3 py-2">
									</div>
									<div>
										<label class="block text-sm">Password</label>
										<input name="password" type="password" class="mt-1 block w-full border rounded px-3 py-2">
									</div>
								</div>

								<div class="flex items-center justify-end">
									<button type="button" id="cancelAdd" class="px-4 py-2 bg-gray-200 rounded mr-2">Batal</button>
									<button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
								</div>
							</div>
						</form>
					</div>
				</div>
		</div>
	</div>
</x-app-layout>

<script>
	(function(){
				const openBtn = document.getElementById('openAddPegawai');
		const modal = document.getElementById('modalAdd');
		const closeBtn = document.getElementById('closeAdd');
		const cancelBtn = document.getElementById('cancelAdd');
		if (!openBtn || !modal) return;
		openBtn.addEventListener('click', function(){ modal.classList.remove('hidden'); modal.classList.add('flex'); });
		if (closeBtn) closeBtn.addEventListener('click', function(){ modal.classList.add('hidden'); modal.classList.remove('flex'); });
		if (cancelBtn) cancelBtn.addEventListener('click', function(){ modal.classList.add('hidden'); modal.classList.remove('flex'); });

				// Toggle account fields when checkbox checked
				const createChk = document.getElementById('createAccount');
				const accountFields = document.getElementById('accountFields');
				if (createChk && accountFields) {
					createChk.addEventListener('change', function(){
						if (createChk.checked) accountFields.classList.remove('hidden'); else accountFields.classList.add('hidden');
					});
				}
			})();
</script>

<script>
	(function(){
		function qs(sel, el) { return (el||document).querySelector(sel); }
		function qsa(sel, el) { return Array.from((el||document).querySelectorAll(sel)); }

		const modal = qs('#modalJadwal');
		const modalBody = modal ? qs('.modal-body', modal) : null;
		const closeJ = qs('#closeJadwal');

		qsa('.btn-atur-jadwal').forEach(btn => {
			btn.addEventListener('click', function(e){
				e.preventDefault();
				const peg = btn.getAttribute('data-peg');
				if (!peg) return;
				// fetch fragment
				fetch(`/pegawai/${peg}/jadwal?ajax=1`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
					.then(r => r.text())
					.then(html => {
						if (!modal || !modalBody) return;
						modalBody.innerHTML = html;
						modal.classList.remove('hidden'); modal.classList.add('flex');
					})
					.catch(err => console.error(err));
			});
		});

		if (closeJ) closeJ.addEventListener('click', function(){ if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); } });
	})();
</script>
