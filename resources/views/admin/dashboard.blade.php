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
				<h3 class="text-lg font-medium text-gray-900">Pilih Departemen</h3>
				<p class="text-sm text-gray-500">Pilih departemen yang Anda kelola untuk melihat statistik khusus.</p>

				<form method="get" action="{{ route('admin.dashboard') }}" class="mt-4 flex gap-2">
					<select name="dept" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
						<option value="">-- Pilih Departemen --</option>
						@foreach($departments as $dep)
							<option value="{{ $dep->id }}" {{ (string)($selectedDept ?? '') === (string)$dep->id ? 'selected' : '' }}>{{ $dep->nama_departemen }}</option>
						@endforeach
					</select>
					<button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Tampilkan</button>
				</form>

				<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
					<div class="bg-gray-50 rounded p-4">
						<div class="text-sm text-gray-500">Pegawai di Departemen</div>
						<div class="text-2xl font-semibold text-gray-900">{{ $totalPegawai ?? 0 }}</div>
					</div>
					<div class="bg-gray-50 rounded p-4">
						<div class="text-sm text-gray-500">Penggajian Terkait</div>
						<div class="text-2xl font-semibold text-gray-900">{{ $totalPenggajian ?? 0 }}</div>
					</div>
				</div>

				<div class="mt-6 text-sm text-gray-600">
					<p>Catatan: Super Admin memiliki akses penuh ke semua departemen. Admin biasa hanya melihat data berdasarkan departemen yang dipilih di sini.</p>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
