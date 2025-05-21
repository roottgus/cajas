{{-- resources/views/box/vendors/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Vendedor')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-white rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-6">Editar Vendedor</h2>
    <form action="{{ route('box.vendors.update', $vendor->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="vendor-name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input
                type="text"
                id="vendor-name"
                name="name"
                value="{{ old('name', $vendor->name) }}"
                autocomplete="name"
                required
                class="mt-1 block w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror"
            />
            @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="vendor-email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                id="vendor-email"
                name="email"
                value="{{ old('email', $vendor->email) }}"
                autocomplete="email"
                required
                class="mt-1 block w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror"
            />
            @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="vendor-username" class="block text-sm font-medium text-gray-700">Usuario</label>
            <input
                type="text"
                id="vendor-username"
                name="username"
                value="{{ old('username', $vendor->username) }}"
                autocomplete="username"
                required
                class="mt-1 block w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror"
            />
            @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="vendor-password" class="block text-sm font-medium text-gray-700">Contraseña <span class="font-normal">(opcional)</span></label>
            <input
                type="password"
                id="vendor-password"
                name="password"
                autocomplete="new-password"
                class="mt-1 block w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror"
            />
            @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="vendor-password-confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
            <input
                type="password"
                id="vendor-password-confirmation"
                name="password_confirmation"
                autocomplete="new-password"
                class="mt-1 block w-full border rounded px-3 py-2"
            />
        </div>

        <div class="flex justify-end space-x-2">
            <a
                href="{{ route('box.vendors.index') }}"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
            >
                Cancelar
            </a>
            <button
                type="submit"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            >
                Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
