<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta name="description" content="Control de Cajas FritoLay: plataforma profesional para gestionar la entrega y devolución de cajas de productos." />
  <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}" type="image/png" sizes="32x32" />
  <link rel="preload" as="image" href="{{ asset('images/splash.png') }}">
  <title>FritoLay – Control de Cajas</title>
  @vite(['resources/css/app.css'])
  @livewireStyles
</head>
<body class="relative min-h-screen flex flex-col">
  <a href="#main-content" class="sr-only focus:not-sr-only px-4 py-2 bg-red-600 text-white rounded-md">Saltar al contenido</a>

  <!-- Background -->
  <div
    class="absolute inset-0 bg-cover bg-center"
    style="background-image: url('{{ asset('images/splash.png') }}')"
  ></div>

  <!-- Overlay -->
  <div class="absolute inset-0 bg-gradient-to-br from-black/50 to-black/30 no-blur"></div>

  <!-- Content -->
  <main id="main-content" class="relative z-10 flex flex-col items-center justify-center flex-1 text-center px-4">
    <img
      src="{{ asset('images/logo-fritolay.png') }}"
      alt="Logo FritoLay"
      class="w-32 mb-8 animate-float"
    />
    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 animate-fadeIn">
      Control de Cajas de Retorno
    </h1>
    <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-12 max-w-lg mx-auto animate-fadeIn">
      Una plataforma profesional para gestionar la entrega y devolución de cajas de productos.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 animate-fadeIn">
      <a
        href="{{ route('box.public') }}"
        aria-label="Ver reporte público de cajas"
        class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-lg
               transition transform hover:-translate-y-0.5 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-red-500"
      >
        Control General
      </a>
    </div>
  </main>

  <!-- Scroll Indicator -->
  <div class="absolute bottom-8 w-full flex justify-center animate-bounce">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
  </div>

  @livewireScripts
</body>
</html>
