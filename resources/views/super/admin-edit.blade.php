@extends('layouts.dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800">Edit Admin</h2>
@endsection

@section('content')
    <div class="py-2">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('super.admin-detail.update', $admin->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $admin->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email', $admin->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="id_departemen" :value="__('Departemen')" />
                        <x-select-input id="id_departemen" name="id_departemen" class="block mt-1 w-full">
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('id_departemen', $admin->id_departemen) == $dept->id ? 'selected' : '' }}>{{ $dept->nama_departemen }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('id_departemen')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                        <a href="{{ route('super.admin-detail.show', $admin->id_departemen ?? 1) }}" class="px-4 py-2 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
