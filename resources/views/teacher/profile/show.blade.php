@extends('teacher.layouts.app')

@section('title', 'Profile Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Profile Guru</h1>
                <p class="text-gray-600 mt-1">Kelola informasi profile dan data pribadi Anda</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                    Edit Profile
                </a>
                <a href="{{ route('teacher.profile.portfolio') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200">
                    Portfolio
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <!-- Profile Picture -->
                <div class="text-center">
                    <div class="mx-auto w-32 h-32 rounded-full overflow-hidden bg-gray-100">
                        <img src="{{ $teacher->profile_picture_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ $teacher->full_name }}</h3>
                    <p class="text-gray-600">{{ $teacher->nip }}</p>
                    <p class="text-sm text-gray-500">{{ $teacher->employment_status }}</p>
                </div>

                <!-- Quick Stats -->
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Tahun Mengajar</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->teaching_years }} tahun</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Total Siswa</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->total_students }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Mata Pelajaran</span>
                        <span class="text-sm font-medium text-gray-900">{{ $teacher->subjects->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $teacher->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Profile Details -->
        <div class="lg:col-span-2">
            <!-- Tabs -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('personal')" id="tab-personal" class="tab-button py-4 px-1 border-b-2 border-blue-500 text-blue-600 text-sm font-medium">
                            Data Pribadi
                        </button>
                        <button onclick="showTab('employment')" id="tab-employment" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Data Kepegawaian
                        </button>
                        <button onclick="showTab('teaching')" id="tab-teaching" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Mengajar
                        </button>
                        <button onclick="showTab('documents')" id="tab-documents" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 text-sm font-medium">
                            Dokumen
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    <!-- Data Pribadi Tab -->
                    <div id="content-personal" class="tab-content">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIP</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->nip }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->nik ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->birth_place ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->birth_date ? $teacher->birth_date->format('d F Y') : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->gender == 'L' ? 'Laki-laki' : ($teacher->gender == 'P' ? 'Perempuan' : '-') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Agama</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->religion ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->address ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->phone ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Kepegawaian Tab -->
                    <div id="content-employment" class="tab-content hidden">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Kepegawaian</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->employment_status }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->join_date ? $teacher->join_date->format('d F Y') : '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tingkat Pendidikan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->education_level ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jurusan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->major ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Universitas</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->university ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tahun Lulus</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->graduation_year ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Sertifikasi</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $teacher->certification_number ?? '-' }}</p>
                                </div>
                            </div>
                            
                            @if($teacher->cv_path)
                            <div class="border-t border-gray-200 pt-6">
                                <label class="block text-sm font-medium text-gray-700">CV</label>
                                <div class="mt-2">
                                    <a href="{{ $teacher->cv_url }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Download CV
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mengajar Tab -->
                    <div id="content-teaching" class="tab-content hidden">
                        <div class="space-y-6">
                            <!-- Mata Pelajaran yang Diampu -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Mata Pelajaran yang Diampu</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse($teacher->subjects as $subject)
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $subject->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $subject->pivot->is_primary ? 'Utama' : 'Tambahan' }}</p>
                                            </div>
                                            @if($subject->pivot->is_primary)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Utama
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-span-2 text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada mata pelajaran</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada mata pelajaran yang diampu.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Kelas yang Diampu -->
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Kelas yang Diampu</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse($teacher->teachingClasses as $class)
                                    <div class="p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $class->name ?? 'Kelas' }}</p>
                                                <p class="text-xs text-gray-500">{{ $class->pivot->subject_id ? 'Mata Pelajaran' : 'Wali Kelas' }}</p>
                                            </div>
                                            @if($class->pivot->is_homeroom)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Wali Kelas
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-span-2 text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada kelas</h3>
                                        <p class="mt-1 text-sm text-gray-500">Belum ada kelas yang diampu.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Tab -->
                    <div id="content-documents" class="tab-content hidden">
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($teacher->documents as $document)
                                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $document->document_name }}</p>
                                            <p class="text-xs text-gray-500">{{ $document->document_type }}</p>
                                            <p class="text-xs text-gray-400">{{ $document->created_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($document->is_verified)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Terverifikasi
                                            </span>
                                            @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                            @endif
                                            <a href="{{ route('teacher.dokumen.download', $document->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-span-2 text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada dokumen</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada dokumen yang diupload.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });

    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');

    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection

