@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Pendaftar</h1>
            <p class="text-gray-600 mt-2">Informasi lengkap pendaftaran pengguna</p>
        </div>
        <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.user-registrations.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- User Information -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-16 w-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-white">{{ $userRegistration->full_name }}</h2>
                        <p class="text-blue-100">{{ $userRegistration->email }}</p>
                        <p class="text-blue-200 text-sm">{{ $userRegistration->registration_number }}</p>
                    </div>
                </div>
                <div class="text-right">
                    {!! $userRegistration->status_badge !!}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-600 mr-2"></i>
                        Informasi Pribadi
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->full_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->phone }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->birth_place ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->formatted_birth_date ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->gender_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->address ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->city ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->province ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->postal_code ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-graduation-cap text-green-600 mr-2"></i>
                        Informasi Tambahan
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipe Pendaftaran</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($userRegistration->registration_type === 'student')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-user-graduate mr-1"></i>
                                        Siswa
                                    </span>
                                @elseif($userRegistration->registration_type === 'parent')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-users mr-1"></i>
                                        Orang Tua
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        Guru
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if($userRegistration->registration_type === 'student')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->school_origin ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->graduation_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NISN</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->nisn ?? '-' }}</p>
                        </div>
                        @endif

                        @if($userRegistration->registration_type === 'parent')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hubungan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->relation_type ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->occupation ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->student_name ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIS Siswa</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->student_nis ?? '-' }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Verifikasi</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($userRegistration->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Details -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                    Detail Pendaftaran
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Daftar</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">IP Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $userRegistration->ip_address ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">User Agent</label>
                        <p class="mt-1 text-sm text-gray-900">{{ Str::limit($userRegistration->user_agent ?? '-', 50) }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    @if($userRegistration->status === 'pending')
                    <button onclick="approveRegistration({{ $userRegistration->id }})" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-check mr-2"></i>
                        Setujui
                    </button>
                    <button onclick="rejectRegistration({{ $userRegistration->id }})" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Tolak
                    </button>
                    @endif
                    
                    <button onclick="deleteRegistration({{ $userRegistration->id }})" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pendaftaran</h3>
            <form id="approveForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pendaftaran</h3>
            <form id="rejectForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                    <textarea name="rejection_reason" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Berikan alasan penolakan" required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function approveRegistration(id) {
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('approveForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(`/admin/user-registrations/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                notes: formData.get('notes')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    };
}

function rejectRegistration(id) {
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectForm').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(`/admin/user-registrations/${id}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                rejection_reason: formData.get('rejection_reason')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    };
}

function deleteRegistration(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')) {
        fetch(`/admin/user-registrations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/admin/user-registrations';
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveForm').reset();
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectForm').reset();
}
</script>
@endsection
