<div x-data @keydown.escape.window="$wire.closeModal()">
  <div
    x-show="$wire.open"
    x-cloak
    wire:ignore.self
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity"
  >
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative animate-fade-in">
      {{-- Botón de cerrar --}}
      <button
        @click="$wire.closeModal()"
        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
      >✕</button>

      {{-- Mensaje de éxito con ícono --}}
      @if($successMessage)
        <div
          x-data
          x-init="setTimeout(() => { $wire.closeModal() }, 3000)"
          class="mb-4 flex items-center space-x-2 bg-green-100 text-green-800 p-3 rounded"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7"/>
          </svg>
          <span>{{ $successMessage }}</span>
        </div>
      @endif

      {{-- Título --}}
      <h2 class="text-xl font-semibold mb-4">
        {{ $type === 'issue'
            ? 'Registrar Salida de Cajas'
            : 'Registrar Ingreso de Cajas' }}
      </h2>

      {{-- Formulario --}}
      <form wire:submit.prevent="save" class="space-y-4">
        <div>
          <label for="quantity" class="block font-medium">Cantidad</label>
          <input
            id="quantity"
            type="number"
            min="1"
            wire:model.defer="quantity"
            class="w-full border rounded px-2 py-1"
            required
          />
          @error('quantity')
            <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>

        <div class="flex justify-end space-x-2">
          <button
            type="button"
            @click="$wire.closeModal()"
            class="px-4 py-2 rounded border hover:bg-gray-100"
          >
            Cancelar
          </button>
          <button
            type="submit"
            class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
          >
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
