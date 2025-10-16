<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - SMP Negeri 01 Namrole</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <!-- Success Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">
                <!-- Success Icon -->
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check text-4xl text-green-600"></i>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Pendaftaran Berhasil!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Terima kasih telah mendaftar. Data pendaftaran Anda telah berhasil disimpan.
                </p>

                <!-- Registration Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
                    <h3 class="font-semibold text-lg mb-4 text-center">Detail Pendaftaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Nomor Pendaftaran:</span>
                            <p class="text-lg font-bold text-primary-500">{{ $registration->registration_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Nama Lengkap:</span>
                            <p class="text-base text-gray-900">{{ $registration->full_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Email:</span>
                            <p class="text-base text-gray-900">{{ $registration->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Tipe Pendaftaran:</span>
                            <p class="text-base text-gray-900">
                                {{ $registration->registration_type === 'student' ? 'Siswa' : 'Orang Tua/Wali' }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Status:</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 font-medium">Tanggal Pendaftaran:</span>
                            <p class="text-base text-gray-900">{{ $registration->created_at->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-lg mb-4 text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i>Langkah Selanjutnya
                    </h3>
                    <div class="space-y-3 text-sm text-blue-700">
                        <div class="flex items-start">
                            <i class="fas fa-envelope mr-3 mt-1"></i>
                            <div>
                                <p class="font-medium">1. Verifikasi Email</p>
                                <p>Kami telah mengirim email verifikasi ke <strong>{{ $registration->email }}</strong>. Silakan cek inbox atau folder spam Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-clock mr-3 mt-1"></i>
                            <div>
                                <p class="font-medium">2. Menunggu Persetujuan</p>
                                <p>Admin akan memeriksa data pendaftaran Anda. Proses ini memakan waktu 1-3 hari kerja.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-bell mr-3 mt-1"></i>
                            <div>
                                <p class="font-medium">3. Notifikasi Persetujuan</p>
                                <p>Anda akan menerima notifikasi melalui email setelah pendaftaran disetujui atau ditolak.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/register/status" 
                       class="flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-semibold">
                        <i class="fas fa-search mr-2"></i>
                        Cek Status Pendaftaran
                    </a>
                    <a href="/" 
                       class="flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:border-gray-400 transition-colors duration-200 font-semibold">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-2">Butuh bantuan?</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            <span>+62 812-3456-7890</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@smpnegeri01namrole.sch.id</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
