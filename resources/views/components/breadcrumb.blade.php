<nav class="bg-gray-50 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach($items as $index => $item)
                <li class="flex items-center">
                    @if($index > 0)
                        <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    
                    @if($item['url'])
                        <a href="{{ $item['url'] }}" class="text-primary-500 hover:text-primary-600 transition-colors duration-200">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="text-gray-900 font-medium">{{ $item['name'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>