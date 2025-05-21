{{-- resources/views/box/dashboard/partials/transactions-table.blade.php --}}
<div class="bg-white rounded-lg shadow p-4">

  {{-- BOTONES DE EXPORTACIÓN --}}
  <div class="flex justify-end mb-4 space-x-2">
    <button
      @click="exportFile('excel')"
      class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
    >
      Exportar Excel
    </button>
    <button
      @click="exportFile('pdf')"
      class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
    >
      Exportar PDF
    </button>
  </div>
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
            <!-- Fecha: fecha + hora local del navegador -->
            <td class="px-6 py-4 text-sm text-gray-600">
              <div x-text="new Date(tx.created_at).toLocaleDateString()"></div>
              <div class="text-xs text-gray-500" x-text="new Date(tx.created_at).toLocaleTimeString()"></div>
            </td>

            <!-- Vendedor: avatar + nombre -->
            <td class="px-6 py-4 text-sm text-gray-800 flex items-center">
              <img 
                src="{{ asset('img/avatar.png') }}" 
                alt="Avatar" 
                class="h-6 w-6 rounded-full mr-2"
              />
              <span x-text="tx.vendor.name"></span>
            </td>

            <!-- Tipo: pill con padding aumentado -->
            <td class="px-6 py-4 text-sm">
              <span 
                class="px-3 py-1 rounded-full text-xs font-semibold"
                :class="tx.type==='issue' 
                  ? 'bg-red-100 text-red-800' 
                  : 'bg-green-100 text-green-800'"
                x-text="tx.type==='issue' ? 'Salida' : 'Ingreso'"
              ></span>
            </td>

            <!-- Cantidad -->
            <td class="px-6 py-4 text-sm text-right font-bold" x-text="tx.quantity"></td>

            <!-- Notas -->
            <td class="px-6 py-4 text-sm text-gray-600" x-text="tx.notes"></td>

            <!-- Acciones -->
            <td class="px-6 py-4 text-center space-x-2">
              <!-- Editar -->
              <a :href="`/box/transaction/${tx.id}/edit`"
                 class="inline-flex items-center text-blue-600 hover:underline text-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 mr-1"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5h2m6.938 4.938l-1.5 1.5M18 13v2M11 19.938l-1.5-1.5M5 13v-2M11 5.062l1.5-1.5M5 11H3" />
                </svg>
                Editar
              </a>
              <!-- Eliminar -->
              <button @click.prevent="transactionToDelete = tx.id; showDeleteTransactionModal = true"
                      class="inline-flex items-center text-red-600 hover:underline text-sm ml-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 mr-1"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                Eliminar
              </button>
            </td>
          </tr>
        </template>
        <tr x-show="transactions.length === 0">
          <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
            No hay transacciones para mostrar.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
