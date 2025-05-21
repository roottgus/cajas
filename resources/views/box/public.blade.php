{{-- resources/views/box/public.blade.php --}}
@extends('layouts.app')

@section('title', 'Reportes de Cajas')

@section('content')
<div
  x-data="{ selectedVendorId: null, selectedVendorName: '', showAdminOnlyModal: false }"
  class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8"
>
  {{-- Banner --}}
  <div class="relative bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-lg p-6 mb-8">
    <img
      src="{{ asset('images/box.png') }}"
      alt="Cajas"
      class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 h-48 w-auto pointer-events-none"
    />
    <div class="ml-32 lg:ml-40">
      <h1 class="text-3xl font-bold">Reportes de Cajas</h1>
      <p class="mt-2 opacity-90">Selecciona tu nombre antes de reportar.</p>
    </div>
  </div>

  <div class="mt-16 flex flex-col lg:flex-row gap-6">
    {{-- Sidebar Vendedores --}}
    <aside class="lg:w-1/4 bg-white rounded-lg shadow p-4">
      <h3 class="text-lg font-semibold mb-4">Vendedores</h3>
      <ul class="space-y-2">
        @foreach($vendors as $v)
          <li
            data-name="{{ $v->name }}"
            @click="
              selectedVendorId = {{ $v->id }};
              selectedVendorName = $el.dataset.name
            "
            :class="selectedVendorId === {{ $v->id }}
              ? 'bg-gray-100 cursor-pointer'
              : 'cursor-pointer'"
            class="flex items-center justify-between p-2 rounded transition"
          >
            <div class="flex items-center">
              <img
                src="{{ asset('img/avatar.png') }}"
                alt="Avatar de {{ $v->name }}"
                class="h-8 w-8 rounded-full mr-2"
              />
              <span class="font-medium text-gray-700">{{ $v->name }}</span>
            </div>

            {{-- Botón Ver Reporte --}}
            <a
              href="{{ route('box.vendor', $v->id) }}"
              class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition"
              @click.stop
            >
              Ver Reporte
            </a>
          </li>
        @endforeach
      </ul>

      {{-- Botón Agregar Nuevo Vendedor / AdminOnly --}}
      @auth
        <a
          href="{{ route('box.vendors.index') }}"
          class="mt-6 block text-center bg-red-600 text-white py-2 rounded hover:bg-red-700 transition"
        >
          Agregar Nuevo Vendedor
        </a>
      @else
        <button
          @click="showAdminOnlyModal = true"
          class="mt-6 block w-full text-center bg-red-600 text-white py-2 rounded hover:bg-red-700 transition"
        >
          Agregar Nuevo Vendedor
        </button>
      @endauth
    </aside>

    {{-- Área Principal --}}
<main class="flex-1 bg-gray-50 rounded-lg shadow p-8">
  {{-- Saludo --}}
  <div 
    x-show="selectedVendorId"
    x-cloak
    class="text-center mb-6 leading-relaxed"
  >
    <p class="text-xl font-semibold text-gray-800">
      Buen día, <strong x-text="selectedVendorName"></strong>.
    </p>
    <p class="text-lg text-gray-700">Seleccione la acción a realizar:</p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <!-- Botón Registrar entrega -->
    <button
      @click="
        window.dispatchEvent(new CustomEvent('open-report-modal', {
          detail: ['issue', selectedVendorId]
        }))
      "
      :disabled="!selectedVendorId"
      :class="selectedVendorId
        ? 'hover:shadow-xl bg-white'
        : 'opacity-50 cursor-not-allowed bg-gray-200'"
      class="rounded-lg shadow p-8 flex flex-col items-center transition"
    >
      <img src="{{ asset('images/entrega1.png') }}"
           class="w-24 h-24 mb-4"
           alt="Registrar entrega" />
      <span class="text-lg font-semibold">
        Registrar Entrega De Cajas Al Depósito
      </span>
    </button>

    <!-- Botón Registrar recepción -->
    <button
      @click="
        window.dispatchEvent(new CustomEvent('open-report-modal', {
          detail: ['return', selectedVendorId]
        }))
      "
      :disabled="!selectedVendorId"
      :class="selectedVendorId
        ? 'hover:shadow-xl bg-white'
        : 'opacity-50 cursor-not-allowed bg-gray-200'"
      class="rounded-lg shadow p-8 flex flex-col items-center transition"
    >
      <img src="{{ asset('images/recibido1.png') }}"
           class="w-24 h-24 mb-4"
           alt="Registrar recepción" />
      <span class="text-lg font-semibold">
        Registrar Recibido De Cajas Del Depósito
      </span>
    </button>
  </div>
</main>

{{-- Livewire Modal --}}
<livewire:box-modal />


  {{-- Modal sólo Admin --}}
  <div
    x-show="showAdminOnlyModal"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
  >
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
      <h3 class="text-xl font-semibold mb-4">Acceso denegado</h3>
      <p class="mb-6">Esta función solo está disponible para administradores.</p>
      <button
        @click="showAdminOnlyModal = false"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
      >
        Entendido
      </button>
    </div>
  </div>
</div>
@endsection
