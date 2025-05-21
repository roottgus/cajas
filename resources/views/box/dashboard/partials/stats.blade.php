{{-- resources/views/box/dashboard/partials/stats.blade.php --}}
<div class="mb-4 flex justify-between items-center">
  <h2 class="text-xl font-semibold text-gray-700">Estadísticas</h2>
  <button
    @click="filterVendor = ''; load()"
    class="px-3 py-1 bg-gray-200 text-sm rounded hover:bg-gray-300 transition"
  >
    Ver totales
  </button>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
  <template x-for="(label, key) in ['Ingreso-Bodega', 'Salida-Bodega', 'PENDIENTES']" :key="key">
    <div class="relative bg-white rounded-lg shadow p-6 overflow-hidden">
      <div class="absolute top-4 right-4 opacity-10 h-16 w-16">
        <template x-if="key === 0">
          <!-- Icono de ingreso -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 13l-4 4m0 0l-4-4m4 4V7" />
          </svg>
        </template>
        <template x-if="key === 1">
          <!-- Icono de salida -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 11l4-4m0 0l4 4m-4-4v10" />
          </svg>
        </template>
        <template x-if="key === 2">
          <!-- Icono de pendientes -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </template>
      </div>
      <div class="relative z-10">
        <h3 class="text-lg font-medium text-gray-700"><span x-text="label"></span></h3>
        <p class="mt-2 text-3xl font-bold"
           :class="{
             'text-green-600': key === 0,
             'text-red-600':   key === 1,
             'text-gray-800':  key === 2
           }"
           x-text="stats[
             key === 0 ? 'returned' :
             key === 1 ? 'issued'  :
                         'pending'
           ]">
        </p>
      </div>
    </div>
  </template>
</div>
