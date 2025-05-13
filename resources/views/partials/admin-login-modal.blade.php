{{-- resources/views/partials/admin-login-modal.blade.php --}}
<div
  x-cloak
  x-show="adminModal"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 scale-90"
  x-transition:enter-end="opacity-100 scale-100"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100 scale-100"
  x-transition:leave-end="opacity-0 scale-90"
  class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
>
  <div @click.away="adminModal = false"
       class="bg-white rounded-lg shadow-xl w-full max-w-md p-8 relative">
    {{-- Cerrar --}}
    <button @click="adminModal = false"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      &times;
    </button>

    <h2 class="text-2xl font-bold mb-6 text-center">Ingreso Administrador</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      {{-- Correo Electrónico en lugar de Usuario --}}
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">
          Correo Electrónico
        </label>
        <input id="email"
               name="email"
               type="email"
               value="{{ old('email') }}"
               required
               autofocus
               autocomplete="username"
               class="mt-1 block w-full border rounded px-3 py-2" />
        @error('email')
          <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>

      {{-- Contraseña --}}
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
          Contraseña
        </label>
        <input id="password"
               name="password"
               type="password"
               required
               autocomplete="current-password"
               class="mt-1 block w-full border rounded px-3 py-2" />
        @error('password')
          <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>

      {{-- Recuérdame y olvidaste --}}
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember"
                 name="remember"
                 type="checkbox"
                 class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" />
          <label for="remember" class="ml-2 block text-sm text-gray-900">
            Recuérdame
          </label>
        </div>
        <a href="{{ route('password.request') }}"
           class="text-sm text-red-600 hover:text-red-800">
          ¿Olvidaste tu contraseña?
        </a>
      </div>

      {{-- Botón --}}
      <button type="submit"
              class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition">
        Ingresar
      </button>
    </form>
  </div>
</div>
