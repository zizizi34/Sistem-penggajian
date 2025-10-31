@extends('layouts.app')

@section('content')
<div class="py-8">
	<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
			<div class="bg-white shadow rounded-lg p-4 text-center">
				<div class="text-sm text-gray-500">Hadir</div>
				<div class="text-2xl font-bold text-green-600">{{ $totals['Hadir'] ?? 0 }}</div>
			</div>
			<div class="bg-white shadow rounded-lg p-4 text-center">
				<div class="text-sm text-gray-500">Izin</div>
				<div class="text-2xl font-bold text-yellow-600">{{ $totals['Izin'] ?? 0 }}</div>
			</div>
			<div class="bg-white shadow rounded-lg p-4 text-center">
				<div class="text-sm text-gray-500">Tidak Hadir</div>
				<div class="text-2xl font-bold text-red-600">{{ $totals['Tidak Hadir'] ?? 0 }}</div>
			</div>
		</div>

		<div class="mt-6 bg-white shadow rounded-lg p-6">
			<h2 class="text-lg font-semibold">Absensi Online (Log)</h2>
			<p class="text-sm text-gray-500">Gunakan form ini untuk mencatat masuk/keluar secara online. Kolom "Log" boleh berisi lokasi atau catatan.</p>

			<form method="POST" action="{{ route('absensi.store') }}" class="mt-4 space-y-3">
				@csrf
				<div class="flex gap-3 items-start">
					<select name="jenis" class="border rounded px-3 py-2">
						<option value="masuk">Masuk</option>
						<option value="keluar">Keluar</option>
					</select>
					<input name="keterangan" placeholder="Log (lokasi, catatan)" class="border rounded px-3 py-2 flex-1">
					<button class="px-4 py-2 bg-indigo-600 text-white rounded">Catat</button>
				</div>
			</form>
		</div>

		<div class="mt-6 bg-white shadow rounded-lg p-6">
			<h2 class="text-lg font-semibold">Riwayat & Rekap 14 Hari</h2>
			<p class="text-sm text-gray-500">Daftar per-hari: jam masuk, jam pulang dan status.</p>

			<div class="mt-4">
				<ul class="divide-y divide-gray-100">
					@foreach($summary as $day)
						<li class="py-3 flex items-center justify-between">
							<div>
								<div class="font-medium">{{ $day['pretty'] }}</div>
								<div class="text-sm text-gray-500">
									@if($day['masuk']) Masuk: {{ $day['masuk'] }} @endif
									@if($day['keluar']) &middot; Pulang: {{ $day['keluar'] }} @endif
								</div>
								@if($day['records']->count())
									<div class="mt-2 text-sm">
										@foreach($day['records'] as $r)
											<div class="text-xs text-gray-600">[{{ \Illuminate\Support\Carbon::parse($r->waktu)->format('H:i') }}] {{ ucfirst($r->jenis) }} @if($r->keterangan) - {{ $r->keterangan }} @endif</div>
										@endforeach
									</div>
								@endif
							</div>

							<div class="text-center">
								@if($day['status'] === 'Hadir')
									<span class="px-3 py-1 rounded text-sm bg-green-100 text-green-800">Hadir</span>
								@elseif($day['status'] === 'Izin')
									<span class="px-3 py-1 rounded text-sm bg-yellow-100 text-yellow-800">Izin</span>
								@else
									<span class="px-3 py-1 rounded text-sm bg-red-100 text-red-800">Tidak Hadir</span>
								@endif
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
