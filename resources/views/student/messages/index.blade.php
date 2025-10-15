@extends('student.layouts.app')

@section('title', 'Pesan')
@section('description', 'Kelola pesan Anda')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pesan</h1>
                    <p class="mt-2 text-gray-600">Kelola semua pesan Anda</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="markAllAsRead()" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Semua Dibaca
                    </button>
                    <button onclick="openComposeModal()" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Kirim Pesan
                    </button>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white shadow rounded-lg">
            @if($messages->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($messages as $message)
                        <div class="p-6 hover:bg-gray-50 {{ !$message->is_read ? 'bg-blue-50 border-l-4 border-blue-400' : '' }}">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ $message->from_avatar }}" alt="{{ $message->from }}">
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $message->from }}</h3>
                                            @if($message->priority == 'high')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Penting
                                                </span>
                                            @endif
                                            @if($message->type == 'teacher')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    Guru
                                                </span>
                                            @elseif($message->type == 'homeroom')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Wali Kelas
                                                </span>
                                            @elseif($message->type == 'admin')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                    Admin
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if(!$message->is_read)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Baru
                                                </span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <h4 class="mt-1 text-sm font-medium text-gray-900">{{ $message->subject }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ Str::limit($message->message, 100) }}</p>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex-shrink-0 flex space-x-2">
                                    <a href="{{ route('student.messages.show', $message->id) }}" 
                                       class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Baca
                                    </a>
                                    @if(!$message->is_read)
                                        <button onclick="markAsRead({{ $message->id }})" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Tandai Dibaca
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pesan</h3>
                    <p class="mt-1 text-sm text-gray-500">Anda belum memiliki pesan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Compose Modal -->
<div id="compose-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Kirim Pesan</h3>
                <button onclick="closeComposeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="compose-form">
                @csrf
                <div class="mb-4">
                    <label for="to" class="block text-sm font-medium text-gray-700">Kepada</label>
                    <select id="to" name="to" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih penerima</option>
                        <option value="teacher">Guru</option>
                        <option value="homeroom">Wali Kelas</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subjek</label>
                    <input type="text" id="subject" name="subject" required 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                    <textarea id="message" name="message" rows="4" required 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeComposeModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function markAsRead(messageId) {
    fetch(`/siswa/pesan/${messageId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove "Baru" badge and update UI
            const message = document.querySelector(`[data-message-id="${messageId}"]`);
            if (message) {
                message.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-400');
                const badge = message.querySelector('.bg-blue-100');
                if (badge) badge.remove();
            }
            // Update message count in header
            updateMessageCount();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function markAllAsRead() {
    if (confirm('Apakah Anda yakin ingin menandai semua pesan sebagai dibaca?')) {
        fetch('/siswa/pesan/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function openComposeModal() {
    document.getElementById('compose-modal').classList.remove('hidden');
}

function closeComposeModal() {
    document.getElementById('compose-modal').classList.add('hidden');
    document.getElementById('compose-form').reset();
}

// Compose form submission
document.getElementById('compose-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim...';
    button.disabled = true;
    
    fetch('/siswa/pesan', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pesan berhasil dikirim!');
            closeComposeModal();
        } else {
            alert('Gagal mengirim pesan: ' + (data.message || 'Terjadi kesalahan'));
        }
        button.innerHTML = originalText;
        button.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pesan');
        button.innerHTML = originalText;
        button.disabled = false;
    });
});

function updateMessageCount() {
    fetch('/siswa/pesan/unread-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('#message-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            }
        });
}

// Auto-refresh message count every 30 seconds
setInterval(updateMessageCount, 30000);
</script>
@endsection




