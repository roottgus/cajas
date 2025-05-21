{{-- resources/views/box/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div
    x-data="adminStats"
    x-init="init"
    class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8"
>
    {{-- Modal de Bienvenida --}}
    <div
        x-show="showGreetingModal"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
            <div class="flex justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5.121 17.804A2 2 0 017 16h10a2 2 0 011.879 1.276M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold mb-2">¡Hola, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-600">Bienvenido a tu dashboard administrativo.</p>
            <button
                @click="showGreetingModal = false; localStorage.setItem('greetingShown','true');"
                class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
            >
                Entendido
            </button>
        </div>
    </div>

    {{-- Banner --}}
    <div class="relative bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-lg p-6 mb-8">
        <img
            src="{{ asset('images/box.png') }}"
            alt="Cajas"
            class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 h-48 w-auto pointer-events-none"
        />
        <div class="ml-32 lg:ml-40">
            <h1 class="text-3xl font-bold">Dashboard Administrativo</h1>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Sidebar de Vendedores --}}
        <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow p-4">
            <h3 class="text-lg font-semibold mb-4">Vendedores</h3>
            <ul class="space-y-2">
                @foreach($vendors as $v)
                    <li class="flex justify-between items-center">
                        <button
                            @click="load({{ $v->id }})"
                            :class="{ 'bg-gray-100': selectedVendor === {{ $v->id }} }"
                            class="flex-1 flex items-center space-x-2 p-2 rounded hover:bg-gray-100 transition"
                        >
                            <img src="{{ asset('img/avatar.png') }}" class="h-8 w-8 rounded-full" />
                            <span>{{ $v->name }}</span>
                        </button>
                        @if(auth()->check() && auth()->user()->is_admin)
                            <button
                                @click.prevent="vendorToDelete = {{ $v->id }}; showDeleteVendorModal = true"
                                class="ml-2 inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Eliminar
                            </button>
                        @endif
                    </li>
                @endforeach
            </ul>

            @if(auth()->check() && auth()->user()->is_admin)
                <a
                    href="{{ route('box.vendors.index') }}"
                    class="mt-6 inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Agrega-Edita Vendedores
                </a>
            @endif
        </aside>

        <div class="flex-1 flex flex-col">
            {{-- Modales de Confirmación --}}
            <div
                x-show="showDeleteVendorModal"
                x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            >
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
                    <p class="text-gray-600 mb-4">Se eliminará permanentemente al vendedor.</p>
                    <div class="flex justify-center space-x-4">
                        <button
                            @click="showDeleteVendorModal = false"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                        >
                            Cancelar
                        </button>
                        <button
                            @click="fetch(`/box/vendors/${vendorToDelete}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                credentials: 'same-origin'
                            }).then(res => res.ok && location.reload())"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>

            <div
                x-show="showDeleteTransactionModal"
                x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            >
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
                    <p class="text-gray-600 mb-4">Se eliminará permanentemente la transacción seleccionada.</p>
                    <div class="flex justify-center space-x-4">
                        <button
                            @click="showDeleteTransactionModal = false"
                            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                        >
                            Cancelar
                        </button>
                        <button
                            @click="fetch(`/box/transaction/${transactionToDelete}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }).then(() => {
                                showDeleteTransactionModal = false;
                                load(selectedVendor);
                            })"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>

            {{-- Panel principal --}}
            <main class="flex-1 bg-gray-50 rounded-lg shadow p-8 space-y-6">
                {{-- Estadísticas --}}
                @include('box.dashboard.partials.stats')

                {{-- Filtros --}}
                @include('box.dashboard.partials.filters')

                {{-- Tabla de transacciones --}}
                @include('box.dashboard.partials.transactions-table')
            </main>
        </div>
    </div>
</div>
@endsection
