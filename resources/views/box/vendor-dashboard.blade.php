{{-- resources/views/box/vendor-dashboard.blade.php --}}
@extends('layouts.app')

@section('title', "Dashboard de Cajas - {$vendor->name}")

@section('content')
<div class="max-w-7xl mx-auto py-4 px-2 sm:px-6 lg:px-8 space-y-6">
  {{-- Banner de bienvenida --}}
  <div class="bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-xl p-4 sm:p-6">
    <h1 class="text-2xl sm:text-4xl font-bold tracking-wide">Bienvenido, {{ $vendor->name }}</h1>
    <p class="mt-2 text-sm sm:text-lg opacity-90">Gestiona y revisa tus reportes de cajas de manera profesional.</p>
  </div>

  {{-- Botón volver --}}
  <div>
    <a href="{{ route('box.public') }}"
       class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      <span class="text-sm sm:text-base">Volver al Reporte Público</span>
    </a>
  </div>

  {{-- Layout: sidebar + contenido --}}
  <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
    {{-- Sidebar: Lista de Vendedores SOLO desktop --}}
    <aside class="hidden md:block md:w-64 bg-white rounded-lg shadow p-4 border border-gray-200">
      <h2 class="text-lg font-semibold mb-4 tracking-wide">Vendedores</h2>
      <ul>
        @foreach($allVendors as $v)
          <li>
            <a href="{{ route('box.vendor', $v->id) }}"
               class="flex items-center p-2 rounded-lg mb-1 transition {{ $vendor->id === $v->id ? 'border-l-4 border-red-600 bg-red-50' : 'hover:bg-gray-50' }}">
              <img src="{{ asset('images/vendors/' . ($v->avatar ?? 'default.png')) }}"
                   alt="{{ $v->name }}"
                   class="h-8 w-8 rounded-full mr-3 object-cover" />
              <span class="font-medium text-gray-700 text-sm sm:text-base">{{ $v->name }}</span>
            </a>
          </li>
        @endforeach
      </ul>
    </aside>

    {{-- Contenido Principal --}}
    <div class="flex-1 space-y-6">
      {{-- Estadísticas: tarjetas responsive --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        {{-- Entrega de Cajas --}}
        <div @click="window.dispatchEvent(new CustomEvent('open-report-modal', { detail: ['issue', {{ $vendor->id }}] }))"
             class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 cursor-pointer hover:shadow-2xl transition">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('images/entrega.png') }}" alt="Entrega de Cajas" class="h-6 w-6 sm:h-8 sm:w-8">
            <h3 class="text-lg sm:text-xl font-semibold">Entrega de Cajas</h3>
          </div>
          <p class="mt-3 text-2xl sm:text-4xl font-bold text-red-600">{{ $issued }}</p>
          <p class="text-xs sm:text-sm text-gray-500">Cajas Entregadas</p>
        </div>

        {{-- Recibido de Cajas --}}
        <div @click="window.dispatchEvent(new CustomEvent('open-report-modal', { detail: ['return', {{ $vendor->id }}] }))"
             class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 cursor-pointer hover:shadow-2xl transition">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('images/recibido.png') }}" alt="Recibido de Cajas" class="h-6 w-6 sm:h-8 sm:w-8">
            <h3 class="text-lg sm:text-xl font-semibold">Recibido de Cajas</h3>
          </div>
          <p class="mt-3 text-2xl sm:text-4xl font-bold text-green-600">{{ $returned }}</p>
          <p class="text-xs sm:text-sm text-gray-500">Cajas Recibidas</p>
        </div>

        {{-- Cajas Pendientes --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6">
          <div class="flex items-center space-x-3">
            <img src="{{ asset('images/pendiente.png') }}" alt="Cajas Pendientes" class="h-6 w-6 sm:h-8 sm:w-8">
            <h3 class="text-lg sm:text-xl font-semibold">Cajas Pendientes</h3>
          </div>
          <p class="mt-3 text-2xl sm:text-4xl font-bold text-yellow-600">{{ $pending }}</p>
          <p class="text-xs sm:text-sm text-gray-500">Por devolver</p>
        </div>
      </div>

      {{-- Control de Cajas: Historial --}}
      <section class="space-y-4">
        <h2 class="text-xl sm:text-2xl font-semibold tracking-wide">Control de Cajas</h2>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 sticky top-0">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($history as $tx)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-4 py-2 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $tx->created_at->format('d/m/Y H:i') }}</td>
                  <td class="px-4 py-2 whitespace-nowrap text-xs sm:text-sm {{ $tx->type==='issue'?'text-red-600':'text-green-600' }}">{{ $tx->type==='issue'?'ENTREGA DE CAJAS':'RECIBIDO DE CAJAS' }}</td>
                  <td class="px-4 py-2 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $tx->quantity }}</td>
                  <td class="px-4 py-2 whitespace-nowrap text-xs sm:text-sm text-gray-700">{{ $tx->notes ?? '-' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>

      {{-- Livewire Modal --}}
      <livewire:box-modal />
    </div> {{-- fin contenido principal --}}
  </div>
</div>

@endsection
