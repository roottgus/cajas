{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title', 'Box App')</title>

  {{-- 1) Livewire Styles --}}
  @livewireStyles

  {{-- 2) Tus assets compilados con Vite (incluye app.js con Alpine+Livewire ESM) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body  
  x-data="{ mobileMenu: false, adminModal: false }"
  class="font-sans antialiased bg-gray-100 flex flex-col min-h-screen"
>
  {{-- Navegación, contenido, footer, etc. --}}
  @include('layouts.navigation')
  <main class="flex-1 py-6">
    @yield('content')
  </main>
  @include('partials.footer')
  @include('partials.admin-login-modal')

  {{-- 3) Indica a Livewire que NO inyecte scripts adicionales 
       (reemplaza @livewireScripts) --}}
  @livewireScriptConfig
</body>
</html>
