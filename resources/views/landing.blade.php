<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="description" content="Control de Cajas FritoLay: plataforma profesional para gestionar la entrega y devolución de cajas de productos." />

  {{-- Favicons --}}
  <link rel="apple-touch-icon" sizes="57x57"   href="{{ asset('apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60"   href="{{ asset('apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72"   href="{{ asset('apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76"   href="{{ asset('apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">

  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32"   href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96"   href="{{ asset('favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16"   href="{{ asset('favicon-16x16.png') }}">

  {{-- PWA Manifest --}}
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#E5002A">

  <title>FritoLay – Control de Cajas</title>

  {{-- Estilos y scripts (incluye app.js para Alpine y PWA) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="relative min-h-screen flex flex-col" x-data>

  {{-- Splash Background --}}
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/splash.png') }}')"></div>
  <div class="absolute inset-0 bg-gradient-to-br from-black/50 to-black/30"></div>

  {{-- Main Content --}}
  <main class="relative z-10 flex flex-col items-center justify-center flex-1 text-center px-4">
    <img src="{{ asset('images/logo-fritolay.png') }}"
         alt="Logo FritoLay"
         class="w-32 mb-8 animate-float" />
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 animate-fadeIn">
      Control de Cajas de Retorno
    </h1>
    <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-12 max-w-lg mx-auto animate-fadeIn">
      Una plataforma profesional para gestionar la entrega y devolución de cajas de productos.
    </p>
    <a href="{{ route('box.public') }}"
       aria-label="Ver reporte público de cajas"
       class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg
              transition transform hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500 animate-fadeIn">
      Control General
    </a>
  </main>

  {{-- Scroll Indicator --}}
  <div class="absolute bottom-8 w-full flex justify-center animate-bounce">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
  </div>

    {{-- ... contenido ... --}}
  @include('partials.pwa-install-prompt')
  @livewireScripts
</body>
</html>