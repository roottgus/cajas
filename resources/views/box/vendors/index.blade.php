{{-- resources/views/box/vendors/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Gestión de Vendedores')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
  {{-- Banner igual que en dashboard/public --}}
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
    {{-- Formulario de creación --}}
    <div class="lg:col-span-1 bg-white rounded-lg shadow p-6">
      <h2 class="text-xl font-semibold mb-4">Agregar Vendedor</h2>
      <form action="{{ route('box.vendors.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}"
                 class="mt-1 block w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required />
          @error('name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" name="email" id="email" value="{{ old('email') }}"
                 class="mt-1 block w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required />
          @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Usuario</label>
          <input type="text" name="username" id="username" value="{{ old('username') }}"
                 class="mt-1 block w-full border rounded px-3 py-2 @error('username') border-red-500 @enderror" required />
          @error('username')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input type="password" name="password" id="password"
                 class="mt-1 block w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror" required />
          @error('password')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation" id="password_confirmation"
                 class="mt-1 block w-full border rounded px-3 py-2" required />
        </div>

        <button type="submit"
                class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition mt-4">
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
                <!-- Editar Vendedor -->
                <a href="#" class="text-blue-600 hover:underline text-sm">Editar</a>
                <!-- Eliminar Vendedor -->
                <form method="POST" action="{{ route('box.vendors.destroy', $v->id) }}" class="inline" 
                      onsubmit="return confirm('¿Seguro que deseas eliminar este vendedor?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
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
