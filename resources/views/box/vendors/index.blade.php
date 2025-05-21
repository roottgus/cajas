{{-- resources/views/box/vendors/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Vendedores')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    {{-- Banner --}}
    <div class="relative bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-lg p-6 mb-8">
        <img
            src="{{ asset('images/box.png') }}"
            alt="Vendedores"
            class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 h-48 w-auto pointer-events-none"
        />
        <div class="ml-32 lg:ml-40">
            <h1 class="text-3xl font-bold">Gestión de Vendedores</h1>
            <p class="mt-2 opacity-90">Agrega, edita y elimina vendedores con facilidad.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Formulario de creación con Alpine.js --}}
        <div
            x-data="{
                name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
                generar() {
                    let first = (this.name.split(' ')[0] || 'user').toLowerCase();
                    let randNum = Math.floor(1000 + Math.random() * 9000);
                    this.username = first + randNum;
                    this.email = this.username + '@distrimargarita.com';
                    let pw = Math.random().toString(36).slice(-8);
                    this.password = pw;
                    this.password_confirmation = pw;
                }
            }"
            class="lg:col-span-1 bg-white rounded-lg shadow p-6"
        >
            <h2 class="text-xl font-semibold mb-4">Agregar Vendedor</h2>

            <button
                type="button"
                @click="generar()"
                class="mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
            >
                Generar credenciales
            </button>

            <form action="{{ route('box.vendors.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="vendor-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        type="text"
                        name="name"
                        id="vendor-name"
                        x-model="name"
                        class="mt-1 block w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror"
                        required
                    />
                    @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="vendor-email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="vendor-email"
                        x-model="email"
                        autocomplete="email"
                        class="mt-1 block w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror"
                        required
                    />
                    @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="vendor-username" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input
                        type="text"
                        name="username"
                        id="vendor-username"
                        x-model="username"
                        class="mt-1 block w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror"
                        required
                    />
                    @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="vendor-password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input
                        type="password"
                        name="password"
                        id="vendor-password"
                        x-model="password"
                        autocomplete="new-password"
                        class="mt-1 block w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror"
                        required
                    />
                    @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="vendor-password-confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmar Contraseña
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="vendor-password-confirmation"
                        x-model="password_confirmation"
                        autocomplete="new-password"
                        class="mt-1 block w-full border rounded px-3 py-2"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition mt-4"
                >
                    Agregar Vendedor
                </button>
            </form>
        </div>

        {{-- Listado de vendedores existentes --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6 overflow-x-auto">
            <h2 class="text-xl font-semibold mb-4">Vendedores Actuales</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Usuario</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($vendors as $v)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $v->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $v->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $v->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $v->username }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('box.vendors.edit', $v->id) }}"
                                   class="text-blue-600 hover:underline text-sm">Editar</a>
                                <form
                                    method="POST"
                                    action="{{ route('box.vendors.destroy', $v->id) }}"
                                    class="inline-block"
                                    onsubmit="return confirm('¿Está seguro de que desea eliminar al vendedor “{{ addslashes($v->name) }}”? Esta acción no se puede deshacer.');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay vendedores registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
