@php
    $isActive = $isActive ?? false;
@endphp

<a href="{{ $href }}"
   class="relative px-4 py-2 text-sm font-medium transition-all duration-300 rounded-lg hover:bg-white/5 group
          {{ $isActive ? 'text-white' : 'text-gray-400 hover:text-white' }}">
    {{ $slot }}
    @if($isActive)
        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-jedi-blue rounded-full shadow-[0_0_12px_rgba(74,158,255,0.6)]"></span>
    @else
        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-jedi-blue rounded-full transition-all duration-300 group-hover:w-6 group-hover:shadow-[0_0_12px_rgba(74,158,255,0.4)]"></span>
    @endif
</a>

