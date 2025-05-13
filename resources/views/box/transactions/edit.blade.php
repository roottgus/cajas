@extends('layouts.app')

@section('title', 'Editar Transacción')

@section('content')
<div class="max-w-md mx-auto py-10 px-4 sm:px-6 lg:px-8">
  <h1 class="text-2xl font-bold mb-6">Editar Transacción</h1>

  <form action="{{ route('box.transaction.update', $transaction) }}" method="POST" class="space-y-4">
    @csrf
    @method('PATCH')

    {{-- Cantidad --}}
    <div>
      <label for="quantity" class="block font-medium">Cantidad</label>
      <input
        id="quantity"
        name="quantity"
        type="number"
        min="1"
        value="{{ old('quantity', $transaction->quantity) }}"
        class="w-full border rounded px-2 py-1"
        required
      >
      @error('quantity')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Notas --}}
    <div>
      <label for="notes" class="block font-medium">Notas</label>
      <textarea
        id="notes"
        name="notes"
        rows="3"
        class="w-full border rounded px-2 py-1"
      >{{ old('notes', $transaction->notes) }}</textarea>
      @error('notes')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Botones --}}
    <div class="flex justify-end space-x-2">
      <a
        href="{{ route('box.dashboard') }}"
        class="px-4 py-2 rounded border hover:bg-gray-100"
      >
        Cancelar
      </a>
      <button
        type="submit"
        class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700"
      >
        Guardar Cambios
      </button>
    </div>
  </form>
</div>
@endsection
