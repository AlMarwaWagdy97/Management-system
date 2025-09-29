  <!--Bootstrap cdn -->
  <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('site/js/jquery.min.js') }}"></script>


  <!--Swiper-->
  <script src="{{ asset('site/js/swiper-bundle.js') }}"></script>

  <!--Animation-->
  <script src="{{ asset('site/js/wow.min.js') }}"></script>

  <!--Custom Script-->
  <script src="{{ asset('site/js/cart.js') }}"></script>
  <script src="{{ asset('site/js/project.js') }}"></script>
  <script src="{{ asset('site/js/main.js') }}"></script>

  <!-- VITE JS -->
  {{-- @vite(['resources/assets/site/app.js']) --}}

  @yield('script')

  <script src="{{ asset('site/js/htmx.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

  <!-- Livewire Script -->
  @livewireScripts

