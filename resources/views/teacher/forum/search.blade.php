@extends('teacher.layouts.app')

@section('title', 'Cari Diskusi')
@section('description', 'Cari diskusi di forum guru')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('teacher.forum.index') }}" 
                           class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Forum
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">Cari Diskusi</h1>
                    <p class="mt-2 text-gray-600">Temukan diskusi yang Anda cari</p>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-6">
                <form id="searchForm" action="{{ route('teacher.forum.search') }}" method="GET">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="q" value="{{ $query }}" 
                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Cari diskusi...">
                        </div>
                        <div class="md:w-48">
                            <select name="category" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Kategori</option>
                                <option value="1" {{ $category == '1' ? 'selected' : '' }}>Pembelajaran</option>
                                <option value="2" {{ $category == '2' ? 'selected' : '' }}>Penilaian</option>
                                <option value="3" {{ $category == '3' ? 'selected' : '' }}>Teknologi Pendidikan</option>
                                <option value="4" {{ $category == '4' ? 'selected' : '' }}>Manajemen Kelas</option>
                                <option value="5" {{ $category == '5' ? 'selected' : '' }}>Pengembangan Profesi</option>
                            </select>
                        </div>
                        <div class="md:w-48">
                            <select name="sort" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Populer</option>
                                <option value="replies" {{ $sort == 'replies' ? 'selected' : '' }}>Paling Banyak Balasan</option>
                                <option value="likes" {{ $sort == 'likes' ? 'selected' : '' }}>Paling Banyak Suka</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Hasil Pencarian
                        @if($query)
                        untuk "{{ $query }}"
                        @endif
                    </h2>
                    <div class="text-sm text-gray-500">
                        {{ $results->count() }} hasil ditemukan
                    </div>
                </div>
            </div>
            
            @if($results->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($query)
                    Coba gunakan kata kunci yang berbeda atau periksa ejaan.
                    @else
                    Masukkan kata kunci untuk mencari diskusi.
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('teacher.forum.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Diskusi Baru
                    </a>
                </div>
            </div>
            @else
            <div class="divide-y divide-gray-200">
                @foreach($results as $discussion)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $discussion->category }}
                                </span>
                                @if($discussion->is_pinned)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Dipasang
                                </span>
                                @endif
                            </div>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">
                                <a href="{{ route('teacher.forum.show', $discussion->id) }}" class="hover:text-blue-600">
                                    {{ $discussion->title }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $discussion->content }}</p>
                            <div class="mt-4 flex items-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $discussion->author }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $discussion->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>{{ $discussion->replies_count }} balasan</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span>{{ $discussion->likes_count }} suka</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($results->count() > 0)
        <div class="mt-8 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Menampilkan 1-{{ $results->count() }} dari {{ $results->count() }} hasil
            </div>
            <div class="flex space-x-2">
                <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Sebelumnya
                </button>
                <button class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Selanjutnya
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on category or sort change
    const categorySelect = document.querySelector('select[name="category"]');
    const sortSelect = document.querySelector('select[name="sort"]');
    
    categorySelect.addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    
    sortSelect.addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    
    // Highlight search terms in results
    const query = '{{ $query }}';
    if (query) {
        const results = document.querySelectorAll('.divide-y.divide-gray-200 h3, .divide-y.divide-gray-200 p');
        results.forEach(element => {
            const text = element.textContent;
            const highlightedText = text.replace(new RegExp(query, 'gi'), `<mark class="bg-yellow-200">${query}</mark>`);
            element.innerHTML = highlightedText;
        });
    }
});
</script>
@endsection

