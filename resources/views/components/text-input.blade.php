@props(['disabled' => false])

<?php
	$type = $attributes->get('type') ?? 'text';
	$id = $attributes->get('id') ?? 'x-input-'.uniqid();
?>

@if($type === 'password')
	<div class="relative">
		<input id="{{ $id }}" @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pr-10', 'id' => $id]) }}>

		<button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500" data-toggle-target="#{{ $id }}" aria-label="Tampilkan kata sandi">
			<!-- Eye open (Heroicons: eye) -->
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 10C3.732 6.943 6.522 5 10 5s6.268 1.943 7.542 5c-1.274 3.057-4.064 5-7.542 5S3.732 13.057 2.458 10z" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M10 13a3 3 0 100-6 3 3 0 000 6z" />
			</svg>
			<!-- Eye closed (Heroicons: eye-off) - hidden by default -->
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M9.88 9.88A3 3 0 0114.12 14.12" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M6.21 6.21A9.01 9.01 0 0112 4c4.478 0 8.268 1.943 9.542 5-.37.887-.92 1.708-1.63 2.405" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M14.12 9.88L20.82 3.18" />
			</svg>
		</button>
	</div>

	<script>
		if (!window.__passwordToggleInstalled) {
			window.__passwordToggleInstalled = true;
			document.addEventListener('click', function (e) {
				var btn = e.target.closest('[data-toggle-target]');
				if (!btn) return;
				var selector = btn.getAttribute('data-toggle-target');
				var input = document.querySelector(selector);
				if (!input) return;
				if (input.type === 'password') {
					input.type = 'text';
					var open = btn.querySelector('.eye-open');
					var closed = btn.querySelector('.eye-closed');
					if (open) open.classList.add('hidden');
					if (closed) closed.classList.remove('hidden');
				} else {
					input.type = 'password';
					var open = btn.querySelector('.eye-open');
					var closed = btn.querySelector('.eye-closed');
					if (open) open.classList.remove('hidden');
					if (closed) closed.classList.add('hidden');
				}
			});
		}
	</script>
@else

	<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-gray-300 bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}>

@endif
