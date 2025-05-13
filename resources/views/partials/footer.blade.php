{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-white py-2 flex flex-col items-center border-t border-gray-300 text-center">
    <div class="flex space-x-2 mb-2">
        <!-- Ajusta el tamaño de cada logo según tu preferencia (w-16, h-8, etc.) -->
        <img src="{{ asset('img/doritos.png') }}"   alt="Doritos"   class="h-8">
        <img src="{{ asset('img/gatorade.png') }}" alt="Gatorade"  class="h-8">
        <img src="{{ asset('img/detodito.png') }}" alt="De Todito"  class="h-8">
        <img src="{{ asset('img/quaker.png') }}"   alt="Quaker"    class="h-8">
        <img src="{{ asset('img/cheetos.png') }}"alt="Cheetos" class="h-8">
    </div>
    <p class="text-gray-600 text-xs">
        Diseño por
        <a href="https://publienred.com"
           target="_blank"
           class="text-blue-500 font-bold">
          Publienred
        </a>
    </p>
</footer>
