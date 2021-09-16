<div x-data="{ isOpen: true }" @click.away="isOpen = false" class="relative">
  <input @focus="isOpen = true" @keydown="isOpen = true" @keydown.escape.window="isOpen = false"
         @keydown.shift.tab="isOpen = false" wire:model.debounce.500ms="search" id="search"
         type="text" placeholder="Search (Press '/')"
         class="w-full md:w-64 py-2 pl-10 pr-9 rounded-full bg-gray-700 text-sm text-gray-200 focus:outline-none focus:shadow-md focus:ring-2 transition ease-in-out focus:ring-primary-600" />

  @if (strlen($search) > 0)
    <button class="absolute focus:outline-none" style="top: 6px; right: 6px;"
            wire:click="resetSearch">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </button>
  @endif

  <div wire:loading.delay wire:target="search" class="absolute left-0" style="top: -2px;">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
         style="margin: auto; background: none; display: block; shape-rendering: auto;" width="40px"
         height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
      <circle cx="50" cy="50" fill="none" stroke="#dad7d7" stroke-width="5" r="26"
              stroke-dasharray="122.52211349000194 42.840704496667314">
        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite"
                          dur="0.5555555555555556s" values="0 50 50;360 50 50" keyTimes="0;1">
        </animateTransform>
      </circle>
      <!-- [ldio] generated by https://loading.io/ -->
    </svg>
  </div>

  <div wire:loading.delay.class="hidden" wire:target="search" class="absolute"
       style="top: 10px; left: 10px;">
    <svg class="fill-current w-4 text-gray-500" viewBox="0 0 24 24">
      <path class="heroicon-ui"
            d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z" />
    </svg>
  </div>

  @if (strlen($search) > 1)
    <div class="absolute bg-primary-600 rounded w-full md:w-64 mt-4 shadow-lg z-50" x-show="isOpen"
         x-transition>
      <ul class="overflow-y-auto search-list" style="max-height: calc(100vh - 85px)">
        @forelse ( $results as $result)
          <li class="border-b border-primary-700 focus:outline-none focus:bg-gray-700"
              @if ($loop->last)@keydown.tab="isOpen = false" @endif>
            <a href="{{ $result['url'] }}"
               class="transition rounded hover:bg-gray-700 px-3 py-3 flex items-center focus:outline-none focus:bg-gray-700">
              @if ($result['image'])
                <img class="mr-2 rounded" src="{{ $result['image'] }}"
                     alt="{{ $result['title'] }}">
              @else
                <div class="w-11 h-16 bg-primary-400 rounded mr-2"></div>
              @endif
              <div>
                <h2 class="text-sm">{{ $result['title'] }}</h2>
                @if ($result['vote_average'])
                  <div class="flex text-xs">
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" class="text-yellow-500 w-4"
                           viewBox="0 0 20 20" fill="currentColor">
                        <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                      </svg>
                    </span>
                    <span>{{ $result['vote_average'] }}%</span>
                  </div>
                @endif
                <p class="text-sm">in {{ $result['media_type'] }}</p>
                @if ($result['release_date'])
                  <p class="text-xs">
                    {{ $result['release_date'] }}
                  </p>
                @elseif($result['popularity'])
                  <p class="text-xs">
                    <span class="text-yellow-500">Popularity:</span> {{ $result['popularity'] }}%
                  </p>
                @endif
              </div>
            </a>
          </li>
        @empty
          <li class="border-b border-primary-700">
            <p class="px-3 py-3 text-sm">
              No results found for "{{ $search }}"
            </p>
          </li>
        @endforelse
      </ul>
    </div>
  @endif
</div>
