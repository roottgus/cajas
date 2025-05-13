<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Box App' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex flex-col min-h-screen">
  <main class="flex-1 flex items-center justify-center py-6">
    <div class="w-full max-w-md px-4">
      {{ $slot }}
    </div>
  </main>
</body>
</html>
