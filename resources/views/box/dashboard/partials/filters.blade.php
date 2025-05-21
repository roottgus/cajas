{{-- resources/views/box/dashboard/partials/filters.blade.php --}}
<div class="bg-white rounded-lg shadow p-4 mb-4 border-t-4 border-red-600">
  <div class="flex items-center mb-3">
    <span class="inline-block bg-red-600 text-white text-xs font-semibold uppercase px-2 py-1 rounded mr-2">
      Filtros
    </span>
    <h4 class="text-sm font-semibold text-gray-800">de Historial</h4>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
    <div>
      <label class="block text-xs text-gray-600 mb-1">Desde</label>
      <input type="date" x-model="fromDate"
             class="w-full text-sm border-gray-300 rounded focus:border-red-600 hover:border-gray-200 p-2 h-8" />
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Hasta</label>
      <input type="date" x-model="toDate"
             class="w-full text-sm border-gray-300 rounded focus:border-red-600 hover:border-gray-200 p-2 h-8" />
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Vendedor</label>
      <select x-model="filterVendor"
              class="w-full text-sm border-gray-300 rounded focus:border-red-600 hover:border-gray-200 p-2 h-9">
        <option value="">Todos</option>
        @foreach($vendors as $v)
          <option value="{{ $v->id }}">{{ $v->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-xs text-gray-600 mb-1">Tipo</label>
      <select x-model="filterType"
              class="w-full text-sm border-gray-300 rounded focus:border-red-600 hover:border-gray-200 p-2 h-9">
        <option value="">Todos</option>
        <option value="issue">Salida</option>
        <option value="return">Ingreso</option>
        
      </select>
    </div>
    <div class="sm:col-span-2 lg:col-span-4 flex">
      <div class="flex-1">
        <label class="block text-xs text-gray-600 mb-1">Buscar notas</label>
        <input type="text" x-model="searchNotes" placeholder="Texto libre..."
               class="w-full text-sm border-gray-300 rounded-l focus:border-red-600 hover:border-gray-200 p-2 h-8" />
      </div>
      <button @click="load(null)"
              class="ml-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-r shadow px-4 h-8 transition">
        Filtrar
      </button>
    </div>
  </div>
</div>
