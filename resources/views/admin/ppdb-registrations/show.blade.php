@extends('admin.layouts.app')

@section('title', 'Detail Pendaftar PPDB')

@section('content')
<div class="p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Detail Pendaftar PPDB</h1>
                <p class="text-gray-600 mt-1">Informasi lengkap pendaftar {{ $ppdbRegistration->full_name }}</p>
            </div>
            <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.ppdb-registrations.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                @if($ppdbRegistration->status === 'pending' || $ppdbRegistration->status === 'verified')
                <button onclick="approveRegistration({{ $ppdbRegistration->id }})" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-check mr-2"></i>
                    Setujui
                </button>
                <button onclick="rejectRegistration({{ $ppdbRegistration->id }})" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Tolak
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Data Pribadi -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-user text-blue-600 mr-2"></i>
                    Data Pribadi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->phone }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIK</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat, Tanggal Lahir</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->birth_place }}, {{ $ppdbRegistration->formatted_birth_date }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->gender_name }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->address }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kota</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->city }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->province }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Pendidikan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                    Data Pendidikan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->school_origin }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->graduation_year }}</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen Upload -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-file-upload text-blue-600 mr-2"></i>
                    Dokumen Persyaratan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($ppdbRegistration->photo_3x4)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto 3x4</label>
                        <div class="flex items-center space-x-3">
                            <img src="{{ Storage::url($ppdbRegistration->photo_3x4) }}" alt="Foto 3x4" class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->photo_3x4) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>Lihat
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Foto berwarna 3x4</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ppdbRegistration->birth_certificate)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Akta Kelahiran</label>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->birth_certificate) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Akta kelahiran</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ppdbRegistration->family_card)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga</label>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-id-card text-blue-500 text-2xl"></i>
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->family_card) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Kartu keluarga</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ppdbRegistration->diploma)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ijazah SD/MI</label>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-graduation-cap text-green-500 text-2xl"></i>
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->diploma) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Ijazah SD/MI</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ppdbRegistration->report_card)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rapor SD/MI</label>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->report_card) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Rapor SD/MI</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($ppdbRegistration->parent_id_card)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">KTP Orang Tua</label>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-id-badge text-purple-500 text-2xl"></i>
                            <div>
                                <a href="{{ Storage::url($ppdbRegistration->parent_id_card) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                                <p class="text-xs text-gray-500 mt-1">KTP orang tua</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pendaftaran</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            {!! $ppdbRegistration->status_badge !!}
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Pendaftaran</label>
                        <p class="text-sm text-gray-900 font-mono">{{ $ppdbRegistration->registration_number }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    @if($ppdbRegistration->approved_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Disetujui</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->approved_at->format('d F Y, H:i') }}</p>
                    </div>
                    
                    @if($ppdbRegistration->approver)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Disetujui Oleh</label>
                        <p class="text-sm text-gray-900">{{ $ppdbRegistration->approver->name }}</p>
                    </div>
                    @endif
                    @endif
                    
                    @if($ppdbRegistration->rejection_reason)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                        <p class="text-sm text-red-600">{{ $ppdbRegistration->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($ppdbRegistration->status === 'pending' || $ppdbRegistration->status === 'verified')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                
                <div class="space-y-3">
                    <button onclick="approveRegistration({{ $ppdbRegistration->id }})" 
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-check mr-2"></i>
                        Setujui Pendaftaran
                    </button>
                    
                    <button onclick="rejectRegistration({{ $ppdbRegistration->id }})" 
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Tolak Pendaftaran
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pendaftaran PPDB</h3>
            <form id="approveForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Tambahkan catatan untuk pendaftar..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pendaftaran PPDB</h3>
            <form id="rejectForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                    <textarea name="rejection_reason" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Berikan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentRegistrationId = null;

// Individual actions
function approveRegistration(id) {
    currentRegistrationId = id;
    document.getElementById('approveModal').classList.remove('hidden');
}

function rejectRegistration(id) {
    currentRegistrationId = id;
    document.getElementById('rejectModal').classList.remove('hidden');
}

// Modal functions
function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveForm').reset();
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}

// Form submissions
document.getElementById('approveForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const notes = formData.get('notes');
    
    fetch(`/admin/ppdb-registrations/${currentRegistrationId}/approve`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ notes: notes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});

document.getElementById('rejectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const rejection_reason = formData.get('rejection_reason');
    
    fetch(`/admin/ppdb-registrations/${currentRegistrationId}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ rejection_reason: rejection_reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});
</script>
@endsection
