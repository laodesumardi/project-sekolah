@extends('student.layouts.app')

@section('title', 'Detail Pesan')
@section('description', 'Lihat detail pesan')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('student.messages.index') }}" 
                       class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Pesan
                    </a>
                </div>
                <div class="flex space-x-2">
                    <button onclick="markAsRead({{ $message->id }})" 
                            class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Tandai Dibaca
                    </button>
                    <button onclick="replyMessage()" 
                            class="inline-flex items-center px-3 py-1 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        Balas
                    </button>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="bg-white shadow rounded-lg">
            <!-- Message Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-start space-x-4">
                    <img class="h-12 w-12 rounded-full" src="{{ $message->from_avatar }}" alt="{{ $message->from }}">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <h1 class="text-lg font-medium text-gray-900">{{ $message->from }}</h1>
                            <span class="text-sm text-gray-500">{{ $message->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <h2 class="text-sm font-medium text-gray-600 mt-1">{{ $message->subject }}</h2>
                    </div>
                </div>
            </div>
            
            <!-- Message Body -->
            <div class="px-6 py-6">
                <div class="prose max-w-none">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                </div>
            </div>
            
            <!-- Message Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">
                            Diterima: {{ $message->created_at->diffForHumans() }}
                        </span>
                        @if($message->priority == 'high')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Prioritas Tinggi
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <button onclick="printMessage()" 
                                class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </button>
                        <button onclick="forwardMessage()" 
                                class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Teruskan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="reply-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Balas Pesan</h3>
                <button onclick="closeReplyModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="reply-form">
                @csrf
                <div class="mb-4">
                    <label for="reply-message" class="block text-sm font-medium text-gray-700">Pesan Balasan</label>
                    <textarea id="reply-message" name="message" rows="4" required 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeReplyModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Kirim Balasan
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
            alert('Pesan telah ditandai sebagai dibaca');
            // Update message count in header
            updateMessageCount();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function replyMessage() {
    document.getElementById('reply-modal').classList.remove('hidden');
}

function closeReplyModal() {
    document.getElementById('reply-modal').classList.add('hidden');
    document.getElementById('reply-form').reset();
}

function printMessage() {
    window.print();
}

function forwardMessage() {
    alert('Fitur terusan pesan akan segera tersedia');
}

// Reply form submission
document.getElementById('reply-form').addEventListener('submit', function(e) {
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
            alert('Balasan berhasil dikirim!');
            closeReplyModal();
        } else {
            alert('Gagal mengirim balasan: ' + (data.message || 'Terjadi kesalahan'));
        }
        button.innerHTML = originalText;
        button.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim balasan');
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
</script>
@endsection




