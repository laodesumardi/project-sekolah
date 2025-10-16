<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek Status Pendaftaran - SMP Negeri 01 Namrole</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            100: '#e0e9ff',
                            500: '#13315c',
                            600: '#0f2650',
                            700: '#0b1a44'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen" style="background: linear-gradient(135deg, #13315c 0%, #1e4d8b 100%);">
    <div class="min-h-screen flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <i class="fas fa-search text-4xl text-primary-500"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Cek Status Pendaftaran</h1>
                <p class="text-sm text-white opacity-80">Masukkan nomor pendaftaran dan email untuk melihat status</p>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
                <!-- Search Form -->
                <div x-data="statusChecker()" class="space-y-6">
                    <form @submit.prevent="checkStatus" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-2 text-primary-500"></i>Nomor Pendaftaran *
                            </label>
                            <input type="text" x-model="form.registration_number" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Contoh: REG20240001">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-primary-500"></i>Email *
                            </label>
                            <input type="email" x-model="form.email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="contoh@email.com">
                        </div>

                        <button type="submit" :disabled="loading"
                                class="w-full flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                            <i x-show="!loading" class="fas fa-search mr-2"></i>
                            <i x-show="loading" class="fas fa-spinner fa-spin mr-2"></i>
                            <span x-text="loading ? 'Mencari...' : 'Cek Status'"></span>
                        </button>
                    </form>

                    <!-- Loading State -->
                    <div x-show="loading" class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-primary-500 mb-4"></i>
                        <p class="text-gray-600">Sedang mencari data pendaftaran...</p>
                    </div>

                    <!-- Error State -->
                    <div x-show="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <div>
                                <h3 class="text-sm font-semibold text-red-800">Data Tidak Ditemukan</h3>
                                <p class="text-sm text-red-700" x-text="error"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Success State -->
                    <div x-show="registration" class="space-y-6">
                        <!-- Status Card -->
                        <div class="bg-white border-2 border-gray-200 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Status Pendaftaran</h3>
                                <div x-html="registration.status_badge"></div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Nomor Pendaftaran:</span>
                                    <p class="text-lg font-bold text-primary-500" x-text="registration.registration_number"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Nama Lengkap:</span>
                                    <p class="text-base text-gray-900" x-text="registration.full_name"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Email:</span>
                                    <p class="text-base text-gray-900" x-text="registration.email"></p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-600 font-medium">Tanggal Pendaftaran:</span>
                                    <p class="text-base text-gray-900" x-text="registration.created_at"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information -->
                        <div x-show="registration.status === 'pending'" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-clock text-yellow-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-sm font-semibold text-yellow-800">Menunggu Verifikasi</h3>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Pendaftaran Anda sedang dalam proses verifikasi. Admin akan memeriksa data Anda dalam 1-3 hari kerja.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div x-show="registration.status === 'verified'" class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-sm font-semibold text-blue-800">Terverifikasi</h3>
                                    <p class="text-sm text-blue-700 mt-1">
                                        Data Anda telah diverifikasi. Menunggu persetujuan final dari admin.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div x-show="registration.status === 'approved'" class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-sm font-semibold text-green-800">Disetujui</h3>
                                    <p class="text-sm text-green-700 mt-1">
                                        Selamat! Pendaftaran Anda telah disetujui. Akun Anda telah dibuat dan Anda dapat login menggunakan email dan password yang telah didaftarkan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div x-show="registration.status === 'rejected'" class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-times-circle text-red-600 mr-3 mt-1"></i>
                                <div>
                                    <h3 class="text-sm font-semibold text-red-800">Ditolak</h3>
                                    <p class="text-sm text-red-700 mt-1">
                                        Maaf, pendaftaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button @click="checkStatus()" 
                                    class="flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-semibold">
                                <i class="fas fa-refresh mr-2"></i>
                                Refresh Status
                            </button>
                            <a href="/register" 
                               class="flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 transition-colors duration-200 font-semibold">
                                <i class="fas fa-user-plus mr-2"></i>
                                Daftar Baru
                            </a>
                            <a href="/" 
                               class="flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 transition-colors duration-200 font-semibold">
                                <i class="fas fa-home mr-2"></i>
                                Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function statusChecker() {
            return {
                form: {
                    registration_number: '',
                    email: ''
                },
                loading: false,
                error: null,
                registration: null,

                async checkStatus() {
                    this.loading = true;
                    this.error = null;
                    this.registration = null;

                    try {
                        const response = await fetch('/register/status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.registration = data.registration;
                        } else {
                            this.error = data.message;
                        }
                    } catch (error) {
                        this.error = 'Terjadi kesalahan saat mengecek status. Silakan coba lagi.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
