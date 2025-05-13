{{-- resources/views/box/vendor-dashboard.blade.php --}}
@extends('layouts.app')

@section('title', "Dashboard de Cajas - {$vendor->name}")

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
  {{-- Banner de bienvenida --}}
<div class="bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-xl p-8 mb-10">
  <h1 class="text-4xl font-bold tracking-wide drop-shadow-md">Bienvenido, {{ $vendor->name }}</h1>
  <p class="mt-3 text-lg opacity-90">Gestiona y revisa tus reportes de cajas de manera profesional.</p>
</div>


  <div class="flex h-full">
    {{-- Sidebar: Lista de Vendedores --}}
    <aside class="w-64 bg-white rounded-lg shadow p-4 border border-gray-200">
  <h2 class="text-lg font-semibold mb-4 tracking-wide">Vendedores</h2>
  <ul>
    @foreach($allVendors as $v)
      <li>
        <a href="{{ route('box.vendor', $v->id) }}"
           class="flex items-center p-2 rounded-lg mb-1 transition
                  {{ $vendor->id === $v->id 
                      ? 'border-l-4 border-red-600 bg-red-50' 
                      : 'hover:bg-gray-50' }}">
          <img src="{{ asset('images/vendors/' . ($v->avatar ?? 'default.png')) }}"
               alt="{{ $v->name }}"
               class="h-8 w-8 rounded-full mr-3 object-cover" />
          <span class="font-medium text-gray-700">{{ $v->name }}</span>
        </a>
      </li>
    @endforeach
  </ul>
</aside>


    {{-- Contenido Principal --}}
    <div class="flex-1 p-8 space-y-8">
      {{-- Tarjetas de Ingreso / Salida / Pendientes --}}
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        {{-- Ingreso de Cajas --}}
        <div @click="window.dispatchEvent(new CustomEvent('open-report-modal', { detail: ['return', {{ $vendor->id }}] }))"
             class="bg-white rounded-2xl shadow-lg p-6 cursor-pointer hover:shadow-2xl transition">
          <div class="flex items-center">
            <svg class="h-8 w-8 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 12h16M4 6h16M4 18h16" />
            </svg>
            <h3 class="text-xl font-semibold">Ingreso de Cajas</h3>
          </div>
          <p class="mt-4 text-4xl font-bold text-blue-600">{{ $returned }}</p>
          <p class="text-sm text-gray-500">Total ingresos</p>
        </div>

        {{-- Salida de Cajas --}}
        <div @click="window.dispatchEvent(new CustomEvent('open-report-modal', { detail: ['issue', {{ $vendor->id }}] }))"
             class="bg-white rounded-2xl shadow-lg p-6 cursor-pointer hover:shadow-2xl transition">
          <div class="flex items-center">
            <svg class="h-8 w-8 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 12H4M20 6H4M20 18H4" />
            </svg>
            <h3 class="text-xl font-semibold">Salida de Cajas</h3>
          </div>
          <p class="mt-4 text-4xl font-bold text-green-600">{{ $issued }}</p>
          <p class="text-sm text-gray-500">Total salidas</p>
        </div>

        {{-- Cajas Pendientes --}}
        <div class="bg-white rounded-2xl shadow-lg p-6">
          <div class="flex items-center">
            <svg class="h-8 w-8 text-yellow-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3" />
            </svg>
            <h3 class="text-xl font-semibold">Cajas Pendientes</h3>
          </div>
          <p class="mt-4 text-4xl font-bold text-yellow-600">{{ $pending }}</p>
          <p class="text-sm text-gray-500">Por devolver</p>
        </div>
      </div>

      {{-- Control de Cajas: Historial --}}
      <section>
  <h2 class="text-2xl font-semibold mb-4 tracking-wide">Control de Cajas</h2>
  <div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-100 sticky top-0">
        <tr>
          @foreach(['fecha','tipo','cantidad','notas'] as $col)
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              {{ ucfirst($col) }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @foreach($history as $tx)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
              {{ $tx->created_at->format('d/m/Y H:i') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm 
                       {{ $tx->type=='issue'?'text-red-600':'text-green-600' }}">
              {{ $tx->type=='issue' ? 'Salida' : 'Ingreso' }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
              {{ $tx->quantity }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
              {{ $tx->notes ?? '-' }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</section>

    </div>
  </div>
</div>

{{-- Componente Livewire para el modal --}}
<livewire:box-modal />
@endsection
