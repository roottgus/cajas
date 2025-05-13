<nav class="bg-white shadow-md sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      {{-- Logo + Enlaces --}}
      <div class="flex items-center space-x-8">
        <a href="{{ route('landing') }}">
          <img src="{{ asset('images/logo-fritolay-small.png') }}"
               alt="FritoLay"
               class="h-10 w-auto" />
        </a>
        <div class="hidden md:flex space-x-4">
          <a href="{{ route('box.public') }}"
             class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
            Reporte Público
          </a>
          @auth
            <a href="{{ route('box.dashboard') }}"
               class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
              Dashboard Admin
            </a>
          @endauth
        </div>
      </div>

      {{-- Botones de acceso --}}
      <div class="flex items-center space-x-4">
        @guest
          <button @click="adminModal = true"
                  class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-sm hover:bg-red-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
              <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
            </svg>
            Ingreso Administrador
          </button>
        @else
          <span class="text-gray-700">Hola, <strong>{{ Auth::user()->name }}</strong></span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    onclick="localStorage.removeItem('greetingShown')"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
              Cerrar sesión
            </button>
          </form>
        @endguest
      </div>

      {{-- Mobile menu button --}}
      <div class="md:hidden flex items-center">
        <button @click="mobileMenu = !mobileMenu"
                class="text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
            <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Mobile menu --}}
  <div x-show="mobileMenu" x-cloak class="md:hidden bg-white border-t border-gray-200">
    <div class="px-4 py-3 space-y-1">
      <a href="{{ route('box.public') }}"
         class="block px-3 py-2 text-base font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
        Reporte Público
      </a>
      @auth
        <a href="{{ route('box.dashboard') }}"
           class="block px-3 py-2 text-base font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
          Dashboard Admin
        </a>
      @endauth
      @guest
        <button @click="adminModal = true"
                class="w-full text-left px-3 py-2 text-base font-semibold text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition">
          Ingreso Administrador
        </button>
      @else
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  onclick="localStorage.removeItem('greetingShown')"
                  class="w-full text-left px-3 py-2 text-base font-semibold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
            Cerrar sesión
          </button>
        </form>
      @endguest
    </div>
  </div>
</nav>
