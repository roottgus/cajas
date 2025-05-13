{{-- resources/views/box/dashboard.blade.php --}}
@extends('layouts.app')

@section('title','Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8"
     x-data="{ 
   ...adminStats(),
   showGreetingModal: !localStorage.getItem('greetingShown'),
   /* — filtros — */
   fromDate: '',        // Fecha inicio
   toDate: '',          // Fecha fin
   filterVendor: '',    // ID vendedor
   filterType: '',      // issue/return/pending
   searchNotes: '',     // texto en notas
   showDeleteVendorModal: false,
   vendorToDelete: null,
   showDeleteTransactionModal: false,
   transactionToDelete: null
 }"
     x-init="
       load(null);
       if (!localStorage.getItem('greetingShown')) {
         setTimeout(() => {
           showGreetingModal = false;
           localStorage.setItem('greetingShown','true');
         }, 5000);
       } else {
         showGreetingModal = false;
       }
     "
>
  <!-- Modal de Bienvenida -->
  <div x-show="showGreetingModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
      <div class="flex justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A2 2 0 017 16h10a2 2 0 011.879 1.276M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <h2 class="text-xl font-semibold mb-2">¡Hola, {{ Auth::user()->name }}!</h2>
      <p class="text-gray-600">Bienvenido a tu dashboard administrativo.</p>
      <button @click="showGreetingModal = false; localStorage.setItem('greetingShown','true');"
              class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Entendido
      </button>
    </div>
  </div>

  <!-- Banner -->
  <div class="relative bg-gradient-to-r from-red-600 to-red-800 text-white rounded-lg shadow-lg p-6 mb-8">
    <img src="{{ asset('images/box.png') }}"
         alt="Cajas"
         class="absolute top-1/2 left-0 -translate-y-1/2 -translate-x-1/4 h-48 w-auto pointer-events-none" />
    <div class="ml-56">
      <h1 class="text-3xl font-bold">Dashboard Administrativo</h1>
      <p class="mt-2 opacity-90">Visualiza y gestiona estadísticas y reportes.</p>
    </div>
  </div>

    <div class="flex flex-col lg:flex-row gap-6">
    <!-- Sidebar -->
    <aside class="w-full lg:w-1/4 bg-white rounded-lg shadow p-4">
      <h3 class="text-lg font-semibold mb-4">Vendedores</h3>
      <ul class="space-y-2">
        @foreach($vendors as $v)
        <li class="flex justify-between items-center">
          <button @click="load({{ $v->id }})"
                  :class="{'bg-gray-100': selectedVendor=={{ $v->id }}}"
                  class="flex-1 flex items-center space-x-2 p-2 rounded hover:bg-gray-100 transition">
            <img src="{{ asset('img/avatar.png') }}" class="h-8 w-8 rounded-full" />
            <span>{{ $v->name }}</span>
          </button>
          @if(auth()->check() && auth()->user()->is_admin)
          <button @click.prevent="vendorToDelete={{ $v->id }}; showDeleteVendorModal=true"
                  class="ml-2 inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition">
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
      <a href="{{ route('box.vendors.index') }}"
         class="mt-6 inline-flex items-center justify-center w-full px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Agregar Nuevo Vendedor
      </a>
      @endif
    </aside>


    <!-- Modal Confirmación Borrar Vendedor -->
    <div x-show="showDeleteVendorModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
        <p class="text-gray-600 mb-4">Se eliminará permanentemente al vendedor.</p>
        <div class="flex justify-center space-x-4">
          <button @click="showDeleteVendorModal = false"
                  class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancelar
          </button>
          <button @click="fetch(`/box/vendors/${vendorToDelete}`, {
                             method: 'DELETE',
                             headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                           }).then(() => location.reload())"
                  class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Eliminar
          </button>
        </div>
      </div>
    </div>

    <!-- Modal Confirmación Borrar Transacción -->
    <div x-show="showDeleteTransactionModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
        <div class="flex justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
        <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
        <p class="text-gray-600 mb-4">Se eliminará permanentemente la transacción seleccionada.</p>
        <div class="flex justify-center space-x-4">
          <button @click="showDeleteTransactionModal = false"
                  class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancelar
          </button>
          <button @click="fetch(`/box/transaction/${transactionToDelete}`, {
                             method: 'DELETE',
                             headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                           }).then(() => {
                             showDeleteTransactionModal = false;
                             load(selectedVendor);
                           })"
                  class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Eliminar
          </button>
        </div>
      </div>
    </div>

        <!-- Panel principal -->
    <main class="flex-1 bg-gray-50 rounded-lg shadow p-8 space-y-6">
      
      <!-- Estadísticas -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
        <template x-for="(label,key) in ['Salidas','Ingresos','Pendientes']" :key="key">
          <div class="relative bg-white rounded-lg shadow p-6 overflow-hidden">
            <div class="absolute top-4 right-4 opacity-10 h-16 w-16">
              <template x-if="key===0">
                <!-- Flecha abajo -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 13l-4 4m0 0l-4-4m4 4V7" />
                </svg>
              </template>
              <template x-if="key===1">
                <!-- Flecha arriba -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 11l4-4m0 0l4 4m-4-4v10" />
                </svg>
              </template>
              <template x-if="key===2">
                <!-- Reloj -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0
                           9 9 0 0118 0z" />
                </svg>
              </template>
              
            </div>
            <div class="relative z-10">
              <h2 class="text-lg font-medium text-gray-700">Total <span x-text="label"></span></h2>
              <p class="mt-2 text-3xl font-bold"
                 :class="{'text-red-600':key===0,'text-green-600':key===1,'text-gray-800':key===2}"
                 x-text="stats[key===0?'issued':key===1?'returned':'pending']">
              </p>
            </div>
          </div>
        </template>
      </div>
        {{-- FILTROS --}}
<div class="bg-white rounded-lg shadow p-4 mb-4 border-t-4 border-red-600">
  <div class="flex items-center mb-3">
    <span class="inline-block bg-red-600 text-white text-xs font-semibold uppercase px-2 py-1 rounded mr-2">
      Filtros
    </span>
    <h4 class="text-sm font-semibold text-gray-800">de Historial</h4>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
    <!-- Desde -->
    <div>
      <label class="block text-xs text-gray-600 mb-1">Desde</label>
      <input
        type="date"
        x-model="fromDate"
        class="w-full text-sm border border-gray-300 rounded focus:border-red-600 hover:border-red-200 transition"
        style="padding: .375rem .5rem; height:2rem;"
      />
    </div>

    <!-- Hasta -->
    <div>
      <label class="block text-xs text-gray-600 mb-1">Hasta</label>
      <input
        type="date"
        x-model="toDate"
        class="w-full text-sm border border-gray-300 rounded focus:border-red-600 hover:border-red-200 transition"
        style="padding: .375rem .5rem; height:2rem;"
      />
    </div>

    <!-- Vendedor -->
    <div>
      <label class="block text-xs text-gray-600 mb-1">Vendedor</label>
      <select
        x-model="filterVendor"
        class="w-full text-sm border border-gray-300 rounded focus:border-red-600 hover:border-red-200 transition"
        style="padding: .375rem .5rem; height:2rem;"
      >
        <option value="">Todos</option>
        @foreach($vendors as $v)
          <option value="{{ $v->id }}">{{ $v->name }}</option>
        @endforeach
      </select>
    </div>

    <!-- Tipo -->
    <div>
      <label class="block text-xs text-gray-600 mb-1">Tipo</label>
      <select
        x-model="filterType"
        class="w-full text-sm border border-gray-300 rounded focus:border-red-600 hover:border-red-200 transition"
        style="padding: .375rem .5rem; height:2rem;"
      >
        <option value="">Todos</option>
        <option value="issue">Salida</option>
        <option value="return">Ingreso</option>
        <option value="pending">Pendiente</option>
      </select>
    </div>

    <!-- Buscar notas -->
    <div class="sm:col-span-2 lg:col-span-4 flex">
      <div class="flex-1">
        <label class="block text-xs text-gray-600 mb-1">Buscar notas</label>
        <input
          type="text"
          x-model="searchNotes"
          placeholder="Texto libre..."
          class="w-full text-sm border border-gray-300 rounded-l focus:border-red-600 hover:border-red-200 transition"
          style="padding: .375rem .5rem; height:2rem;"
        />
      </div>
      <button
        @click="load(selectedVendor)"
        class="ml-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-r shadow px-4 transition"
        style="height:2rem;"
      >
        Filtrar
      </button>
    </div>
  </div>
</div>
{{-- /FILTROS --}}


          <!-- Historial -->
<div class="bg-white rounded-lg shadow">
  <!-- Contenedor con scroll y altura fija -->
  <div class="max-h-[360px] overflow-y-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50 sticky top-0 z-20">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Fecha</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Vendedor</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Tipo</th>
          <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Cantidad</th>
          <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Notas</th>
          <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <template x-for="tx in transactions" :key="tx.id">
          <tr>
            <td class="px-6 py-4 text-sm text-gray-600"
                x-text="new Date(tx.created_at).toLocaleString()"></td>
            <td class="px-6 py-4 text-sm text-gray-800" x-text="tx.vendor.name"></td>
            <td class="px-6 py-4 text-sm">
              <span class="px-2 py-1 rounded-full text-xs font-semibold"
                    :class="tx.type==='issue' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'"
                    x-text="tx.type==='issue' ? 'Salida' : 'Ingreso'">
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-right font-bold" x-text="tx.quantity"></td>
            <td class="px-6 py-4 text-sm text-gray-600" x-text="tx.notes"></td>
            <td class="px-6 py-4 text-center space-x-2">
              <a :href="`/box/transaction/${tx.id}/edit`"
                 class="inline-flex items-center text-blue-600 hover:underline text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5h2m6.938 4.938l-1.5 1.5M18 13v2m-6.938
                           6.938l-1.5-1.5M5 13v-2m6.938-6.938l1.5-1.5M5
                           11H3m1.062-6.938l1.5 1.5" />
                </svg>
                Editar
              </a>
              <button @click.prevent="transactionToDelete = tx.id; showDeleteTransactionModal = true"
                      class="inline-flex items-center text-red-600 hover:underline text-sm ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                Eliminar
              </button>
            </td>
          </tr>
        </template>
        <tr x-show="transactions.length===0">
          <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
            No hay transacciones para mostrar.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

      <!-- Modal Confirmación Borrar Vendedor -->
      <div x-show="showDeleteVendorModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
          <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
          <p class="text-gray-600 mb-4">Se eliminará permanentemente al vendedor.</p>
          <div class="flex justify-center space-x-4">
            <button @click="showDeleteVendorModal=false"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
            <button @click="fetch(`/box/vendors/${vendorToDelete}`, { method:'DELETE', headers:{ 'X-CSRF-TOKEN':'{{ csrf_token() }}' }, credentials:'same-origin' })
                           .then(res => res.ok ? location.reload() : alert('Error al eliminar'))"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
          </div>
        </div>
      </div>

      <!-- Modal Confirmación Borrar Transacción -->
      <div x-show="showDeleteTransactionModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
          <h2 class="text-xl font-semibold mb-2">¿Estás seguro?</h2>
          <p class="text-gray-600 mb-4">Se eliminará permanentemente la transacción.</p>
          <div class="flex justify-center space-x-4">
            <button @click="showDeleteTransactionModal=false"
                    class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
            <button
  @click="
    fetch(`/box/transaction/${transactionToDelete}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(() => {
      showDeleteTransactionModal = false;
      load(selectedVendor);
    })
  "
  class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
>
  Eliminar
</button>

          </div>
        </div>
      </div>
    </main>
  </div>
</div>


<script>
  function adminStats() {
    return {
      selectedVendor: null,
      /* — filtros — */
      fromDate: '',
      toDate: '',
      filterVendor: '',
      filterType: '',
      searchNotes: '',
      stats: { issued: 0, returned: 0, pending: 0 },
      transactions: [],

      async load(vendorId) {
        this.selectedVendor = vendorId;

        // Construir query params
        const params = new URLSearchParams();
        if (vendorId)              params.append('vendor_id', vendorId);
        if (this.fromDate)         params.append('from', this.fromDate);
        if (this.toDate)           params.append('to', this.toDate);
        if (this.filterVendor)     params.append('filter_vendor', this.filterVendor);
        if (this.filterType)       params.append('filter_type', this.filterType);
        if (this.searchNotes)      params.append('search_notes', this.searchNotes);

        const url = `/api/admin/stats?${params.toString()}`;

        const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const json = await res.json();

        this.stats = {
          issued:   json.stats.issued,
          returned: json.stats.returned,
          pending:  json.stats.pending
        };
        this.transactions = json.transactions;
      }
    };
  }
</script>

@endsection
