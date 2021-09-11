<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $header ? "$header - " : '' }} Laravel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap"
        rel="stylesheet">

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  <style>
    body,
    a {
      color: white;
    }

  </style>

</head>

<body class="font-sans bg-primary-800 text-white">
  <nav class="border-b border-primary-700">
    <div x-data="{ openNav: false, openSearch: false }"
         class="container mx-auto flex items-center justify-between py-5">
      <div class="md:flex items-center">
        <a href="{{ route('movies.index') }}">
          <x-app.logo />
        </a>

        <ul x-show="openNav" x-transition style="display: none"
            class="fixed md:position-initial inset-0 p-20 md:p-0 text-center md:bg-primary-800 bg-primary-700 md:d-flex flex-col md:flex-row items-center">
          <li class="mb-5">
            <button x-on:click="openNav = !openNav"
                    class="md:hidden focus:ring-2 focus:outline-none ring-primary-500 rounded-full p-1 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </button>
          </li>
          <li class=" md:ml-8
              lg:ml-16">
            <a href="{{ route('movies.index') }}"
               class="hover:text-primary-300 transition">Movies</a>
          </li>
          <li class="md:ml-6 lg:ml-8 md:mt-0 mt-4">
            <a href="#" class="hover:text-primary-300 transition">TV Show</a>
          </li>
          <li class="md:ml-6 lg:ml-8 md:mt-0 mt-4">
            <a href="#" class="hover:text-primary-300 transition">Actors</a>
          </li>
        </ul>
      </div>

      <div class="flex items-center">
        <button x-on:click="openNav = !openNav"
                class="md:hidden block mr-3 focus:ring-2 focus:outline-none ring-primary-500 rounded-full p-1 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
               fill="currentColor">
            <path fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd" />
          </svg>
        </button>

        <button x-show="!openSearch" x-transition:enter.duration.400ms
                x-transition:leave.duration.1ms x-on:click="
            openSearch = !openSearch
            setTimeout(() => $refs.search.focus(),100)
        "
                class="lg:hidden block focus:ring-2 focus:outline-none ring-primary-500 rounded-full p-1 transition">
          <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
            <path class="heroicon-ui"
                  d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" />
          </svg>
        </button>

        <div x-show="openSearch" @click.away="openSearch = false" x-transition style="display: none"
             class="lg:d-block relative">
          <input x-ref="search" type="search" placeholder="Search"
                 class="w-64 py-2 pl-8 pr-5 rounded-full bg-gray-700 text-sm text-gray-200 focus:outline-none focus:shadow-md focus:ring-2 transition ease-in-out focus:ring-primary-600">
          <div class="absolute" style="top: 10px; left: 10px;">
            <svg class="fill-current w-4 text-gray-500" viewBox="0 0 24 24">
              <path class="heroicon-ui"
                    d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" />
            </svg>
          </div>
        </div>

        <div class="ml-3">
          <a href="#">
            <img src="/img/avatar.jpg" alt="avatar" class="rounded-full w-8 h-8">
          </a>
        </div>
      </div>
    </div>
  </nav>

  <main>
    {{ $slot }}
  </main>

  <footer>

  </footer>

  <!-- Alpine Core -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>