{{-- resources/views/partials/pwa-install-prompt.blade.php --}}
<div
  x-data="{ open: localStorage.getItem('pwaPromptClosed') !== 'true' }"
  x-show="open"
  x-transition
  class="fixed bottom-0 inset-x-0 bg-white bg-opacity-90 text-gray-900 p-4 flex justify-between items-center shadow-lg z-50 sm:hidden"
>
  <div class="flex-1 text-sm">
    <strong>Instalar la App</strong><br>
    Para añadirla a tu pantalla de inicio, abre el menú ⋮ de Chrome y selecciona 
    <em>Añadir a pantalla de inicio</em>.
  </div>
  <button
    @click="localStorage.setItem('pwaPromptClosed','true'); open = false"
    class="ml-4 text-xl leading-none focus:outline-none"
    aria-label="Cerrar aviso"
  >&times;</button>
</div>
