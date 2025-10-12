@extends('layouts.app')

@section('title', 'Berita - SMP Negeri 01 Namrole')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['name' => 'Home', 'url' => route('home')],
    ['name' => 'Berita', 'url' => null]
]" />

<!-- Page Header -->
<x-page-header 
    title="Berita Sekolah" 
    subtitle="Informasi terkini dan berita terbaru dari SMP Negeri 01 Namrole" 
/>

<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-8">
                    <!-- Search -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cari Berita</h3>
                        <form method="GET" action="{{ route('news') }}" class="space-y-4">
                            <div>
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari berita..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-primary-500 text-white py-2 px-4 rounded-md hover:bg-primary-600 transition-colors duration-200">
                                Cari
                            </button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Kategori</h3>
                        <div class="space-y-2">
                            <a href="{{ route('news') }}" 
                               class="block px-3 py-2 rounded-md {{ !request('category') ? 'bg-primary-100 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Semua Kategori ({{ $news->total() }})
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('news', ['category' => $category->id]) }}" 
                                   class="block px-3 py-2 rounded-md {{ request('category') == $category->id ? 'bg-primary-100 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $category->name }} ({{ $category->news_count }})
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Featured News -->
                    @if($featuredNews = $news->where('is_featured', true)->first())
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Berita Utama</h3>
                            <div class="bg-gradient-to-r from-primary-500 to-secondary rounded-lg p-4 text-white">
                                <h4 class="font-semibold mb-2">{{ Str::limit($featuredNews->title, 60) }}</h4>
                                <p class="text-sm text-primary-100 mb-3">{{ Str::limit($featuredNews->excerpt, 80) }}</p>
                                <a href="{{ route('news.show', $featuredNews) }}" 
                                   class="text-sm font-medium underline hover:no-underline">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Popular News -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berita Terpopuler</h3>
                        <div class="space-y-4">
                            @foreach($popularNews as $index => $popular)
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-6 h-6 bg-primary-500 text-white text-xs font-bold rounded-full">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('news.show', $popular) }}" 
                                           class="text-sm font-medium text-gray-900 hover:text-primary-600 line-clamp-2">
                                            {{ $popular->title }}
                                        </a>
                                        <p class="text-xs text-gray-500 mt-1">{{ $popular->views }} views</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent News -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berita Terkini</h3>
                        <div class="space-y-3">
                            @foreach($recentNews as $recent)
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $recent->image_url }}" 
                                             alt="{{ $recent->title }}"
                                             class="w-12 h-12 object-cover rounded"
                                             onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxyZWN0IHg9IjUwIiB5PSI1MCIgd2lkdGg9IjMwMCIgaGVpZ2h0PSIyMDAiIGZpbGw9IiM5Q0EzQUYiLz4KPHRleHQgeD0iMjAwIiB5PSIxNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM2QjcyODAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNiI+TmV3cyBJbWFnZTwvdGV4dD4KPC9zdmc+';">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('news.show', $recent) }}" 
                                           class="text-sm font-medium text-gray-900 hover:text-primary-600 line-clamp-2">
                                            {{ $recent->title }}
                                        </a>
                                        <p class="text-xs text-gray-500 mt-1">{{ $recent->time_ago }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                @if($news->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($news as $article)
                            <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <!-- Image -->
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ $article->image_url }}" 
                                         alt="{{ $article->title }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxyZWN0IHg9IjUwIiB5PSI1MCIgd2lkdGg9IjMwMCIgaGVpZ2h0PSIyMDAiIGZpbGw9IiM5Q0EzQUYiLz4KPHRleHQgeD0iMjAwIiB5PSIxNTAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM2QjcyODAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNiI+TmV3cyBJbWFnZTwvdGV4dD4KPC9zdmc+';">
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <!-- Category Badge -->
                                    @if($article->category)
                                        <span class="inline-block px-2 py-1 text-xs font-medium bg-primary-100 text-primary-800 rounded-full mb-3">
                                            {{ $article->category->name }}
                                        </span>
                                    @endif

                                    <!-- Title -->
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                                        <a href="{{ route('news.show', $article) }}" 
                                           class="hover:text-primary-600 transition-colors duration-200">
                                            {{ $article->title }}
                                        </a>
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ $article->excerpt }}
                                    </p>

                                    <!-- Meta -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center space-x-3">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $article->author->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $article->published_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $article->views }}
                                        </span>
                                    </div>

                                    <!-- Tags -->
                                    @if($article->tags->count() > 0)
                                        <div class="mt-3 flex flex-wrap gap-1">
                                            @foreach($article->tags->take(3) as $tag)
                                                <a href="{{ route('news.tag', $tag) }}" 
                                                   class="inline-block px-2 py-1 text-xs font-medium rounded" 
                                                   style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Read More Button -->
                                    <div class="mt-4">
                                        <a href="{{ route('news.show', $article) }}" 
                                           class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium text-sm">
                                            Baca Selengkapnya
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $news->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Berita</h3>
                        <p class="text-gray-600">Berita sekolah akan segera ditambahkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

