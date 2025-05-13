<!DOCTYPE html>
<html lang="es">
<head>
  <!-- tus meta tags -->
  <title>@yield('title', 'Box App')</title>

  <script>window.deferLoadingAlpine = true;</script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body  
  x-data="{ adminModal: false }"
  class="font-sans antialiased bg-gray-100 flex flex-col min-h-screen"
>
  @include('layouts.navigation')

  <main class="flex-1 py-6">
    @yield('content')
  </main>

  @livewireScripts

  {{-- Footer global --}}
  @include('partials.footer')

  {{-- Modal de Ingreso Administrador --}}
  @include('partials.admin-login-modal')

  <script>
  // Debug: escucha el evento global para ver si Alpine lo emite
  Livewire.on('open-report-modal', params => {
    console.log('🔔 Livewire recibió open-report-modal con:', params);
  });
</script>

</body>
</html>
