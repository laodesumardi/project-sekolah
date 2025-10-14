@extends('teacher.layouts.app')

@section('title', $discussion->title)
@section('description', Str::limit($discussion->content, 150))

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('teacher.forum.category', $discussion->category_id) }}" 
                           class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke {{ $discussion->category }}
                        </a>
                    </div>
                    <div class="mt-4 flex items-center space-x-2">
                        @if($discussion->is_pinned)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Dipasang
                        </span>
                        @endif
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-{{ $discussion->category_color }}-100 text-{{ $discussion->category_color }}-800">
                            {{ $discussion->category }}
                        </span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mt-4">{{ $discussion->title }}</h1>
                </div>
                <div class="flex space-x-3">
                    <button onclick="likeDiscussion({{ $discussion->id }})" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Suka ({{ $discussion->likes_count }})
                    </button>
                    @if(auth()->user()->profile->id == $discussion->author_id ?? false)
                    <div class="relative">
                        <button onclick="toggleDropdown()" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                            Aksi
                        </button>
                        <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <div class="py-1">
                                <a href="{{ route('teacher.forum.edit', $discussion->id) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                <button onclick="pinDiscussion({{ $discussion->id }})" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pin/Unpin</button>
                                <button onclick="deleteDiscussion({{ $discussion->id }})" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50">Hapus</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Discussion Content -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" src="{{ $discussion->author_avatar }}" alt="{{ $discussion->author }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $discussion->author }}</h3>
                                    <span class="text-sm text-gray-500">•</span>
                                    <span class="text-sm text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                                    @if($discussion->is_anonymous)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        Anonim
                                    </span>
                                    @endif
                                </div>
                                <div class="mt-4 prose max-w-none text-gray-700">
                                    {!! nl2br(e($discussion->content)) !!}
                                </div>
                                @if(!empty($discussion->tags))
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach($discussion->tags as $tag)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        #{{ $tag }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                                <div class="mt-6 flex items-center space-x-6 text-sm text-gray-500">
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
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>{{ $discussion->views_count }} dilihat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Balasan ({{ $replies->count() }})</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($replies as $reply)
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ $reply->author_avatar }}" alt="{{ $reply->author }}">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $reply->author }}</h3>
                                        <span class="text-sm text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                        @if($reply->is_anonymous)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            Anonim
                                        </span>
                                        @endif
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        {!! nl2br(e($reply->content)) !!}
                                    </div>
                                    <div class="mt-4 flex items-center space-x-4">
                                        <button onclick="likeReply({{ $reply->id }})" 
                                                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                            Suka ({{ $reply->likes_count }})
                                        </button>
                                        <button onclick="replyToReply({{ $reply->id }})" 
                                                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                            Balas
                                        </button>
                                    </div>
                                    
                                    <!-- Nested Replies -->
                                    @if(!empty($reply->replies))
                                    <div class="mt-4 ml-6 space-y-4">
                                        @foreach($reply->replies as $nestedReply)
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <img class="h-8 w-8 rounded-full" src="{{ $nestedReply->author_avatar }}" alt="{{ $nestedReply->author }}">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-2">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $nestedReply->author }}</h4>
                                                    <span class="text-sm text-gray-500">•</span>
                                                    <span class="text-sm text-gray-500">{{ $nestedReply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    {!! nl2br(e($nestedReply->content)) !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Tulis Balasan</h2>
                    </div>
                    <form id="replyForm" action="{{ route('teacher.forum.reply', $discussion->id) }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <div class="mb-4">
                                <textarea id="content" name="content" rows="4" required 
                                          class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                          placeholder="Tulis balasan Anda..."></textarea>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="checkbox" id="is_anonymous" name="is_anonymous" 
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                                        Kirim sebagai anonim
                                    </label>
                                </div>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Balasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Related Discussions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Diskusi Terkait</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($relatedDiscussions as $related)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('teacher.forum.show', $related->id) }}" class="hover:text-blue-600">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $related->author }} • {{ $related->created_at->diffForHumans() }}</p>
                                    <div class="mt-2 flex items-center space-x-3 text-xs text-gray-500">
                                        <span>{{ $related->replies_count }} balasan</span>
                                        <span>{{ $related->views_count }} dilihat</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('teacher.forum.create') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Buat Diskusi Baru
                            </a>
                            <a href="{{ route('teacher.forum.index') }}" 
                               class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Lihat Semua Diskusi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reply form submission
    document.getElementById('replyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.innerHTML;
        
        // Show loading state
        button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';
        button.disabled = true;
        
        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add reply to UI
                addReplyToUI(data.reply);
                // Clear form
                document.getElementById('content').value = '';
                document.getElementById('is_anonymous').checked = false;
            } else {
                alert('Gagal mengirim balasan: ' + (data.message || 'Terjadi kesalahan'));
                button.innerHTML = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim balasan');
            button.innerHTML = originalText;
            button.disabled = false;
        });
    });
});

function likeDiscussion(discussionId) {
    fetch(`/guru/forum/${discussionId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like count in UI
            console.log('Discussion liked');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function likeReply(replyId) {
    // Implement like reply functionality
    console.log('Like reply:', replyId);
}

function replyToReply(replyId) {
    // Implement reply to reply functionality
    console.log('Reply to reply:', replyId);
}

function toggleDropdown() {
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.toggle('hidden');
}

function pinDiscussion(discussionId) {
    fetch(`/guru/forum/${discussionId}/pin`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function deleteDiscussion(discussionId) {
    if (confirm('Apakah Anda yakin ingin menghapus diskusi ini?')) {
        fetch(`/guru/forum/${discussionId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Diskusi berhasil dihapus');
                window.location.href = '{{ route("teacher.forum.index") }}';
            } else {
                alert('Gagal menghapus diskusi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus diskusi');
        });
    }
}

function addReplyToUI(reply) {
    // Create reply element and add to replies list
    const repliesContainer = document.querySelector('.divide-y.divide-gray-200');
    const replyElement = document.createElement('div');
    replyElement.className = 'p-6';
    replyElement.innerHTML = `
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="${reply.author_avatar}" alt="${reply.author}">
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2">
                    <h3 class="text-sm font-medium text-gray-900">${reply.author}</h3>
                    <span class="text-sm text-gray-500">•</span>
                    <span class="text-sm text-gray-500">Baru saja</span>
                    ${reply.is_anonymous ? '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">Anonim</span>' : ''}
                </div>
                <div class="mt-2 text-sm text-gray-700">
                    ${reply.content.replace(/\n/g, '<br>')}
                </div>
                <div class="mt-4 flex items-center space-x-4">
                    <button onclick="likeReply(${reply.id})" 
                            class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Suka (0)
                    </button>
                    <button onclick="replyToReply(${reply.id})" 
                            class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        Balas
                    </button>
                </div>
            </div>
        </div>
    `;
    repliesContainer.appendChild(replyElement);
}
</script>
@endsection

